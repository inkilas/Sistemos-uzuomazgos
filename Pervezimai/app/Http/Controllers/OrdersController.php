<?php namespace App\Http\Controllers;

use App\Category;
use App\Order;
use App\Auto_registration;
use App\Country;
use App\Auto_category;
use App\Auto_country;
use App\Auto_type;
use App\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;

//use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Request;

class OrdersController extends Controller {

    /**
     *
     * Tik autentifikuotas vartotojas gali prieiti prie šio kontrolerio
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Užsakymo duomenų forma
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::lists('category', 'id');
        $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return view('orders.create', compact('categories', 'number'));
    }

    /**
     * Perduoda užsakymo duomenis į sesiją ir nukreipia į vežėjų paiešką
     *
     * @param CreateOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postsearch(CreateOrderRequest $request)
    {
        $order = $request->all();
        Session::put('order', $order);


        return redirect('orders/search');

    }

    /**
     * Parodo surastus vežėjus
     *
     * @return \Illuminate\View\View
     */
    public function getsearch()
    {
        $ordersession = Session::get('order');
        if(!isset($ordersession['extra_services'])){
            $ordersession['extra_services'] = 0;
        }
        $autos_by_categories = Category::find($ordersession['category_id'])->auto_registration()->get();
        return view('orders.search', compact('autos_by_categories', 'ordersession'));

    }


    /**
     * Įrašo užsakymą į duomenų bazę
     *
     * @return string
     */
    public function store()
    {
        $ordersession = Session::get('order');
        $providers_autos = Request::all();


        foreach($providers_autos['provider_id'] as $key => $provider_auto) {
            $order = $ordersession;
            $order['provider_id'] = $provider_auto;
            $order['auto_registration_id'] = $providers_autos['auto_registration_id'][$key];
            $order_create = new Order($order);
            Auth::user()->clientorders()->save($order_create);
        }
        $updates = Order::where('order_key', $ordersession['order_key'])->get();
        foreach($updates as $update){
            $updateID = $update->id;
        }
        foreach($updates as $update){
            $update->update(['order_key' => $updateID.$ordersession['order_key']]);
        }

        Session::forget('order');
        return redirect('orders');
    }


    /**
     * Nukreipiama į (Mano užsakymai)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Nukreipiama, kur galima peržiūrėti savo pateiktus užsakymus
     *
     * @return \Illuminate\View\View
     */
    public function clientindex()
    {
        $orders = User::findOrFail(Auth::user()->id)->clientorders;

        return view('orders.client', compact('orders'));
    }

    /**
     * Nukreipiama, gur vežėjas gali peržiūrėti jam pateiktus užsakymus
     *
     * @return \Illuminate\View\View
     */
    public function providerindex()
    {
        $orders = User::findOrFail(Auth::user()->id)->providerorders;
        foreach($orders as $order) {
            $auto = Auto_registration::findOrFail($order->auto_registration_id);
            $order['auto_registration'] = $auto;
        }

        return view('orders.provider', compact('orders'));
    }

    /**
     * Užsakovo pateikti užsakymai
     *
     * @return \Illuminate\View\View
     */
    public function showclient($order_key, $order_id)
    {
        return view('orders.showclient');
    }

    /**
     * Užsakymai, kurie yra pateikti vežėjui
     *
     * @return \Illuminate\View\View
     */
    public function showprovider($order_key, $order_id)
    {
        $order = User::findOrFail(Auth::user()->id)->providerorders()->where('order_key', $order_key)->where('id', $order_id)->get();

        return view('orders.showprovider', compact('order'));
    }
}
