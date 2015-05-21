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
    @if(empty($autos_by_categories))
    <div class="well well-lg text-center">
        <h1>Atsiprašome vežėjų nerasta</h1>
    </div>
    @else
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
                        <th>Įvertinimas</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($autos_by_categories as $auto_by_category)
                    <tr id={{$auto_by_category->id}}>
                        @foreach($auto_by_category->user()->get() as $provider_by_category)
                            {!! Form::hidden('', $auto_by_category->id, ['id' => 'auto_registration_id']) !!}
                            {!! Form::hidden('', $provider_by_category->id, ['id' => 'provider_id']) !!}
                            <td>{{ $provider_by_category->name }}</td>
                            <td>{{ $auto_by_category->auto_name }}</td>
                            <td>{{ $auto_by_category->auto_city }}</td>
                            <td>
                                @for($i=1; $i <= 5; $i++)
                                   <span class="glyphicon glyphicon-star{{ ($i <= $provider_by_category->provider_evaluation()->avg('evaluation')) ? '' : '-empty'}}"></span>
                                @endfor
                                    <a href="{{ url('evaluate'). '/' . $provider_by_category->id }}" class="btn btn-link" target="_blank"> Peržiūrėkite visus įvertinimus</a>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Pateikti užsakymą', ['id' => 'confirm', 'class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
    @endif
</div>

@endsection
@section('footer')

<script>

    $(document).ready(function(){
      $("#confirm").click(function(){
        if (!confirm("Ar tikrai norite atlikti užsakymą?")){
          return false;
        }
      });
    });

</script>

<script type="text/javascript">

     var geocoder;
     var map;
     markers = [                          // sukuriam masyvą markerio koordinatėms. Pavad.,lat, lng, icon.
           ['Paėmimo adresas', , ,'/images/flagman.png'],
           ['Pristatymo adresas', , ,'/images/smiley_happy.png']
    ];
     var markerBounds = new google.maps.LatLngBounds();
     var latlng;
     var directionsDisplay;
     var directionsService = new google.maps.DirectionsService();
     var location1;
     var location2;
     var route_distance;
     var route_duration;

    function detectBrowser() {
      var useragent = navigator.userAgent;
      var mapdiv = document.getElementById("map-canvas");

      if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
        mapdiv.style.width = '100%';
        mapdiv.style.height = '100%';
      } else {
        mapdiv.style.width = '600px';
        mapdiv.style.height = '800px';
      }
    }

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
                markers[0][1] = results[0].geometry.location.lat();      // lat koordinates irasome i masyva
                markers[0][2] = results[0].geometry.location.lng();      // lng koordinates irasome i masyva
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

     function showRoute(){                                  // paemimo ir pristatymo vietos
        location1 = markers[0][1] + "," + markers[0][2];
        location2 = markers[1][1] + "," + markers[1][2];
        directionsDisplay = new google.maps.DirectionsRenderer(
            {
                suppressMarkers: true,
                suppressInfoWindows: true
            });
        directionsDisplay.setMap(map);                      // pradedam kursavima
            var request = {
                origin:location1,
                destination:location2,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
        directionsService.route(request, function(response, status)
            {
                if (status == google.maps.DirectionsStatus.OK)
                    {
                        var laikas = response.routes[0].legs[0].duration.text;          // pasiimam laiko tekstine verte
                        var mapObj = {                                                  // keisim angliskus zodzius i lietuviskus joje
                           day:"d.",
                           hour:"val.",
                           hours:"val.",
                           mins:"min."
                        };
                        laikas = laikas.replace(/day|hours|hour|mins/gi, function(matched){            // keiciam tekstines vertes
                          return mapObj[matched];
                        });
                        directionsDisplay.setDirections(response);                          // pasiimam laiko ir atstumo vertes
                        route_distance = response.routes[0].legs[0].distance.value;
                        route_duration = response.routes[0].legs[0].duration.value;
                        distance = "Atstumas tarp paėmimo ir pristatymo taškų yra: "+response.routes[0].legs[0].distance.text;
                        distance += ". Vidutinė kelionės trukmė: "+laikas;
                        document.getElementById("distance_road").innerHTML = distance;          // atvaizduojam distance_road id
                    }
            });
        var line = new google.maps.Polyline({               // nustatymai kelio linijos
            map: map,
            path: [location1, location2],
            strokeWeight: 7,
            strokeOpacity: 0.6,
            strokeColor: "#FFAA00"
        });
       };

       var delay = 2500;
       setTimeout(showproviders, delay);

       var auto_city = new Array();                                 // issitraukiam duomenis is duomenu bazes i array
             @foreach($autos_by_categories as $auto_by_category)
                @foreach($auto_by_category->user()->get() as $provider_by_category)
                    auto_city.push(['{{ $provider_by_category->id}}', '{{ $auto_by_category->id}}', '{{ $provider_by_category->name}}', '{{ $auto_by_category->auto_city}}', '{{ $auto_by_category->price_km}}', '{{ $auto_by_category->price_h}}', '{{ $auto_by_category->auto_comment = trim(preg_replace('/\s\s+/', ' ', $auto_by_category->auto_comment)) }}' ]);
                @endforeach
             @endforeach

            
        var providers_markers = new Array();            // trigerinam lenteles click'a su markeriu
        $('table tr').on('click', function() { 
            for (i = 0; i < providers_markers.length; i++) {
                if(providers_markers[i].title == $(this).attr('id')) {
                    google.maps.event.trigger(providers_markers[i], 'click');
                }
            }    
        });

        var delay = 2000;
        setTimeout(showRoute, delay);

    function showproviders() {
           
        $.each(auto_city, function(index, doc){

              $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+doc[3]+'&sensor=false', null, function (data) {
                var p = data.results[0].geometry.location;              // is arejaus imam adresa ir isgeocodine dedam markerius
                var latlng = new google.maps.LatLng(p.lat, p.lng);
                var marker1 = new google.maps.Marker({
                    position: latlng,
                    icon: '/images/truck3.png',
                    map: map,
                    title: doc[1]                                   // vezejo vardas kaip markerio title
                });
                providers_markers.push(marker1);                    // i globalu kintamaji isstumiam
                var provider_duration_price = (route_duration / 3600) * doc[5];             // apsk. kaina pagal laika
                var provider_route_price = (route_distance / 1000) * doc[4];                // apsk. kaina pagal km
                var rounded_price_km = Math.round( provider_route_price * 10 ) / 10;        // suapvalinam verte
                var rounded_price_h = Math.round( provider_duration_price * 10 ) / 10;      // suapvalinam verte

                var contentString = '<div id="content">'+                                   // informacinio lango turinys
                '<div id="bodyContent">'+
                '<p align="justify"><b>Vežėjas:</b> '+doc[2]+'<br><b>Adresas: </b>'+doc[3]+'</b><br>'+
                'Preliminari kelionės kaina pagal vežėjo įkainius už kilometrą yra:   <b><font color="red">'+rounded_price_km+' €;</font></b><br>'+
                ' Pagal valandinius įkainius preliminari kaina yra:  <b><font color="red">'+rounded_price_h+' €;</font></b><br>'+
                '<b>Vežėjo automobilio komentaras:</b> '+doc[6]+'</p>'+
                '</div>'+
                '</div>';
                 var infowindow = new google.maps.InfoWindow({
                      content: contentString
                  });
                 
              google.maps.event.addListener(marker1, 'click', toggleBounce);                // nustatom suoliavima paspaudus
              function toggleBounce() {

                  if (marker1.getAnimation() != null) {
                    marker1.setAnimation(null);
                  } else {
                    marker1.setAnimation(google.maps.Animation.BOUNCE);
                  }
              }

              google.maps.event.addListener(marker1, 'click', function() {                  // paspaudus ant markerio pazymim lenteles elementa
                   infowindow.open(map,marker1);
                   if($("#"+marker1.title).hasClass('success')){
                        $("#"+marker1.title).removeClass('success');
                        $("#"+marker1.title).find('input').removeAttr('name');
                   }else{
                        $("#"+marker1.title).addClass('success');
                        $("#"+marker1.title).find('#auto_registration_id').attr('name', 'auto_registration_id[]');
                        $("#"+marker1.title).find('#provider_id').attr('name', 'provider_id[]');
                   }

                   });
                          
            });
        });
       
        
    };


     window.onpageshow = function(){codeAddress1(); codeAddress2();};
     // window.onload = function(){showproviders();};
     google.maps.event.addDomListener(window, 'load', initialize);
 </script>

@endsection