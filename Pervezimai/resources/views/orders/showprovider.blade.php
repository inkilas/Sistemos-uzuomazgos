<style>
              #map-canvas {
                position: relative;
                text-align: center;
                margin-left: 15px;
                margin-bottom: 15px;
                height: 55%;
                width: 97%;
                /*padding: 0px*/
              }      
              #distance_road {
                text-align: center;
                font-size: 12pt;
                color: blue;
                font-style: italic;
                margin-bottom: 15px;
              } 
        </style>     
            <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry"></script>

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
        <div class="row">
            <div id="map-canvas" class="col-sm-12"></div>
            <div id="distance_road" class="col-sm-12"></div>
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
@section('footer')
<script type="text/javascript">

     var geocoder;
     var map;
     markers = [                          // sukuriam masyvą markerio koordinatėms. Pavad.,lat, lng, icon.
           ['Paėmimo adresas', , ,'/images/flagman.png'],
           ['Pristatymo adresas', , ,'/images/smiley_happy.png']
            // ['Tarpinis adresas', , ,1]
      ];
     var markerBounds = new google.maps.LatLngBounds();
     var latlng;
     var directionsDisplay;
     var directionsService = new google.maps.DirectionsService();
     var location1;
     var location2;

     google.maps.event.addDomListener(window, 'load', initialize);

     function initialize() {
            directionsDisplay = new google.maps.DirectionsRenderer();
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(55.1400712,24.6413204);      // pirminis zemelapis
            var mapOptions = {
                zoom: 7,
                center: latlng,
                disableDefaultUI: true,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

     };

     function codeAddress1() {                               // geokoduojam pirma adresa
        var address = '{{$order->pickup_address}}';
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                markers[0][1] = results[0].geometry.location.lat();      // lat koordinates irasome i masyva
                markers[0][2] = results[0].geometry.location.lng();      // lng koordinates irasome i masyva
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
     })
     return markers[0][1],markers[0][2];
     };

     function codeAddress2() {                                 // geokoduojam antra adresa
        var address = '{{$order->deliver_address}}';
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                markers[1][1] = results[0].geometry.location.lat();   // lat koordinates irasome i masyva
                markers[1][2] = results[0].geometry.location.lng();   // lng koordinates irasome i masyva
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
            })
        return markers[1][1],markers[1][2];
     };

        var delay = 2000;
        setTimeout(display, delay);

     function display() {                      // sudedam markerius ir pateikiam vaizda, kad abu markeriai matytusi
         //create empty LatLngBounds object
        var bounds = new google.maps.LatLngBounds();
        var infowindow = new google.maps.InfoWindow();
            for (i = 0; i < markers.length; i++) {
            // lipdom markerius pagal koordinates
                var marker = new google.maps.Marker({
                position: new google.maps.LatLng(markers[i][1],markers[i][2]),
                zoom: 4,
                map: map,
                icon: markers[i][3],
                title: markers[i][0]
                });
            //extend the bounds to include each marker's position
                bounds.extend(marker.position);
                google.maps.event.addListener(marker, 'onclick', (function(marker, i) {
                    return function() {
                        infowindow.setContent(markers[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
      //now fit the map to the newly inclusive bounds
            map.fitBounds(bounds);
     };

        var delay = 2000;
        setTimeout(showRoute, delay);

     function showRoute(){
        location1 = markers[0][1] + "," + markers[0][2];
        location2 = markers[1][1] + "," + markers[1][2];
        directionsDisplay = new google.maps.DirectionsRenderer(
            {
                suppressMarkers: true,
                suppressInfoWindows: true
            });
        directionsDisplay.setMap(map);
            var request = {
                origin:location1,
                destination:location2,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
        directionsService.route(request, function(response, status)
            {
                if (status == google.maps.DirectionsStatus.OK)
                    {
                        var laikas = response.routes[0].legs[0].duration.text;
                        var mapObj = {
                           day:"d.",
                           hour:"val.",
                           hours:"val.",
                           mins:"min."
                        };
                        laikas = laikas.replace(/day|hours|hour|mins/gi, function(matched){
                          return mapObj[matched];
                        });
                        directionsDisplay.setDirections(response);
                        distance = "Atstumas tarp paėmimo ir pristatymo taškų yra: "+response.routes[0].legs[0].distance.text;
                        distance += ". Vidutinė kelionės trukmė: "+laikas;
                        document.getElementById("distance_road").innerHTML = distance;
                    }
            });
        var line = new google.maps.Polyline({
            map: map,
            path: [location1, location2],
            strokeWeight: 7,
            strokeOpacity: 0.6,
            strokeColor: "#FFAA00"
        });
       };
       window.onpageshow = function(){codeAddress1(); codeAddress2();};
       google.maps.event.addDomListener(window, 'load', initialize);
       </script>
       @endsection