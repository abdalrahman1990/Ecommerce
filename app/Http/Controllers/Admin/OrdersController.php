<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use App\Order;
use App\Product;

class OrdersController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OrdersController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of customer orders,
    | displaying details of a single order, updating and deleting customer
    | orders.
    | This controller is also responsible for adding, updating and removing 
    | products from customer order.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the Customer Orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        if($request->search){
            $search = $request->search;
            $orders = Order::whereHas('user',function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%");
            })->paginate(10);
            $title = "Search results for \"{$search}\"";
        }else{
            $orders = Order::orderBy('created_at')->paginate(10);
        }
        return view('admin.orders.index',[
            'orders' => $orders,
            'title'  => $title
        ]);
    }

    /**
     * Display the specified Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $products  = $order->products()->paginate(10);
        return view('admin.orders.show',[
            'order' => $order,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for editing the specified Order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $addresses = Address::all();
        $products = $order->products()->get();
        return view('admin.orders.edit',[
            'order'     => $order,
            'addresses' => $addresses,
            'products'  => $products
        ]);
    }

    /**
     * Update the specified Order in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $order = Order::findOrFail($id);
        
        $this->updateOrder($request,$order);

        return redirect()
            ->route('admin.orders.index')
            ->with('status','Selected order has been updated!');
    }

    /**
     * Remove the specified Order from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        if($order->payment){
            return $this->redirect('Cannot deleted an Order thats related to payments!');
        }
        
        //remove all the products from pivot table
        $order->products()->detach();
        
        $order->delete();
        
        return $this->redirect('Selected Order has been deleted!');
        
    }


    /**
     * Validate Request
     *  
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateRequest(Request $request){
        $rules = $this->rules();
        $this->validate($request,$rules);
    }

    /**
     * Validation rules.
     * 
     * @return array
     */
    private function rules()
    {
        return [
            'total' => 'required|integer|min:1',
            'paid'  => 'required|boolean',
            'address' => 'required|integer'
        ];
    }

    /**
     * Update Order
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function updateOrder(Request $request,Order $order){
        $order->paid = $request->paid;
        $order->address_id = $request->address;
        $order->total = $request->total;
        $order->save();
    }
    
    /**
     * redirect with message
     * 
     * @param string $msg
     * @return \Illuminate\Http\Response
     */
    private function redirect($msg){
        return redirect()
            ->back()
            ->with('status',$msg);
    }

    /**
     * Show a view for updating customer's
     * ordered products.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id){

        $order = Order::findOrFail($id);
        
        $products = Product::all();

        $orderedProducts = $order->products()->paginate(10);
        
        return view('admin.orders.update-products',[
            'order'    => $order,
            'products' => $products,
            'orderedProducts' => $orderedProducts
        ]);

    }

    /**
     * Add products to the customer's order.
     * 
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct($id,Request $request){
        $this->validateProduct($request);

        $qty = $request->qty;
        $p_id = $request->product;

        $product = Product::findOrFail($p_id);
        
        if(!$product->hasStock($qty)){
            /**
             * requested quantity exceeds the product stock.
             * so, redirect the admin back with input data
             * and error message.
             */
            return $this
                ->redirect("Selected product doesn\'t have sufficient stock!")
                ->withInput();
        }

        $order = Order::findOrFail($id);

        $orderedProduct = $this->hasProduct($order,$p_id);
        
        if($orderedProduct){
            /**
             * product exists in the customer order.
             * so, just update the quantity.
             */
            $t_qty = $qty + $orderedProduct->pivot->qty;
            $this->updateProduct($order,$product,$t_qty);
        }else{
            /**
             * add a new product to pivot table.
             */
            $this->addProductToOrder($order,$p_id,$qty);
        }

        //update the order total
        $total = $product->price * $qty;
        $order->increment('total',$total);
        
        /**
         * decrement the quantity from products after
         * adding product to the order.
         */
        $product->decrement('quantity',$qty);
        
        return $this->redirect('Selected product has been added to the order!');
        
    }

    /**
     * Add product to the orders pivot table.
     * 
     * @param \App\Order $order
     * @param int $p_id
     * @param int $qty
     * @return void
     */
    private function addProductToOrder($order,$p_id,$qty){
            $order->products()
            ->attach($p_id,[
                'qty' => $qty
            ]);
    }

    /**
     * Update customer's ordered product.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\\Reponse
     */
    public function updateOrderedProduct($id,Request $request){
        
        $qty = (int)$request->qty;
        $p_id = $request->p_id;
        $order = Order::findOrFail($id);
        $product = Product::findOrFail($p_id);

        $orderedProduct = $this->hasProduct($order,$p_id);
        
        $p_qty = $orderedProduct->pivot->qty;
        
        if($qty == 0){
            /**
             * if quantity is set to none then, delete
             * product from pivot table and put the quantity
             * back to that product.
             */
            $this->deleteProduct($order,$product);
            $product->increment('quantity',$p_qty);
            
            /**
             * decrement the total because we a removing
             * the product.
             */
            $total = $product->price * $p_qty;
            $order->decrement('total',$total);
            
            return $this->redirect('Selected product has been deleted from customer order!');

        }else{
            /**
             * update the quantity from pivot table.
             */
            $this->updateProduct($order,$product,$qty);
            
            if($qty > $p_qty){
                /**
                 * if quantity is greater than the quantity from
                 * pivot table then, we want to decrement the quantity
                 * of product.
                 */
                $product->decrement('quantity',($qty - $p_qty));
            }else{
                /**
                 * if less then, we want to put that quantity back
                 * to the product.
                 */
                $product->increment('quantity',($p_qty - $qty));
            }
            
            $total = $product->price * ($qty - $p_qty);
            $order->increment('total',$total);

            return $this->redirect('updated the quantity of selected product!');
            
        }

    }

    /**
     * update the ordered product quantity from
     * pivot table.
     * 
     * @param \App\Order $order
     * @param \App\Product $product
     * @param int $qty
     * @return void
     */
    private function updateProduct(Order $order,Product $product,$qty){
        $order->products()
            ->updateExistingPivot($product,[
                'qty' => $qty
            ]);
    }

    /**
     * Delete customer's ordered product from
     * the pivot table.
     * 
     * @param \App\Order $order
     * @param \App\Product $product
     * @return void
     */
    private function deleteProduct(Order $order,Product $product){
        $order->products()->detach($product);
    }

    /**
     * return the product if exists in the pivot table.
     * 
     * @param \App\Order $order
     * @param int $id
     * @return bool
     */
    private function hasProduct(Order $order,$id){
        return $order->products()->where('product_id',$id)->first();
    }

    /**
     * Validate add product request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateProduct(Request $request){
        $rules = [
            'product' => 'required|integer',
            'qty'     => 'required|integer'
        ];

        $messages = [
            'product.required' => 'Please select a product',
            'qty.required'     => 'Please specify a quantity'
        ];

        $this->validate($request,$rules,$messages);
    }
}
