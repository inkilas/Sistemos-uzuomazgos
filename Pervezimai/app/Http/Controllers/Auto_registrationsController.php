<?php namespace App\Http\Controllers;


use App\Auto_registration;
use App\Country;
use App\Auto_category;
use App\Category;
use App\Auto_country;
use App\Auto_type;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Http\Requests\Auto_registrationRequest;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Request;

class Auto_registrationsController extends Controller {

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $autos = User::findOrFail(Auth::user()->id)->user_auto;

        return view('auto_registrations.index', compact('autos'));
    }

    public function show($id)
    {
        $auto = Auto_registration::where('user_id', Auth::user()->id)->findOrFail($id);

        return view('auto_registrations.show', compact('auto'));
    }
    /**
     * Auto registracija
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::lists('category', 'id');
        $countries = Country::lists('country', 'id');
        $auto_types = Auto_type::lists('auto_type', 'id');
        return view('auto_registrations.create', compact('categories', 'countries', 'auto_types'));
    }

    /**
     * @param CreateAuto_registrationRequest $request
     * @return mixed
     */
    public function store(Auto_registrationRequest $request)
    {
        $auto_registration = new Auto_registration($request->all());

        $auto = Auth::user()->user_auto()->save($auto_registration);

        $categoriesIds = $request->input('category_list');
        $countriesIds = $request->input('country_list');
        $auto->categories()->attach($categoriesIds); //issaugo many to many lentele
        $auto->countries()->attach($countriesIds);

        return redirect('auto_registrations');
    }

    /**
     * Redaguoti automobili
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $auto = Auto_registration::where('user_id', Auth::user()->id)->findOrFail($id);

        $categories = Category::lists('category', 'id');
        $countries = Country::lists('country', 'id');
        $auto_types = Auto_type::lists('auto_type', 'id');
        $selected_auto = Auto_registration::find($id)->auto_id;
        return view('auto_registrations.edit', compact('auto', 'categories', 'countries', 'auto_types', 'id', 'selected_auto'));
    }

    /**
     * Atnaujina redaguotą informaciją
     *
     * @param $id
     * @param Auto_registrationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Auto_registrationRequest $request)
    {
        $auto = Auto_registration::where('user_id', Auth::user()->id)->findOrFail($id);

        $auto->update($request->all());

        $categoriesIds = $request->input('category_list');
        $countriesIds = $request->input('country_list');

        $auto->categories()->sync($categoriesIds); //issaugo many to many lentele
        $auto->countries()->sync($countriesIds);

        return redirect('auto_registrations/' . $id);
    }

    public function destroy($id){
        Auto_registration::where('user_id', Auth::user()->id)->findOrFail($id)->delete();

        return redirect('auto_registrations');
    }

}
