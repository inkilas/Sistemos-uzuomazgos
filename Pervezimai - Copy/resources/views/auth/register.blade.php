@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Registracija</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Vardas*</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Pavardė*</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Adresas*</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Slaptažodis*</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Patvirtinkite slaptažodį*</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Įmonės pavadinimas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="company" value="{{ old('company') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Telefono numeris</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Įmonės kodas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="company_code" value="{{ old('company_code') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">PVM mokėtojo kodas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="PVM" value="{{ old('PVM') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Miestas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="city" value="{{ old('city') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Adresas</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="address" value="{{ old('address') }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Registruotis
								</button>
							</div>
						</div>

                         <div class="form-group">
 							<div class="col-md-6 col-md-offset-4">

 								<a class="btn btn-link" href="{{ url('/auth/login') }}">Registruotas vartotojas? Prisijunkite</a>
 							</div>
 						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
