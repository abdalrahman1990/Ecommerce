<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class CustomersController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CustomersController
    |--------------------------------------------------------------------------
    |
    | This controller will store and update customers to the database.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        if($request->search){
            $search = $request->search;
            $option = ($request->option) ? : 'name' ;
            $customers = User::where($option,'LIKE',"%{$search}%")->paginate(10);
            $title = "Search results by {$option} for \"{$search}\"";
        }else{
            $customers = User::orderBy('created_at')->paginate(10);
        }
        
        return view('admin.customers.index',[
            'customers' => $customers,
            'title'     => $title
        ]);
    }

    /**
     * Show a form for creating a new Customer.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.customers.create');
    }

    /**
     * Store a new Customer to the database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validateRequest($request,null);
        $customer = new User();
        $this->createOrUpdateCustomer($request,$customer);
        return redirect()
            ->route('admin.customers.index')
            ->with('status','New customer has been created!');
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit',[
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request,$id);
        $customer = User::findOrFail($id);
        $this->createOrUpdateCustomer($request,$customer);
        return redirect()
            ->route('admin.customers.index')
            ->with('status','Selected Customer has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete the customer (User)
    }

    /**
     * Validate the request.
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    private function validateRequest(Request $request,$id){
        
        $rules = $this->rules($id);

        $messages = $this->messages();

        $this->validate($request,$rules,$messages);
    }

    /**
     * Validation rules
     * 
     * @return array
     */
    private function rules($id){
        $name = "/^[a-zA-Z ]+$/";
        $password = "/^[a-zA-Z0-9_ -]+$/";
        
        return [
            'name' => "required|regex:{$name}|min:3|max:50",
            'email' => 'required|email|min:7|max:150',
            'password' => ((!$id) ? "required" : "nullable" )."|regex:{$password}"
        ];
    }

    /**
     * Validation messages
     * 
     * @return array
     */
    private function messages(){
        return [
            'name.regex' => 'Only letters and spaces are allowed!',
            'password.regex' => 'Only numbers, underscores, dashes, and letters are allowed!',
        ];
    }

    /**
     * Create a new Customer or update an existing customer.
     * 
     * @param \Illuminate\Http\Request $request
     * @param App\User $customer
     * @return void
     */
    private function createOrUpdateCustomer(Request $request,User $customer){
        $customer->name = $request->name;
        $customer->email = $request->email;
        if($request->password){
            $customer->password = Hash::make($request->password);
        }
        $customer->save();
    }
}
