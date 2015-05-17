@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="well well-lg text-center">
            <h2>Informacinė pervežimų sistema Nuvežk.lt</h2>
        </div>
        @if(Auth::user() == true)
            <div>
                <a href="{{ action('OrdersController@create')}}">Naujas užsakymas</a><br>
                <a href="{{ action('OrdersController@index') }}">Mano užsakymai</a><br>
                <a href="{{ action('Auto_registrationsController@index')}}">Jūsų užregistruoti automobiliai</a>
            </div>
        @endif
        </div>
	</div>
</div>
@endsection
