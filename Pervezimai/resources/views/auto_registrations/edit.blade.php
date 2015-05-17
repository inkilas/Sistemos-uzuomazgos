@extends('app')

@section('content')
    <div class="container">
        <div class="well text-center">
            <h1>Keisti transporto priemonės {{ $auto->auto_name }} duomenis</h1>
        </div>
        <div class="col-sm-12">
            {!! Form::model($auto, ['method' => 'PATCH', 'action' => ['Auto_registrationsController@update', $auto->id]]) !!}
                @include('auto_registrations.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection