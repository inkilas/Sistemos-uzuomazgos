@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Informacijos keitimas</div>
				<div class="panel-heading">Jūsų paštas {{ $user->email }}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							Blogai įvesti duomenys<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/users')}}/{{Auth::user()->id }}">
						<input name="_method" type="hidden" value="PATCH">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">



						<div class="form-group">
							<label class="col-md-4 control-label">Įmonės pavadinimas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="company" value="{{ $user->company }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Telefono numeris</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Miestas*</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="city" value="{{ $user->city }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Adresas*</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="address" value="{{ $user->address }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Komentaras</label>
							<div class="col-md-6">
								<textarea class="form-control" name="comment" value="{{ $user->comment }}" cols="40" rows="5">{{ $user->comment }}</textarea>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Išsaugoti
								</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
