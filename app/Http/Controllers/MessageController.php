<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Requests\MessageRequest;

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

    public function index() {

        return view('message.index');
    }

    public function write() {

        return view('message.form');
    }

    public function post(Client $client, MessageRequest $request) {

        $postRequest = $client->put($this->api_url.'message', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'uuid' => session('user_uuid'),
                'contenu' => $request['message']
            ],
            'exceptions' => false
        ]);

        if ($postRequest->getStatusCode() != 200) {
            session()->flash('warning', 'Network error. Tweet was not posted.');
        }

        return redirect(route('profile'));
    }
}
