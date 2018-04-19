<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Requests\MessageRequest;
use App\Helper\Paginator;

class MessageController extends Controller
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

    public function post(Client $client, MessageRequest $request) {

        $putRequest = $client->put($this->api_url.'message', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'uuid' => session('user_uuid'),
                'contenu' => $request['message']
            ],
            'exceptions' => false
        ]);

        if ($putRequest->getStatusCode() != 200) {
            session()->flash('warning', 'Network error. Tweet was not posted.');
        }

        return redirect(route('profile'));
    }

    public function hashtagSearch(Client $client, SearchRequest $request, Paginator $paginator) {

        if (preg_match('/^#{1}([^\s\#]+)/', $request['search'], $matches)) {
            $getRequest = $client->get($this->api_url.'message/hashtag?hashtag='.$matches[1], ['exceptions' => FALSE]);

            if ($getRequest->getStatusCode() == 200) {
                $response = json_decode($getRequest->getBody());
                $messages = array_reverse($response);
                $messages = $paginator->paginate($messages, 100);
                $messages->withPath(route('message.hashtagSearch'));
            }
        }

        return view('message.hashtag', compact(['messages']));
    }
}
