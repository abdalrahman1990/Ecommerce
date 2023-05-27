<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CartController
    |--------------------------------------------------------------------------
    |
    | This controller handles all the functionality like adding products to
    | the cart, updating products or removing them from the cart.
    |
    */


    /**
     * Add Item to Cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCart(Request $request){
        $this->validate($request,[
            '_id' => 'required|integer',
            '_qty' => 'required|integer',
        ]);

        $id = $request->_id ;
        $qty = $request->_qty ;
        $product = Product::findOrFail($id);

        //if product has available stock
        if($product->inStock()){
            //Add item to Cart
            Cart::add(
                $product->id,
                $product->title,
                $qty,
                $product->price
            )->associate('App\Product');

            return $this->addCartResponse('Your Item has been added to Cart!');
        }

        return $this->addCartResponse('Item is out of stock!');

    }

    /**
     * Return Json Reponse when adding an
     * item to the cart.
     * 
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    private function addCartResponse($msg){
        return response()->json([
            'cart_count'  =>  Cart::count(),
            'msg'         =>  $msg,
        ]);
    }

    /**
     * Update/Remove Item from Cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request){
        $qty = $request->_qty;
        $id = $request->_rowId;
        
        // if user selects none then, remove that item from cart.
        if($qty == 0){
            Cart::remove($id);
            return $this->updateCartResponse('delete','Your selected item has been removed from cart!');
        }
        $product = Cart::get($id)->model;
        if(!$product->hasStock($qty)){
            return $this->updateCartResponse('update' , 'Invalid quantity!');
        }
        
        Cart::update($id,$qty);
        return $this->updateCartResponse('update','Your item quantity has been updated!');
    }

    /**
     * Return Json Response when updating cart
     * items.
     * 
     * @param string $type
     * @param string $msg
     * @return \Illuminate\Http\JsonResponse
     */
    private function updateCartResponse($type,$msg){
        return response()->json([
            'type'        =>  $type,
            'cart_count'  =>  Cart::count(),
            'total'       =>  Cart::total(),
            'tax'         =>  Cart::tax(),
            'subtotal'    =>  Cart::subtotal(),
            'msg'         => $msg
        ]);
    }
}
