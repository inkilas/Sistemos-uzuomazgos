@extends('app')

@section('content')

    <h1>Users</h1>

    @foreach($users as $user)
        <ul>
            <li>{{ $user->name }}</li>
            <li>{{ $user->surname }}</li>
            <li>{{ $user->email }}</li>
            <li>
                {!! Form::open(['method' => 'DELETE', 'url' => 'users/' . $user->id]) !!}
                    {!! Form::submit('Ištrinti vežėją', ['id' => 'delete', 'class' => 'btn btn-primary-red form-control']) !!}
                {!! Form::close() !!}
            </li>
        </ul>
        <br>
    @endforeach 
@endsection