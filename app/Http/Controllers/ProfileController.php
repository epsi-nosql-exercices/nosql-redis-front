<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProfileController extends Controller
{

    private $api_url;

    public function __construct()
    {
        $this->api_url = getenv("API_URL");
        //$this->middleware('auth');
        if (!session('user_uuid')) {
            return redirect('/');
        }
    }

    public function index(Client $client) {

        $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $messages = $response->listeMessage;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);

            $mode = 'messages';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing']));
        }
    }

    public function following(Client $client) {

        $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $messages = $response->listeMessage;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);
            $followings = $response->listeFollowing;

            $mode = 'following';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing', 'followings']));
        }
    }

    public function followers(Client $client) {

        $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $messages = $response->listeMessage;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);
            $followers = $response->listeFollower;

            $mode = 'followers';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing', 'followers']));
        }
    }

    public function follow(Client $client) {

        $uuid = request('uuid');

        $request = $client->put($this->api_url.'follow', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'uuidFollower' => session('user_uuid'),
                'uuidFollowing' => request('uuid')
            ],
            'exceptions' => false
        ]);
    }
}
