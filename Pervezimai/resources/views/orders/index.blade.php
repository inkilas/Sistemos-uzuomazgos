@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Mano užsakymai</h1>
        </div>

        <a  href="{{ action('OrdersController@clientindex') }}">
            <div class="well text-center">
                <h2>Mano pateikti užsakymai</h2>
            </div>
        </a>
        <a  href="{{ action('OrdersController@providerindex') }}">
            <div class="well text-center">
                <h2>Man pateikti užsakymai</h2>
            </div>
        </a>
    </div>

@endsection