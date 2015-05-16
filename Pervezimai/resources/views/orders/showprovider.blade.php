@extends('app')

@section('content')
    <div class="container">
    @foreach($orders as $order)

{{---------------------INFORMACIJA APIE UŽSAKYMĄ---------------------}}
        <div class="well well-lg text-center">
            <h1>Užsakymas {{ $order->order_key }}</h1>
        </div>
        @if($order->order_activation == 0)
            <div class="alert alert-danger">
                <strong>Šis užsakymas yra nepatvirtinas</strong>
            </div>
        @else
            <div class="alert alert-info">
                <strong>Šis užsakymas yra patvirtinas</strong>
            </div>
        @endif
        <table class="table table-bordered table-condensed">
            <tbody>
                <tr class="bold-text">
                    <td width="25%">Pageidaujama užsakymo paėmimo data: </td>
                    <td>Paėmimo adresas: </td>
                    <td>Pristatymo adresas: </td>
                    <td>Papildomų paslaugų poreikis: </td>
                </tr>
                <tr>
                    <td>{{$order->order_date}}</td>
                    <td>{{$order->pickup_address}}</td>
                    <td>{{$order->deliver_address}}</td>
                    <td> @if($order->extra_services == 0) Nereikalingas @else Reikalingas @endif </td>
                </tr>
                <tr class="table-top-row-storng">
                    <td class="bold-text">Komentaras apie užsakymą: </td>
                    <td colspan="3">{{$order->order_comment}}</td>
                </tr>
            </tbody>
        </table>
{{---------------------INFORMACIJA APIE UŽSAKOVĄ---------------------}}
        <div class="well well-sm text-center">
            <h3>Šį užsakymą jums pateikė</h3>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="25%"><strong>Vardas ir pavardė: </strong></td>
                    <td>{{ $order->client->name }} {{ $order->client->surname }}</td>
                </tr>
                @if($order->client->company !== '')
                    <tr>
                        <td ><strong>Įmonė: </strong></td>
                        <td>{{ $order->client->company }}</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>Email: </strong></td>
                    <td>{{ $order->client->email }}</td>
                </tr>
                <tr>
                    <td><strong>Kliento adresas: </strong></td>
                    <td>{{ $order->client->address }}, {{ $order->client->city }}</td>
                </tr>
                <tr>
                <tr>
                    <td><strong>Telefono numeris: </strong></td>
                    <td>{{ $order->client->phone }}</td>
                </tr>
                @if($order->client->comment !== '')
                    <tr>
                        <td><strong>Apie užsakovą: </strong></td>
                        <td>{{ $order->client->comment }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
{{---------------------INFORMACIJA APIE AUTOMOBILĮ---------------------}}
       <div class="well well-sm text-center">
            <h3>Užsakymas pateiktas jūsų automobiliui {{ $order->auto_registration->auto_name }}</h3>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="15%"><strong>Automobilis: </strong></td>
                    <td>{{ $order->auto_registration->auto_name }}</td>
                </tr>
                    <td><strong>Automobilio adresas: </strong></td>
                    <td>{{ $order->auto_registration->auto_city }}</td>
                </tr>
                <tr>
                    <td><strong>Automobilio aprašymas: </strong></td>
                    <td>{{ $order->auto_registration->auto_comment }}</td>
                </tr>
            </tbody>
        </table>
{{---------------------PATVIRTINTI ARBA ATMESTI UŽSAKYMĄ---------------------}}
        @if($order->order_activation == 0)
            {!! Form::open(['method' => 'PATCH', 'url' => 'orders/provider/' . $order->order_key . '/' . $order->id ]) !!}
                <div class="col-sm-6">
                    {!! Form::submit('Priimti užsakymą', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            {!! Form::close() !!}

            {!! Form::open(['method' => 'DELETE', 'url' => 'orders/provider/' . $order->order_key . '/' . $order->id ]) !!}
                <div class="col-sm-6">
                    {!! Form::submit('Atšaukti užsakymą', ['class' => 'btn btn-primary-red form-control']) !!}
                </div>
            {!! Form::close() !!}
        @endif
    @endforeach
    </div>

@endsection