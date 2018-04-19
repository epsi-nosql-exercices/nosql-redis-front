@forelse($messages as $message)
    @php($dateTime = $message->dateTime)
    <div class="media">
        <a class="media-left" href="#fake">
            <img alt="" class="media-object img-rounded" src="http://placehold.it/64x64">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{!! $message->pseudoUtilisateur !!}
                <span class="date">
                    {!! $dateTime->year.'-'.$dateTime->monthValue.'-'.$dateTime->dayOfMonth.' '.sprintf('%02d:%02d', $dateTime->hour, $dateTime->minute) !!}
                </span>
            </h4>
            <p>{!! $message->contenu !!}</p>
            <ul class="nav nav-pills nav-pills-custom">
            </ul>
        </div>
    </div>
@empty
    <div class="media-empty">
        <span>You didn't post anything yet.</span>
    </div>
@endforelse

{{ $messages->links() }}