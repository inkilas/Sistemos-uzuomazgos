<?php namespace App\Http\Controllers;

use App\Evaluation;
use App\Order;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Request;

class EvaluationsController extends Controller {

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *Ivertinimo kurimas
     *
     *
     */
    public function create($client_id, $provider_id)
    {
        $provider = User::where('id', $provider_id);
        $client = User::where('id', Auth::user()->id);

        return view('users.evaluate', compact('provider', 'client'));

    }

    public function store()
    {
        $evaluated = Evaluation::where('client_id', Auth::user()->id)->get();
        $evaluation = new Evaluation(Request::all());
        if($evaluation['evaluation'] < 1 || $evaluation['evaluation'] > 5 || $evaluation['client_id'] != Auth::user()->id){
            return '<h1>NEGRAŽU KEISTI KODĄ!!!!!!!!</h1>';
        }
        if($evaluated[0]->provider_id == $evaluation['provider_id']){
            return '<h1>Šį vežėją jūs jau įvertinote!!!</h1>';
        }
        $evaluation->save();
        return redirect('/');
    }

}
