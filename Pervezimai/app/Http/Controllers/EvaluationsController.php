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
    public function show($provider_id)
    {
        $user = User::where('id', $provider_id)->first();
        $evaluations = Evaluation::where('provider_id', $provider_id)->get();

        return view('users.evaluate', compact('evaluations', 'user'));

    }

    public function store()
    {
        $evaluation = new Evaluation(Request::all());
        $evaluated = Evaluation::where('client_id', Auth::user()->id)->where('provider_id', $evaluation['provider_id'])->get();
        if($evaluation['evaluation'] < 1 || $evaluation['evaluation'] > 5 || $evaluation['client_id'] != Auth::user()->id) {
            return '<h1>NEGRAŽU KEISTI KODĄ!!!!!!!!</h1>';
        }
        if($evaluated->first()) {
            if ($evaluated->first()->provider_id == $evaluation['provider_id']) {
                return 'Šį vežėją jau įvertinote';
            }
        }

        $evaluation->save();
        return redirect('orders/client')->with([
            'flash_message' => 'Įvertinimas pateiktas'
        ]);
    }

    public function destroy($provider_id, $client_id)
    {
        if($client_id != Auth::user()->id){
            return '<h1>KAS LEIDO KEISTI KODĄ?????!!!!!!!!?????????!!!!!???</h1>';
        }
        $evaluation = Evaluation::where('provider_id', $provider_id)->where('client_id', $client_id)->firstOrFail();
        $evaluation->delete();
        return redirect('orders/client')->with([
        'delete_all_order' => 'Įvertinimas sėkmingai ištrintas'
        ]);
    }

}
