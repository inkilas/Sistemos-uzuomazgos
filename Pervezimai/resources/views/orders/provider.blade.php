@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Man pateikti užsakymai</h1>
        </div>

        @if (Session::has('delete_order'))
            <div class="alert alert-warning">
                {{ session('delete_order') }}
            </div>
        @endif
        @if (Session::has('confirm_order'))
            <div class="alert alert-info">
                {{ session('confirm_order') }}
            </div>
        @endif


        @if(!empty($orders->toArray()))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Užsakymo numeris</th>
                        <th>Automobilis</th>
                        <th>Paėmimo adresas</th>
                        <th>Pristatymo adresas</th>
                        <th>Paėmimo data</th>
                        <th>Būsena</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @if($order->order_activation == 0)
                            <tr class="clickable-row alert alert-danger" data-href="{{ url('orders/provider', $order->order_key)}}/{{ $order->id }}">
                                <td>{{ $order->order_key }}</td>
                                <td>{{ $order->auto_registration->auto_name }}</td>
                                <td>{{ $order->pickup_address }}</td>
                                <td>{{ $order->deliver_address }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>Nepatvirtintas</td>
                            </tr>
                        @else
                            <tr class="clickable-row alert alert-info" data-href="{{ url('orders/provider', $order->order_key)}}/{{ $order->id }}">
                                <td>{{ $order->order_key }}</td>
                                <td>{{ $order->auto_registration->auto_name }}</td>
                                <td>{{ $order->pickup_address }}</td>
                                <td>{{ $order->deliver_address }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>Patvirtintas</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
        <div class="well well-lg text-center">
            <h3>Jums nėra pateiktų užsakymų</h3>
        </div>
        @endif

    </div>

@endsection
@section('footer')
    <script type="text/javascript">

       $('div.alert').delay(8000).slideUp(300);

       jQuery(document).ready(function($) {
           $(".clickable-row").click(function() {
               window.document.location = $(this).data("href");
           });
       });
    </script>
@endsection