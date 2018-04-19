@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                    @forelse($users as $pseudo => $uuid)
                        <div class="col-xs-12 col-sm-4">
                            <div class="media-body">
                                <h4 class="media-heading">{!! $pseudo !!}</h4>
                                @if(session('user_uuid'))
                                    <ul class="nav nav-pills nav-pills-custom">
                                        <li>
                                            @if(in_array($uuid, $followings))
                                                {!! Form::open(['url' => route('unfollow')]) !!}
                                                {!! Form::hidden('uuid', $uuid) !!}
                                                {!! TwitterButton::danger('Unfollow')->submit() !!}
                                                {!! Form::close() !!}
                                            @else
                                                {!! Form::open(['url' => route('follow')]) !!}
                                                {!! Form::hidden('uuid', $uuid) !!}
                                                {!! TwitterButton::primary('Follow')->submit() !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @empty
                            <div class="media-empty">
                                Welcome to our Twitter exercice. Please proceed to user registration.
                            </div>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
