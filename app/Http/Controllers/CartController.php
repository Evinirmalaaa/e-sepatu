<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cart::all();

        return response()->json([
            "message" => "Load data success",
            "data" => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->all();
        $product = DB::table('products')->select('price', 'stock')->where('id', $request->produk_id)->first();
        if ($request->diskon_id) {
            $validate += ['diskon_id' => $request->diskon_id];
            $diskon = DB::table('diskons')->select('potongan')->where('id', $request->diskon_id)->first();
            $diskon = $diskon->potongan;
        } else {
            $diskon = 0;
        }
        $diskon = (int)$product->price * (int)$diskon / 100;
        $total_harga = (int)$product->price * (int)$validate['jumlah'] - $diskon;

        $validate += [
            'total_harga' => $total_harga
        ];

        $table = Cart::create($validate);
        return response()->json([
            "message" => "Store success.",
            "data" => $table
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = Cart::find($id);
        if($table){
            return $table;
        }else{
            return ["message" => "Data not found"];
        }
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
    public function update(Request $request, Cart $cart)
    {
        $data = $request->all();
        if ($request->jumlah) {
            $data += [
                'total_harga' => (int)$cart->product->price * (int)$request->jumlah
            ];
        }
        $update = Cart::where("id", $cart->id)->update($data);

        // return $update;
         return response()->json([
            "message" => "Update data success",
            "data" => $update
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Cart::find($id);
        if($table){
            $table->delete();
            return ["message" => "Delete success!"];
        }else{
            return ["message" => "Data not found."];
        }
    }
}
