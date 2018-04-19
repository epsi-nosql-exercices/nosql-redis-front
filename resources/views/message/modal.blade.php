@php
    $message = new App\Message();
@endphp

    {!! TwitterForm::horizontalModel($message, ['route' => ['message.post', $message->id]]) !!}

    {!! TwitterControlGroup::generate(
        TwitterForm::label('message', 'Tweet'),
        TwitterForm::text('message'),
        TwitterButton::primary('Tweeter')->submit()
    )!!}

