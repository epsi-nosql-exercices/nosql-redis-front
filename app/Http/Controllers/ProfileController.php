<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
            $messages = array_reverse($response->listeMessage);
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);

            $messages = $this->paginate($messages, 5);
            $messages->withPath(route('profile'));

            //dd($messages);
            $mode = 'messages';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing']));
        }
    }

    public function following(Client $client) {

        $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

        $followings = [];

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $messages = $response->listeMessage;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($response->listeFollowing);

            foreach($response->listeFollowing as $uuid) {
                $request = $client->get($this->api_url.'utilisateur?uuid='.$uuid, ['exceptions' => FALSE]);
                if ($request->getStatusCode() == 200) {
                    $response = json_decode($request->getBody());
                    $followings[$uuid] = $response->pseudo;
                }
            }

            $mode = 'following';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing', 'followings']));
        }
    }

    public function followers(Client $client) {

        $request = $client->get($this->api_url.'utilisateur?uuid='.session('user_uuid'), ['exceptions' => FALSE]);

        $followers = [];

        if ($request->getStatusCode() == 200) {
            $response = json_decode($request->getBody());
            $messages = $response->listeMessage;
            $followings = $response->listeFollowing;
            $nbFollowers = count($response->listeFollower);
            $nbFollowing = count($followings);

            foreach($response->listeFollower as $uuid) {
                $request = $client->get($this->api_url.'utilisateur?uuid='.$uuid, ['exceptions' => FALSE]);
                if ($request->getStatusCode() == 200) {
                    $response = json_decode($request->getBody());
                    $followers[$uuid] = $response->pseudo;
                }
            }

            $mode = 'followers';
            return view('profile.main', compact(['mode', 'messages', 'nbFollowers', 'nbFollowing', 'followers', 'followings']));
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

        return redirect('/');
    }

    public function unfollow(Client $client) {

        $uuid = request('uuid');

        $request = $client->delete($this->api_url.'follow', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'uuidFollower' => session('user_uuid'),
                'uuidFollowing' => request('uuid')
            ],
            'exceptions' => false
        ]);

        return back();
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
