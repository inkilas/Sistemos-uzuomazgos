@extends('app')

@section('content')

    <h1>Users</h1>

    @foreach($users as $user)

        <ul>
            <li>{{ $user->name }}</li>
            <li>{{ $user->surname }}</li>
            <li>{{ $user->email }}</li>
        </ul>

    @endforeach 
@endsection