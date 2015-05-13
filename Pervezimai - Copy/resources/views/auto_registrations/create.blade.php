@extends('app')

@section('content')

    <h1>Automobilio registracija</h1>
    <hr/>

    {!! Form::open(['url' => 'auto_registrations']) !!}
        @include('auto_registrations.form')
    {!! Form::close() !!}
@endsection