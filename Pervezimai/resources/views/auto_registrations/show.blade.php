@extends('app')

@section('content')

    <h1>{{ $auto->auto_name }}</h1>
    <div>
        <a href="{{ action('Auto_registrationsController@edit', [$auto->id]) }}">Redaguoti</a>
    </div>

@endsection