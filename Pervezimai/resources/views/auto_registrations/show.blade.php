@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>{{ $auto->auto_name }}</h1>
        </div>
<!---------------------Sekmingo atnaujinimo zinute------------------------------->
        @if (Session::has('updated_message'))
            <div class="alert alert-success">
                {{ session('updated_message') }}
            </div>
        @endif

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="15%"><strong>Automobilio pavadinimas: </strong></td>
                    <td>{{ $auto->auto_name }}</td>
                </tr>
                <tr>
                    <td><strong>Automobilio tipas: </strong></td>
                    <td>
                        @foreach($auto->auto_types()->get() as $auto_type)
                            {{ $auto_type->auto_type }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><strong>Automobilio kategorijos: </strong></td>
                    <td>
                        @foreach($auto->categories()->get() as $category)
                            [{{ $category->category }}]
                        @endforeach
                    </td>
                </tr>
                    <td><strong>Automobilio adresas: </strong></td>
                    <td>{{ $auto->auto_city }}</td>
                </tr>
                <tr>
                    <td><strong>Automobilio aptarnaujamos šalys: </strong></td>
                    <td>
                        @foreach($auto->countries()->get() as $country)
                            [{{ $country->country }}]
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><strong>Automobilio kainos: </strong></td>
                    <td><span style="color: green">{{ $auto->price_km }}eur/km</span>  <span style="color: blue">{{ $auto->price_h }}eur/val</span></td>
                </tr>
                <tr>
                    <td><strong>Papildomos paslaugos: </strong></td>
                    <td>
                        @if($auto->extra_services == false)
                            Neteikiamos
                        @else
                            Teikiamos
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Automobilio aprašymas: </strong></td>
                    <td>{{ $auto->auto_comment }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-primary form-control" href="{{ action('Auto_registrationsController@edit', [$auto->id]) }}"><span class="glyphicon glyphicon-edit"></span> Redaguoti</a>
            </div>
            {!! Form::open(['method' => 'DELETE', 'action' => ['Auto_registrationsController@destroy', $auto->id]]) !!}
                <div class="col-sm-6">
                    {!! Form::button('<span class="glyphicon glyphicon-trash"></span>Ištrinti', array('id' => 'delete', 'type' => 'submit', 'class' => 'btn btn-primary-red form-control')) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $('div.alert').delay(5000).slideUp(300);
    </script>

    <script>

    $(document).ready(function(){
      $("#delete").click(function(){
        if (!confirm("Ar tikrai norite ištrinti automobilį?")){
          return false;
        }
      });
    });

    </script>
@endsection