@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Mano pateikti užsakymai</h1>
        </div>

        @if (Session::has('delete_all_order'))
            <div class="alert alert-warning">
                {{ session('delete_all_order') }}
            </div>
        @endif

        @if(isset($orders[0]))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Užsakymo numeris</th>
                        <th>Paėmimo adresas</th>
                        <th>Pristatymo adresas</th>
                        <th>Paėmimo data</th>
                        <th>Būsena</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders_keys as $order)
                        @if($order->order_activation == 0)
                            <tr class="clickable-row alert alert-danger" data-href="{{ action('OrdersController@showclient', [$order->order_key]) }}">
                                <td>{{ $order->order_key }}</td>
                                <td>{{ $order->pickup_address }}</td>
                                <td>{{ $order->deliver_address }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td>Nepatvirtintas</td>
                            </tr>
                        @else
                            <tr class="clickable-row alert alert-info" data-href="{{ action('OrdersController@showclient', [$order->order_key]) }}">
                                <td>{{ $order->order_key }}</td>
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
            <h3>Jūs nesate pateikę jokių užsakymų</h3>
        </div>
        @endif
    </div>

@endsection
@section('footer')

    <script>
        $('div.alert').delay(8000).slideUp(300);
    </script>

    <script type="text/javascript">
       jQuery(document).ready(function($) {
           $(".clickable-row").click(function() {
               window.document.location = $(this).data("href");
           });
       });
    </script>
@endsection

