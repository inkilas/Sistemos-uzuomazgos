@extends('app')

@section('content')
    <div class="container">
    @foreach($order as $one_order)
        <div class="well well-lg text-center">
            <h1>Užsakymas</h1>
        </div>
    @endforeach
    </div>

@endsection