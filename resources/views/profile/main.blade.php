@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {!! TwitterModal::named('Tweeter')
                         ->withTitle('Write a tweet')
                         ->withBody(
                            view('message.modal')
                         )
                         ->withButton(TwitterButton::primary('Tweet'))
                     !!}
                    <div class="panel-heading">
                        {!! TwitterNavigation::pills([
                            [
                                'title' => '<span>Tweets</span>
                                            <span>'.count($messages).'</span>',
                                'link' => route('profile')
                            ],
                            [
                                'title' => '<span>Following</span>
                                            <span>'.$nbFollowing.'</span>',
                                'link' => route('profile.following')
                            ],
                            [
                                'title' => '<span>Followers</span>
                                            <span>'.$nbFollowers.'</span>',
                                'link' => route('profile.followers')
                            ],
                        ],
                        ['class' => 'nav-profile']) !!}
                    </div>

                    <div class="panel-body">
                        @include('profile.'.$mode, ['messages' => $messages])
                    </div>
                </div>

                <ul>
                    <li>Display My Tweets (with pagination)</li>
                    <li>Display my number of followers/following/tweets</li>
                    <li>Write a tweet</li>
                </ul>

            </div>
        </div>
    </div>

@endsection