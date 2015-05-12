<?php namespace App\Http\Controllers;


use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;

class CategoryController extends Controller
{

	public function create()
    {
        return view('categories.create');
    }

    public function store()
    {
        $input = Request::all();

        Category::create($input);

        return redirect('categories/create');
    }

}
