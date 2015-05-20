@extends('app')

@section('content')
    <div class="container">
        <div class="well text-center">
            <h1>Automobilio registracija</h1>
        </div>

        <div class="col-sm-12">
            {!! Form::open(['url' => 'auto_registrations']) !!}
                @include('auto_registrations.form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection