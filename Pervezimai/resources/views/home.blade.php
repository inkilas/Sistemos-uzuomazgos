@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>
				<div class="panel-body">
                    <h2>Informacinė pervežimų sistema Nuvežk.lt</h2>
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
	</div>
</div>
@endsection
