@extends('app')

@section('content')

    <h1>Nauja kategorija</h1>
    <hr/>

    {!! Form::open(['url' => 'categories']) !!}
        <div class="form-group">
            {!! Form::label('category', 'Pervežimo Kategorija: ') !!}
            {!! Form::text('category', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Išsaugoti į duomenų bazę', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    {!! Form::close() !!}
@endsection