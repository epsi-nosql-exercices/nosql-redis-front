<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class HomeController extends Controller
{

    private $api_url;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_url = getenv("API_URL");
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        $request = $client->get($this->api_url.'utilisateurs', ['exceptions' => FALSE]);

        $users = [];
        $followings = [];

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $collection = collect($response);
            $users = $collection->pluck('uuid', 'pseudo');
            $currentUuid = session('user_uuid');
            //dd($users);
            $users = $users->reject(function($uuid) use ($currentUuid) {
                return ($uuid == $currentUuid);
            });
        }

        if (session('user_uuid')) {
            $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

            if ($request->getStatusCode() == 200) {
                $response = json_decode($request->getBody());
                $followings = $response->listeFollowing;
            }
        }

        return view('home', compact(['users', 'followings']));
    }

}
