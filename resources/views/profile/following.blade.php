@forelse($followings as $following)
    <div class="media col-xs-12 col-sm-4">
        <div class="media-body">
            <h4 class="media-heading">{!! $user !!}</h4>
            <ul class="nav nav-pills nav-pills-custom">
                <li><a href="#"><span class="glyphicon glyphicon-share-alt"></span></a></li>
            </ul>
        </div>
        user : {{$user}}
    </div>
@empty
    <div class="media-empty">
        <span>You don't follow anyone yet.</span>
    </div>
@endforelse