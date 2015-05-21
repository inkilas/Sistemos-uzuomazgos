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

               .animated {
                  -webkit-transition: height 0.2s;
                  -moz-transition: height 0.2s;
                  transition: height 0.2s;
              }

              .stars
              {
                  margin: 20px 0;
                  font-size: 24px;
                  color: #d17581;
              }
        </style>     
            <script src="http://maps.google.com/maps/api/js?sensor=true&libraries=geometry"></script>

@extends('app')

@section('content')
    <div class="container">
        <div class="well well-lg text-center">
            <h1>Užsakymas {{ $order_key }}</h1>
        </div>

        @if (Session::has('delete_order'))
            <div class="alert alert-warning">
                {{ session('delete_order') }}
            </div>
        @endif

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
                        @if($order->provider->company !== '')
                            <tr>
                                <td ><strong>Įmonė: </strong></td>
                                <td>{{ $order->provider->company }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Email: </strong></td>
                            <td>{{ $order->provider->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Įmonės adresas: </strong></td>
                            <td>{{ $order->provider->address }}, {{ $order->provider->city }}</td>
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
                        @if($order->order_activation == 0)
                            <tr>
                                <td colspan="2">
                                    {!! Form::open(['method' => 'DELETE', 'url' => 'orders/client/' . $order->order_key . '/' . $order->id ]) !!}
                                        {!! Form::submit('Atšaukti užsakymą', ['id' => 'delete', 'class' => 'btn btn-primary-red form-control']) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if($order->order_activation == 1)
                    @if($order->provider->provider_evaluation()->where('client_id', Auth::user()->id)->first())
                        <table class="table table-strong-top">
                            <tr>
                                <td colspan="2"><strong>Šį vežėją jau įvertinote</strong></td>
                            </tr>
                            <tr>
                                <td width="15%">Įvertinimas</td>
                                <td>
                                    @for($i=1; $i <= 5; $i++)
                                       <span class="glyphicon glyphicon-star{{ ($i <= $order->provider->provider_evaluation()->where('client_id', Auth::user()->id)->first()->evaluation) ? '' : '-empty'}}"></span>
                                    @endfor
                                </td>
                            </tr>
                            <tr>
                                <td>Komentaras</td>
                                <td>{{$order->provider->provider_evaluation()->where('client_id', Auth::user()->id)->first()->evaluation_comment}}</td>
                            </tr>
                            <tr>
                                <td>
                                   {!! Form::open(['method' => 'DELETE', 'url' => 'evaluate/' . $order->provider->id . '/' . Auth::user()->id ]) !!}
                                       {!! Form::submit('Ištrinti įvertinimą', ['id' => 'delete_evaluation', 'class' => 'btn btn-primary-red form-control']) !!}
                                   {!! Form::close() !!}
                                </td>
                                <td>
                                   <a href="{{ url('evaluate'). '/' . $order->provider->id }}" class="btn btn-link" target="_blank"> Peržiūrėkite visus įvertinimus</a>
                                </td>
                            </tr>
                        </table>

                    @else
                        <div class="row" style="margin-top:40px;">
                            <div class="col-md-6">
                            <div class="well well-sm">
                                <div class="text-right">
                                    <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Įvertinkite vežėją</a>
                                </div>

                                <div class="row" id="post-review-box" style="display:none;">
                                    <div class="col-md-12">
                                        <form accept-charset="UTF-8" action="{{ url('evaluate') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="provider_id" value="{{ $order->provider_id }}">
                                            <input id="ratings-hidden" name="evaluation" type="hidden">
                                            <textarea class="form-control animated" cols="50" id="new-review" name="evaluation_comment" placeholder="Parašykite savo atsiliepimą..." rows="5"></textarea>

                                            <div class="text-right">
                                                <div class="stars starrr" data-rating="0"></div>
                                                <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                                <span class="glyphicon glyphicon-remove"></span>Atšaukti</a>
                                                <button class="btn btn-success btn-lg" type="submit">Išsaugoti</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                	@endif
                @endif
            @endforeach

        </div>
    </div>

@endsection
@section('footer')
<!------------------------ivertinimu kodas----------------------------->
<script>
(function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")}}if(!e){return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()})

$(function(){

  $('#new-review').autosize({append: "\n"});

  var reviewBox = $('#post-review-box');
  var newReview = $('#new-review');
  var openReviewBtn = $('#open-review-box');
  var closeReviewBtn = $('#close-review-box');
  var ratingsField = $('#ratings-hidden');

  openReviewBtn.click(function(e)
  {
    reviewBox.slideDown(400, function()
      {
        $('#new-review').trigger('autosize.resize');
        newReview.focus();
      });
    openReviewBtn.fadeOut(100);
    closeReviewBtn.show();
  });

  closeReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
      });
    closeReviewBtn.hide();

  });

  $('.starrr').on('starrr:change', function(e, value){
    ratingsField.val(value);
  });
});
</script>
<!--------------------------------------------------------------------------->
<script>

    $('div.alert').delay(8000).slideUp(300);

    $(document).ready(function(){
      $("#delete").click(function(){
        if (!confirm("Ar tikrai norite atšaukti šį užsakymą?")){
          return false;
        }
      });
    });

    $(document).ready(function(){
      $("#delete_evaluation").click(function(){
        if (!confirm("Ar tikrai norite ištrinti šį įvertinimą?")){
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