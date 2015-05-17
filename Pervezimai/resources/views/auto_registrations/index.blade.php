@extends('app')

@section('content')
    <div class="container">
        <h1>Jūsų užregistruoti automobiliai</h1>

        <h3><a href="{{ action('Auto_registrationsController@create') }}">Pridėti automobilį</a></h3> <br>

        @foreach($autos as $auto)

          <a href="{{ action('Auto_registrationsController@show', [$auto->id]) }}">{{ $auto->auto_name }}</a> <br>

        @endforeach
    </div>
@endsection