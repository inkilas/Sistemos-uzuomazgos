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
use Illuminate\Support\Facades\Mail;
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
        $countries = Country::lists('country', 'id');
        $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return view('orders.create', compact('categories', 'number', 'countries'));
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
        $autos_by_categories_filter = Category::find($ordersession['category_id'])->auto_registration()->where('user_id', '!=', Auth::user()->id)->get();
        $autos_by_categories = array();
        foreach($autos_by_categories_filter as $key => &$autos_by_category){
            $auto_countries = $autos_by_category->countries()->where('id', $ordersession['deliver_country'])->get();
            foreach($auto_countries as $auto_country){
                $autos_by_category['country'] = $auto_country->country;
            }
            if($autos_by_category->country == ''){
                unset($autos_by_category);
            }else {
                $autos_by_categories[] = $autos_by_category;
            }
        }

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

        $updated = $updateID.$ordersession['order_key'];
        $mailers_orders = Order::where('order_key', $updated)->get();
        foreach($mailers_orders as $key => $mailer_order){
            foreach($mailer_order->provider()->get() as $key => $mailer) {
                $mailer_order['provider'] = $mailer;
            }
            $mailer_auto = $mailer_order->provider->user_auto()->where('id', $mailer_order->auto_registration_id)->get();
            Mail::send('emails.provider_email', array('order_key' => $mailer_order->order_key, 'id' => $mailer_order->id), function($message) use ($mailer_order, $mailer_auto) {
                $message->to( $mailer_order->provider->email, $mailer_order->provider->name. ' ' . $mailer_order->provider->surname)->subject('Užsakymas '. $mailer_order->order_key .' Jūsų automobiliui ' . $mailer_auto[0]->auto_name);
            });
        }
        Session::forget('order');
        session()->flash('send_order', 'Užsakymas '.  $updated .' buvo sėkmingai pateiktas!');
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
     * Nukreipiama, kur galima peržiūrėti kokius užsakymus pateikė
     *
     * @return \Illuminate\View\View
     */
    public function clientindex()
    {
        $orders = Order::where('client_id', Auth::user()->id)->get();
        $orders_keys = array();
        $temp = 0;
        foreach($orders as $key => $order) {
            $auto = Auto_registration::findOrFail($order->auto_registration_id);
            $order['auto_registration'] = $auto;
            if ($order->order_key != $temp){
                $orders_keys[] = $order;
            }
            $temp = $order->order_key;
        }
        return view('orders.client', compact('orders', 'orders_keys'));
    }

    /**
     * Nukreipiama, gur vežėjas gali peržiūrėti kokius užsakymus kiti yra klientui(vežėjui) pateikę
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
    public function showclient($order_key)
    {
        $orders = User::findOrFail(Auth::user()->id)->clientorders()->where('order_key', $order_key)->get();
        foreach($orders as $key => $order) {
            $auto = Auto_registration::findOrFail($order->auto_registration_id);
            $order['auto_registration'] = $auto;
        }

        return view('orders.showclient', compact('orders', 'order_key', 'order'));
    }

    /**
     * Užsakymai, kurie yra pateikti vežėjui
     *
     * @return \Illuminate\View\View
     */
    public function showprovider($order_key, $order_id)
    {
        $orders = User::findOrFail(Auth::user()->id)->providerorders()->where('order_key', $order_key)->where('id', $order_id)->get();
        foreach($orders as $key => $order) {
            $auto = Auto_registration::findOrFail($order->auto_registration_id);
            $order['auto_registration'] = $auto;
        }
        return view('orders.showprovider', compact('orders'));
    }

    /**
     * Užsakymo patvirtinimas
     *
     * @param $order_key
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($order_key, $order_id)
    {
        $order = Order::where('provider_id', Auth::user()->id)->where('order_key', $order_key)->findOrFail($order_id);
        $order->update(['order_activation' => 1]);
        Order::where('order_key', $order_key)->where('order_activation', '!=', '1' )->delete();
        session()->flash('confirm_order', 'Užsakymas '.  $order_key .' buvo sėkmingai patvirtintas!');

        $provider = $order->provider()->firstOrFail()->toArray();
        $client = $order->client()->firstOrFail();
        $auto = Auto_registration::where('id', $order->auto_registration_id)->firstOrFail()->toArray();
        $order_info = $order->toArray();

        Mail::send('emails.client_email', compact('provider', 'auto', 'order_info'), function($message) use($client, $order)
        {
           $message->to($client->email, $client->name. ' ' .$client->surname)->subject('Jūsų užsakymas '. $order->order_key .' buvo patvirtintas');
        });

        return redirect('orders/provider');
    }

    /**
     * Ištrina užsakymą
     *
     * @param $order_key
     * @param $order_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy_provider($order_key, $order_id)
    {
        Order::where('provider_id', Auth::user()->id)->where('order_key', $order_key)->findOrFail($order_id)->delete();
        session()->flash('delete_order', 'Užsakymas '.  $order_key .' buvo sėkmingai atšauktas!');
        return redirect('orders/provider');
    }

    public function destroy_client($order_key, $order_id)
    {
        $order = Order::where('client_id', Auth::user()->id)->where('order_key', $order_key)->findOrFail($order_id);
        $auto = Auto_registration::where('id', $order->auto_registration_id)->get();
        session()->flash('delete_order', 'Užsakymas, kurio automobilis yra '.  $auto[0]->auto_name .' buvo sėkmingai atšauktas!');

        $order->delete();
        $exist = Order::where('client_id', Auth::user()->id)->where('order_key', $order_key)->first();
        if($exist != null) {
            return redirect('orders/client/' . $order_key);
        }else {
            session()->flash('delete_all_order', 'Visi užsakymai '.  $order_key .' buvo sėkmingai atšaukti!');
            return redirect('orders/client');
        }

    }
}
