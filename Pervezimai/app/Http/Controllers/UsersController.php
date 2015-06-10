<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateUsersRequest;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Request;

class UsersController extends Controller {

    /**
     *
     * Tik autentifikuotas vartotojas gali prieiti prie šio kontrolerio
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {

        $users = User::all();

        return view('users.index', compact('users'));

    }

    public function destroy($user_id)
    {
        User::where('id', $user_id)->findOrFail($user_id)->delete();
        return redirect('users');
    }

    /**
     * Aktyvuoja vartotoją
     *
     * @param $key
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($key)
    {
        if(Auth::user()->key != $key){
            session()->flash('activation_error', 'Neteisinga aktyvacijos nuoroda! Pasitikrinkite paštą arba atsisiūskite naują nuorodą!');
            return redirect('/');
        }
        $user = User::where('key', $key);
        $user->update(['activation' => 1, 'key' => 'activated']);
        session()->flash('activation', 'Jūsų paskyra buvo aktyvuota');
        return redirect('/');
    }

    public function updatekey($user_id)
    {
        $key = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        if($user->activation == 1) {
            return redirect('/');
        }
        $user->update(['key' => $key]);
        $user = $user->toArray();
        Mail::send('emails.user_email', array('key' => $user['key']), function($message) use ($user) {
            $message->to( $user['email'], $user['name']. ' ' . $user['surname'])->subject('Jūsų paskyros aktyvacija');
        });

        session()->flash('activation', 'Jums buvo išsiūsta nauja aktyvacijos nuoroda į Jūsų elektroninį paštą');
        session()->flash('activation_resend', true);

        return redirect('/');
    }

    public function edit($user_id)
    {
        if($user_id != Auth::user()->id){
            return "NEKEISK KODO!!!!";
        }
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        return view('users.edit', compact('user'));
    }

    public function editupdate(CreateUsersRequest $request, $user_id)
    {
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        $user->update($request->all());

        session()->flash('activation', 'Informacija atnaujinta');
        return redirect('/');
    }
}
