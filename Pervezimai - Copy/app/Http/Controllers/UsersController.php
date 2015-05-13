<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class UsersController extends Controller {

	public function index()
    {

        $users = User::all();

        return view('users.index', compact('users'));

    }

}
