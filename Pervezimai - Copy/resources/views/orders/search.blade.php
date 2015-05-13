        <style>
              #map-canvas {
                position: absolute;
                text-align: center;
                margin-left: 20px;
                margin-top: 200px;
                height: 60%;
                width: 50%;
                margin: 0px;
                padding: 0px
              }
        </style>     
            <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry"></script>

@extends('app')

@section('content')


    <h1>Vežėjų paieška</h1>
    <hr/>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Automobilis</th>
                <th>Vežėjas</th>
                <th>Adresas</th>
            </tr>
        </thead>
        <tbody>
        @foreach($autos_by_categories as $auto_by_category)
            <tr>
                @foreach($auto_by_category->user()->get() as $provider_by_category)
                        <td><input type="hidden" value="{{ $auto_by_category->id }}">{{ $auto_by_category->auto_name }}</td>
                        <td>{{ $provider_by_category->name }}</td>
                        <td>{{ $auto_by_category->auto_city }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
        <div id="map-canvas"></div>  <div id="distance_road"></div>

@endsection
@section('footer')
<script type="text/javascript">

    $('table td').on('click', function() {
        if($(this).parent().hasClass('success')){
            $(this).parent().removeClass('success');
            $(this).parent().find('input').removeAttr('name');
        }else{
            $(this).parent().addClass('success');
            $(this).parent().find('input').attr('name', 'provider_id[]');
        }
    })
</script>
           <script type="text/javascript">

                var geocoder;
                var map;
                markers = [                          // sukuriam masyvą markerio koordinatėms. Pavad.,lat, lng, icon.
              ['Paėmimo adresas', , ,'/images/flagman.png'],
              ['Pristatymo adresas', , ,'/images/truck3.png']
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

            var delay = 2000;
            setTimeout(display, delay);

        function display() {                      // sudedam markerius ir pateikiam vaizda, kad abu markeriai matytusi
                             
            //create empty LatLngBounds object
                  var bounds = new google.maps.LatLngBounds();
                  var infowindow = new google.maps.InfoWindow();
                  
                    for (i = 0; i < markers.length; i++) {
                        // console.log(markers[i][1],markers[i][2]);                // lipdom markerius pagal koordinates
                                var marker = new google.maps.Marker({
                                  position: new google.maps.LatLng(markers[i][1],markers[i][2]),
                                  zoom: 4,
                                  map: map,
                                  icon: markers[i][3],
                                  title: markers[i][0]
                                                        });
                                  //extend the bounds to include each marker's position
                                  bounds.extend(marker.position);

                                  google.maps.event.addListener(marker, 'ondoubleclick', (function(marker, i) {
                                      return function() {
                                          infowindow.setContent(markers[i][0]);
                                          infowindow.open(map, marker);
                                      }
                                  })(marker, i));
                    }

            //now fit the map to the newly inclusive bounds
                map.fitBounds(bounds);
        };      

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
                              directionsDisplay.setDirections(response);
                              distance = "Atstumas tarp paėmimo ir pristatymo taškų yra: "+response.routes[0].legs[0].distance.text;
                              distance += " Vidutinė kelionės trukmė yra: "+response.routes[0].legs[0].duration.text;
                              document.getElementById("distance_road").innerHTML = distance;
                              
                           }
                           
                        });

                          var line = new google.maps.Polyline({
                             map: map,
                             path: [location1, location2],
                             strokeWeight: 7,
                             strokeOpacity: 0.8,
                             strokeColor: "#FFAA00"
                          });
        };
                

        window.onload = function(){codeAddress1(); codeAddress2(); display(); showRoute();};
        google.maps.event.addDomListener(window, 'load', initialize);
            </script>

@endsection