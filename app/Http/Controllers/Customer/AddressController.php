<?php

namespace App\Http\Controllers\Customer;

use App\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addressBook = Auth::user()->addressBook;

        return view('customer.dashboard.address.index', compact('addressBook'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = Auth::user()->addressBook()->create($request->all());

        if ($request->ajax()) return (string) $address;

        session()->flash('success', 'Address has been saved.');

        return redirect()->route('customer.address');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        return view('customer.dashboard.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        $address->update($request->all());

        session()->flash('success', 'Address has been updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  var  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy($address)
    {
        DB::table('addresses')->delete($address);

        session()->flash('success', 'Address has been deleted.');

        return back();
    }
}
