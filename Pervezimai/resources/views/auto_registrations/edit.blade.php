@extends('app')

@section('content')

    <h1>Keisti transporto priemonės {{ $auto->auto_name }} duomenis</h1>
    <hr/>

    {!! Form::model($auto, ['method' => 'PATCH', 'action' => ['Auto_registrationsController@update', $auto->id]]) !!}
        @include('auto_registrations.form')
    {!! Form::close() !!}

@endsection