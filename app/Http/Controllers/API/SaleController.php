<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sale;
use App\product;
use App\company;
use App\Http\Requests\ProductRequest;

class SaleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showSale(Request $request) {   
        \DB::beginTransaction();
        try {
            $product = Product::find($request->id);
            $stock = $product->stock;
            if ($stock > 0){
                $sale = new Sale;
                $sale->product_id = Product::find($request->id) -> id;
                $sale->save();
                // productsテーブルの在庫数を減算する
                Product::where('id', $request->id)->decrement('stock', 1); 
                \DB::commit();
            }
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return response()->json(compact('sale','stock'));
    }
}
