<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as loginApi;
        sendLoginResponse as sendLoginResponseApi;
        logout as logoutApi;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $api_url;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_url = getenv("API_URL");
        $this->middleware('guest')->except('logout');
    }

    public function loginApi (Request $request) {
        $this->validateLoginApi($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $client = new Client();

        $postRequest = $client->post(
            $this->api_url.'utilisateur/auth?pseudo='.$request['name'].'&motDePasse='.$request['password'],
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'exceptions' => FALSE
            ]
        );

        if ($postRequest->getStatusCode() == 200) {
            $response = json_decode($postRequest->getBody());
            $messages = $response->listeMessage;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);
            session()->put('user_uuid', $response->uuid);
            session()->put('user_name', $response->pseudo);

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLoginApi(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
        session()->forget('user_uuid');
        session()->forget('user_name');

        $request->session()->invalidate();

        return redirect('/');
    }

}
