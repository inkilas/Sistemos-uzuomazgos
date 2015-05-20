<div class="container">
    <div class="row">
        <div class="col-sm-1">
           <a  href="{{ url('/') }}"> <img src="/images/nuvezk_logo.png" alt="home" height="70" width="90"> </a>
        </div>
        @if(Auth::guest() == true)
            <div class="col-sm-4">
                <a class="btn btn-link" href="{{ url('/auth/login') }}">Prisijunk</a>
                <a class="btn btn-link" href="{{ url('/auth/register') }}">Registruokis</a>
            </div>
        @else
            <div class="col-sm-11">
                <div class="row">
                    <div class="col-sm-4">
                       Sveiki prisijungę! {{Auth::user()->name}}
                        <a class="btn btn-link" href="{{ url('/auth/logout') }}">Atsijungti</a></br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <a href="{{ action('OrdersController@create')}}"><button class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> Naujas užsakymas</button></a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ action('OrdersController@index') }}"><button class="btn btn-primary-green form-control"><span class="glyphicon glyphicon-briefcase"></span> Mano užsakymai</button></a>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{ action('Auto_registrationsController@index')}}"><button class="btn btn-primary-red form-control"><span class="glyphicon glyphicon-road"></span> Mano automobiliai</button></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
