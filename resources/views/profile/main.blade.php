@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-heading">
                        {!! TwitterNavigation::pills([
                            [
                                'title' => '<span>Feed</span>',
                                'link' => route('profile')
                            ],
                            [
                                'title' => '<span>Tweets</span>
                                            <span>'.$nbMessages.'</span>',
                                'link' => route('profile.self')
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
                        {!! TwitterModal::named('Tweeter')
                         ->withTitle('Write a tweet')
                         ->withBody(
                            view('message.modal')
                         )
                         ->withButton(TwitterButton::primary('Tweet'))
                     !!}
                    </div>

                    <div class="panel-body">
                        @include('profile.'.$mode, ['messages' => $messages])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection