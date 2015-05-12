<?php namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Auto_registration;
use App\Country;
use App\Auto_category;
use App\Auto_country;
use App\Auto_type;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Request;

class OrdersController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function create()
    {
        $categories = Category::lists('category', 'id');
        return view('orders.create', compact('categories'));
    }

    public function postsearch(CreateOrderRequest $request)
    {
        $order = $request->all();
        Session::put('order', $order);


        return redirect('orders/search');

    }

    public function getsearch()
    {
        $ordersession = Session::get('order');
        var_dump($ordersession);

        return view('orders.search', compact('ordersession'));

    }

    public function store()
    {

    }

}
