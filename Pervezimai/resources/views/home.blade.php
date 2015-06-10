@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="well well-lg text-center">
            <h2>Informacinė pervežimų sistema Nuvežk.lt</h2>
        </div>
	</div>
        @if (Session::has('activation'))
            <div class="alert {{ Session::has('activation_resend') ? 'alert-info' : 'alert-success' }}">
                {{ session('activation') }}
            </div>
        @endif
        @if (Session::has('activation_error'))
            <div class="alert alert-danger">
                {{ session('activation_error') }}
            </div>
        @endif
</div>
@endsection

@section('footer')
    <script>
        $('div.alert').not('.alert-danger').delay(5000).slideUp(300);
    </script>
@endsection
