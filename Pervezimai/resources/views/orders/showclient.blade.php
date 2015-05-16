@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Užsakymas {{ $order_key }}</h1>
        </div>
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
            <div class="well well-sm text-center">
                <h3>Šį užsakymą pateikėte šiems vežėjams</h3>
            </div>
            @foreach($orders as $order)
                <table class="table table-strong-top">
                    <tbody>
                        <tr>
                            <td width="15%"><strong>Automobilis: </strong></td>
                            <td>{{ $order->auto_registration->auto_name }}</td>
                        </tr>
                        <tr>
                            <td ><strong>Vardas ir pavardė: </strong></td>
                            <td>{{ $order->provider->name }} {{ $order->provider->surname }}</td>
                        </tr>
                        <tr>
                            <td ><strong>Įmonė: </strong></td>
                            <td>{{ $order->provider->company }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email: </strong></td>
                            <td>{{ $order->provider->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Įmonės adresas: </strong></td>
                            <td>{{ $order->provider->address }}</td>
                        </tr>
                        <tr>
                            <td><strong>Automobilio adresas: </strong></td>
                            <td>{{ $order->auto_registration->auto_city }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telefono numeris: </strong></td>
                            <td>{{ $order->provider->phone }}</td>
                        </tr>
                        <tr>
                            <td><strong>Automobilio aprašymas: </strong></td>
                            <td>{{ $order->auto_registration->auto_comment }}</td>
                        </tr>
                        @if($order->provider->comment !== '')
                        <tr>
                            <td><strong>Apie įmonę: </strong></td>
                            <td>{{ $order->provider->comment }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2" ><a class="btn btn-primary-red form-control " href=""><span class="glyphicon glyphicon-remove"></span> Ištrinti </a></td>
                        </tr>
                    </tbody>
                </table>
            @endforeach

        </div>
    </div>

@endsection