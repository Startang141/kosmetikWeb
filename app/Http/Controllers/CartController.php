<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['cart'] = Cart::with('produk')->where('id_user', auth()->user()->id)->get();
        return view('homepage.cart.index', $data);
    }

    function totalCart()
    {
        $id = auth()->user()->id;
        $data = Cart::with('id_user')->findOrFail($id);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }


    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        Cart::create([
            'id_produk' => $request->id_produk,
            'id_user' => $userId,
        ]);

        return redirect()->route('detail', $request->id_produk);
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Cart::findOrFail($id);
        $data->delete();
        return redirect()->route('cart.index');
    }
}