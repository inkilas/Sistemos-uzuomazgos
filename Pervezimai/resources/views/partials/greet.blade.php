<div class="container">
    <div class="col-sm-1">
       <a  href="{{ url('/') }}"> <img src="/images/nuvezk_logo.png" alt="home" height="60" width="75"> </a>
    </div>
    @if(Auth::guest() == true)
        <div class="col-sm-4">
            <a class="btn btn-link" href="{{ url('/auth/login') }}">Prisijunk</a>
            <a class="btn btn-link" href="{{ url('/auth/register') }}">Registruokis</a>
        </div>
    @else
        <div class="col-sm-4">
           Sveiki prisijungę! {{Auth::user()->name}}
            <a class="btn btn-link" href="{{ url('/auth/logout') }}">Atsijungti</a></br>
        </div>
    @endif
</div>
