@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>{{ $auto->auto_name }}</h1>
        </div>

        <div>

        </div>

        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-primary form-control" href="{{ action('Auto_registrationsController@edit', [$auto->id]) }}"><span class="glyphicon glyphicon-edit"></span> Redaguoti</a>
            </div>
            <div class="col-sm-6">
                 <a class="btn btn-primary-red form-control " href=""><span class="glyphicon glyphicon-remove"></span> Ištrinti </a>
            </div>
        </div>
    </div>

@endsection