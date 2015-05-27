<h1>Jūsų užsakymas {{ $order_info['order_key'] }} buvo priimtas</h1>
<br>
Šį užsakymą priėmė {{ $provider['name'] }} {{ $provider['surname'] }}
<br>
Automobilis {{ $auto['auto_name'] }}
<br>
<a href="{{ url('orders/client', $order_info['order_key'])}}">Užsakymą galite peržiūrėti čia</a>