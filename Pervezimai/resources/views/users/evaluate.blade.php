@extends('app')

@section('content')
    <div class="container">
        <div class="well text-center">
            <h1> Įvertinkite vartotoją</h1>
        </div>
        <div class="col-sm-12">
            {!! Form::open('action' => 'EvaluationsController@store') !!}
                {!!  !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection