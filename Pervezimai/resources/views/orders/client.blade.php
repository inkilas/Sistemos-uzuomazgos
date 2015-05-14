@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Mano pateikti užsakymai</h1>
        </div>

        @foreach($orders as $order)
                <a href="{{ action('OrdersController@showclient', [$order->order_key]) }}">{{ $order->order_date }} | {{ $order->pickup_address }}</a> <br>
        @endforeach

    </div>

@endsection