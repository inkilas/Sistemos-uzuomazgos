@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="well well-lg text-center">
            <h2>Informacinė pervežimų sistema Nuvežk.lt</h2>
        </div>
        @if(Auth::user() == true)
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{ action('OrdersController@create')}}"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Naujas užsakymas</button></a>
                </div>
                <div class="col-sm-4">
                    <a href="{{ action('OrdersController@index') }}"><button class="btn btn-primary-green form-control"><span class="glyphicon glyphicon-briefcase"></span> Mano užsakymai</button></a>
                </div>
                <div class="col-sm-4">
                    <a href="{{ action('Auto_registrationsController@index')}}"><button class="btn btn-primary-red form-control"><span class="glyphicon glyphicon-road"></span> Mano automobiliai</button></a>
                </div>
            </div>
        @endif
        </div>
	</div>
</div>
@endsection
