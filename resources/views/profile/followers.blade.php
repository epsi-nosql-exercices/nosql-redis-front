@forelse($followers as $uuid => $pseudo)
    <div class="col-xs-12 col-sm-4">
        <div class="media-body">
            <h4 class="media-heading">{!! $pseudo !!}</h4>
            @if(session('user_uuid'))
                <ul class="nav nav-pills nav-pills-custom">
                    <li>
                        @if(in_array($uuid, $followings))
                            {!! Form::open(['url' => route('unfollow')]) !!}
                            {!! Form::hidden('uuid', $uuid) !!}
                            {!! TwitterButton::danger('Unfollow')->submit('b') !!}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['url' => route('follow')]) !!}
                            {!! Form::hidden('uuid', $uuid) !!}
                            {!! TwitterButton::primary('Follow')->submit('a') !!}
                            {!! Form::close() !!}
                        @endif
                    </li>
                </ul>
            @endif
        </div>
    </div>
@empty
    <div class="media-empty">
        <span>You don't follow anyone yet.</span>
    </div>
@endforelse