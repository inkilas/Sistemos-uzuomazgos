@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Tvarkykite savo automobilius</h1>
        </div>
<!---------------------Sekmingo registravimo zinute------------------------------->
        @if (Session::has('created_message'))
            <div class="alert alert-success">
                {{ session('created_message') }}
            </div>
        @endif
<!---------------------Sekmingo trynimo zinute------------------------------->
        @if (Session::has('delete_message'))
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <div class="alert alert-danger">
                {{ session('delete_message') }}
            </div>
        @endif

        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <a href="{{ action('Auto_registrationsController@create') }}"><button class="btn btn-primary-green form-control"><span class="glyphicon glyphicon-plus"></span> Sukurti naują automobilį</button></a>
            </div>
        </div>
        <br>
        @foreach($autos as $auto)
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <a href="{{ action('Auto_registrationsController@show', [$auto->id]) }}"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-wrench"></span> {{ $auto->auto_name }}</button></a>
                </div>
            </div>
        @endforeach
    </div>



@endsection

@section('footer')
    <script>
        $('div.alert').delay(5000).slideUp(300);
    </script>
@endsection