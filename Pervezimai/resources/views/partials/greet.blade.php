@if(Auth::guest() == true)
    <div class="panel-body">
        <a class="btn btn-link" href="{{ url('/auth/login') }}">Prisijunk</a>
        <a class="btn btn-link" href="{{ url('/auth/register') }}">Registruokis</a>
    </div>
@else
    <div class="panel-body">
       Sveiki prisijungę! {{Auth::user()->name}}
        <a class="btn btn-link" href="{{ url('/auth/logout') }}">Atsijungti</a></br>
    </div>
@endif
    <div>

    </div>

