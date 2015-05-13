<?php namespace App\Http\Controllers;

use App\Auto_type;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;

class AutotypesController extends Controller {

    public function create()
    {
        return view('categories.createauto');
    }

    public function store()
    {
        $input = Request::all();

        Auto_type::create($input);

        return redirect('categories/createauto');
    }

}
