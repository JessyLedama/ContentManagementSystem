<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;
use App\Mail\NewOrderMail;
use Mail;
use App\User;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Auth::user()->orders;

        return view('customer.dashboard.order.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Auth::user()->orders()->create($request->except('catalogue') + [
            'ordNo' => uniqid('ord-'),
            'status' => 'pending'
        ]);

        $order->catalogue()->attach(array_reduce(
            explode(',', $request->catalogue), function ($carry, $next) {
                list($id, $quantity) = explode(':', $next);
                return $carry + [intval($id) => ['quantity' => $quantity]];
            },
            []
        ));

        Mail::to(config('mail.admin.address'))->send(new NewOrderMail($order));

        return redirect()->route('customer.order.show', $order);
    }

    /**
     * Display a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order->load('catalogue', 'address');

        return view('customer.dashboard.order.show', compact('order'));
    }
}