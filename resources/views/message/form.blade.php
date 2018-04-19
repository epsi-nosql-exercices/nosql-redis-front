@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Twitter</div>

                    <div class="panel-body">

                        {!! TwitterModal::named('Tweeter')
                             ->withTitle('Écrire un nouveau Tweet')
                             ->withBody(
                                view('message.modal')
                             )
                             ->withFooter('Example modal footer')
                             ->withButton()
                         !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection