@extends('app')

@section('content')
    <div class="container">
        <div class="well text-center">
            <h1> Vežėjo {{$user->name}} {{$user->surname}} įvertinimai</h1>
        </div>
        <div class="col-sm-12">
            @foreach($evaluations as $evaluation)
                <table class="table table-strong-top">
                    <tbody>
                        <tr>
                            <td>Įvertino</td>
                            <td>{{$evaluation->evaluate_client()->first()->name}} {{$evaluation->evaluate_client()->first()->surname}}</td>
                        </tr>
                        <tr>
                            <td width="15%">Įvertinimas</td>
                            <td>
                                @for($i=1; $i <= 5; $i++)
                                   <span class="glyphicon glyphicon-star{{ ($i <= $evaluation->evaluation) ? '' : '-empty'}}"></span>
                                @endfor
                            </td>
                        </tr>
                        <tr>
                            <td>Komentaras</td>
                            <td>{{$evaluation->evaluation_comment}}</td>
                        </tr>
                        <tr>
                            <td>Įvertinimo data</td>
                            <td>{{$evaluation->created_at->format('Y-m-d')}}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection