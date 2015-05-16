@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Mano pateikti užsakymai</h1>
        </div>

        @for($key = 0; $key < $last_key; $key++)
            @if($orders[$key]->order_key == $orders[$key++]->order_key)
                <a href="{{ action('OrdersController@showclient', [$orders[$key]->order_key]) }}">{{ $orders[$key]->order_key }} |  {{ $orders[$key]->order_date }} | {{ $orders[$key]->pickup_address }}</a> <br>
            @endif
        @endfor

    </div>

@endsection