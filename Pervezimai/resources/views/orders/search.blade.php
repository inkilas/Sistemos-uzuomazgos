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
    <div class="well well-lg text-center">
        <h1>Vežėjų paieška</h1>
    </div>
    <div class="row">
        <div id="map-canvas" class="col-sm-12"></div>
        <div id="distance_road" class="col-sm-12"></div>
    </div>
    <div class="row">    
        <div class="col-sm-12">
            {!! Form::open(['url' => 'orders']) !!}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Vežėjas</th>
                        <th>Automobilis</th>
                        <th>Adresas</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($autos_by_categories as $auto_by_category)
                    <tr>
                        @foreach($auto_by_category->user()->get() as $provider_by_category)
                            {!! Form::hidden('', $auto_by_category->id, ['id' => 'auto_registration_id']) !!}
                            {!! Form::hidden('', $provider_by_category->id, ['id' => 'provider_id']) !!}
                            <td>{{ $provider_by_category->name }}</td>
                            <td>{{ $auto_by_category->auto_name }}</td>
                            <td>{{ $auto_by_category->auto_city }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Pateikti užsakymą', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
</div>

@endsection
@section('footer')
<script type="text/javascript">

    $('table td').on('click', function() {
        if($(this).parent().hasClass('success')){
            $(this).parent().removeClass('success');
            $(this).parent().find('input').removeAttr('name');
        }else{
            $(this).parent().addClass('success');
            $(this).parent().find('#auto_registration_id').attr('name', 'auto_registration_id[]');
            $(this).parent().find('#provider_id').attr('name', 'provider_id[]');
        }
    })
</script>
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
     var atstumas;

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
                 var address = '{{ $ordersession['pickup_address']}}';
                 geocoder.geocode( { 'address': address}, function(results, status) {
                         if (status == google.maps.GeocoderStatus.OK) {
                                 // map.setCenter(results[0].geometry.location);
                                 markers[0][1] = results[0].geometry.location.lat();      // lat koordinates irasome i masyva
                                 markers[0][2] = results[0].geometry.location.lng();
          // lng koordinates irasome i masyva
                             } else {
                           alert('Geocode was not successful for the following reason: ' + status);
                         }
                 })
                 return markers[0][1],markers[0][2];

     };


     function codeAddress2() {                                 // geokoduojam antra adresa
        var address = '{{ $ordersession['deliver_address']}}';
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

        var delay = 1000;
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


        var delay = 1000;
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
                           hours:"val.",
                           mins:"min."
                        };
                        laikas = laikas.replace(/day|hours|mins/gi, function(matched){
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