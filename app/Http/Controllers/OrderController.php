<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_Transaction;
use App\User;
use App\Address;
use App\Product;
use App\Order;
use Auth;
use Cart;
use App\Events\OrderWasCreated;
use App\Events\OrderFailed;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OrderController
    |--------------------------------------------------------------------------
    |
    | This controller will show customer order history page.It will create
    | orders and process payment to braintree.
    |
    | Note : We are Using User model for Customers (I guess, i was too lazy to change that.).
    */

    /**
     * Show customer order history
     *  
     * @return \Illuminate\Http\Response
     */
    public function index(){
        /**
         * get all the successful orders related to
         * the authenticated customer.
         */
        $orders = Auth::user()->orders()->where('paid',true)->paginate(10);
        
        /**
         *  we will use this array to calculate
         *  the quantity of products in each order.
         */
        $qty = [];
        
        return view('order.index',[
            'orders' => $orders,
            'qty' => $qty
        ]);
    }

    /**
     *  Show a single order with details
     *  
     *  @param int $id
     *  @return \Illuminate\Http\Response
     */
    public function show($id){
        $order = Order::findOrFail($id);
        $products = $order->products()->paginate(10);
        return view('order.show',[
            'order' => $order,
            'products' => $products
        ]);
    }

    /**
     * Create Customer Orders
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the Request
        $this->validateOrder($request);
        
        //If not Authenticated.
        $this->notAuthenticated();

        //get the Cart products.
        $items = Cart::content();

        if(!$this->areProductsAvailable($items)){
            return redirect()
                ->route('cart.index')
                ->with([
                    'status' => 'Some products in your cart are low in stock or not available!',
                ]);
        }

        /**
         *  Get the total from cart.
         *  it will return a string after total exceeds
         *  999, so we are casting it to float. 
         */
        $total = (float)Cart::total(2,'.','');
        
        //create or get the first customer address.
        $address = $this->firstOrCreateAddress($request);
        
        $payment = $this->processPayment($request->nonce,$total);

        //create the order.
        $order = $this->createOrder($address->id,$total);

        //Payment process failed
        if(!$payment->success){
            //fire the event
            event(new OrderFailed($order));

            //redirect back with a message
            return redirect()
                ->back()
                ->with('status','Sorry! couldn\'t complete the payment process. Please try again.');
        }

        //get the cart products as eloquent models.
        $products = $this->getProducts($items);

        //get the cart products quantities.
        $quantities = $this->getQuantities($items);
        
        //Save the orders
        $this->saveOrders($order,$products,$quantities);

        //Fire the Event
        event(new OrderWasCreated($order,$items,$payment->transaction->id));

        return redirect()
            ->route('cart.index')
            ->with('status','Checkout Successful!');

    }

    /**
     * Validate the Request
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateOrder(Request $request){

        $rules = $this->rules();

        $messages = $this->messages();

        $this->validate($request,$rules,$messages);

    }

    /**
     * Validation rules.
     * 
     * @return array
     */
    private function rules(){
        $address = "/^[a-zA-Z0-9 -]+$/";
        $postal_code = "/^[a-zA-Z0-9]+$/";

        return [
            'address_1'    =>  "required|regex:{$address}|min:7|max:500",
            'address_2'    =>  "nullable|regex:{$address}|min:7|max:500",
            'city'         =>  'required|integer',
            'postal_code'  =>  "required|regex:{$postal_code}|min:5|max:50",
            'nonce'        =>  'required|string'
        ];
    }

    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'address_1.regex' => 'Only numbers, letters, and dashes are allowed!',
            'address_2.regex' => 'Only numbers, letters, and dashes are allowed!',
            'postal_code.regex' => 'Only numbers and letters are allowed!'
        ];
    }

    /**
     * Return First or Create an address for Customer (user)
     * in the database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return App\Address
     */
    private function firstOrCreateAddress(Request $request){
        return Address::firstOrCreate([
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'city_id' => $request->city,
                'postal_code' => $request->postal_code
            ]);
    }

    /**
     * store customer order in the database.
     * 
     * @param string $hash
     * @param int $address_id
     * @param float $total
     * @return App\Order
     */
    private function createOrder($address_id ,$total ){
        /** 
         *  we can get the current authenticated user
         *  instance with Auth::user().
         */
        return Auth::user()->orders()->create([
        //  'hash' => $hash,
            'paid' => false,
            'total' => $total,
            'address_id' => $address_id,
        ]);
    }

    /**
     * Single order can have multiple products
     * so, we are storing the products (product_id)
     * and its quantites in orders_products table, 
     * associating it with single order with order_id.
     * 
     * @param App\Order $order
     * @param $products
     * @param array $quantities
     * @return void
     */
    private function saveOrders($order ,$products ,$quantities){
        $order->products()->saveMany(
            $products,
            $quantities
        );
    }

    /**
     * get all the products quantities from 
     * the cart.
     * 
     * @param \Cart $items
     * @return array
     */
    private function getQuantities($items){
        $qty = [];

        foreach($items as $item){
            $qty[] = [ 'qty' => $item->qty ];
        }

        return $qty;
    }

    /**
     * Update quantity get all the product 
     * models associated with the cart
     * 
     * @param \Cart $items
     * @return array $products
     */
    private function getProducts($items){
        $products = [];
            
        /**
         * We are associating cart item
         * with product model.
         * so we can use $item->model
         * to access the model.
         */
        foreach($items as $item){
            
            $products[] = $item->model;
        }

        return $products;
    }

    /**
     * If a User is Not logged in
     * 
     * @return \Illuminate\Http\Response
     */
    private function notAuthenticated(){
        if(!Auth::check()){
            return redirect()
                ->route('cart.index')
                ->with('status', 'Please Login to Checkout!');
        }
    }

    /**
     * Process Payment with Braintree
     * 
     * @param string $nonce
     * @param float $total
     * @return \Braintree_Transaction
     */
    private function processPayment($nonce ,$total ){
        return Braintree_Transaction::sale([
            'amount' => $total,
            'paymentMethodNonce' => $nonce,
            'options' => [
              'submitForSettlement' => True
            ]
        ]);
    }

    /**
     * Check if the products in the
     * cart are available or not.
     *
     * @param array $items
     * @return bool
     */
    private function areProductsAvailable($items){
        foreach($items as $item){
            if(!$item->model->hasStock($item->qty)){
                return false;
            }
        }
        return true;
    }
}
