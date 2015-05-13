@extends('app')

@section('content')

     <h1>Nauja transporto kategorija</h1>
        <hr/>

        {!! Form::open() !!}
            <div class="form-group">
                {!! Form::label('auto_type', 'Transporto kategorija: ') !!}
                {!! Form::text('auto_type', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit('Išsaugoti į duomenų bazę', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}

@endsection