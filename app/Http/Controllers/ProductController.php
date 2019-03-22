<?php

namespace App\Http\Controllers;

use App\Http\Requests\addProduct;
use App\Http\Resources\ProductResources;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request){
        $products  = Product::latest()->paginate(100);
        return ProductResources::collection($products)->additional([
            'total_sum' =>  '$'.number_format($products->sum('price_per_item') * $products->sum('quantity')),
        ]);
    }

    /**
     * @param \App\Http\Requests\addProduct $request
     *
     * @return \App\Product
     */
    public function store(addProduct $request){
        $user= \Auth::user();
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->quantity = $request->quantity_in_stock;
        $product->price_per_item = $request->price_per_item;
        $product->user()->associate($user);
        $product->save();
        return $product;
    }

    /**
     * @param $id
     * @param \App\Http\Requests\addProduct $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, addProduct $request){
       $product = Product::where('id', $id)->where('user_id', auth()->id())->first();
        $product->product_name = $request->product_name;
        $product->quantity = $request->quantity_in_stock;
        $product->price_per_item = $request->price_per_item;
        $product->save();

        return redirect()->route('home');

    }

    /**
     * @param \App\Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product){
        return view('editProduct', compact('product'));
    }

    /**
     * @param $ids
     * @param \Illuminate\Http\Request $request
     */
    public function destroy($ids, Request $request){
        $user= \Auth::user();
        $user->products()->whereIn('id', explode(',', $ids))->delete();
    }
}
