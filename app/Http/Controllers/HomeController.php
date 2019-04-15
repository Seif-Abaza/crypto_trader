<?php

namespace App\Http\Controllers;

use App\Client\Coinbase\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

//        $order = new Order();

//        $response = $order->createOrder(['size' => 0.1, 'price' => 100, 'side' => 'sell', 'product_id' => 'LTC-EUR']);
//        $response = $order->getOrders();

//        return response()->json($response);

        return view('home');
    }
}
