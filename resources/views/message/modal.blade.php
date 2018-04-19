@php
    $message = new App\Message();
@endphp

{!! Form::open(['url' => route('message.post')]) !!}

    {!! TwitterControlGroup::generate(
        TwitterForm::label('message', 'Tweet'),
        TwitterForm::text('message'),
        TwitterButton::primary('Tweeter')->submit()
    )!!}

{!! Form::close() !!}

