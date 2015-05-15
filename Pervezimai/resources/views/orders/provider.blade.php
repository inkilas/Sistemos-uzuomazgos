@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Man pateikti užsakymai</h1>
        </div>
        @foreach($orders as $key => $order)
            <a href="{{ url('orders/provider', $order->order_key)}}/{{ $order->id }}">{{ $order->order_key }} | {{ $order->order_date }} | {{ $order->pickup_address }} | {{ $order->auto_registration->auto_name }}</a> <br>
        @endforeach

    </div>

@endsection