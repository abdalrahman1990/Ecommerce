<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
use App\City;

class AddressesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AddressesController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of addresses,
    | creating, updating and deleting addresses.
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
     * Display a listing of all Addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        
        if($request->search){
            $search = $request->search;
            $option = ($request->option) ? : 'address_1' ;
            
            $addresses = $this->getAddresses($option,$search);

            $option = $this->optionName($option);
            $title = "Search results by {$option} for \"{$search}\"";
        }else{
            $addresses = Address::orderBy('created_at')->paginate(10);
        }

        return view('admin.addresses.index',[
            'addresses' => $addresses,
            'title'     => $title
        ]);
    }

    /**
     * Show the form for creating a new Address.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();

        return view('admin.addresses.create',[
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created Address in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        $address = new Address();
        $this->createOrUpdateAddress($request,$address);

        return redirect()
            ->route('admin.addresses.index')
            ->with('status','New Address has been created!');
    }

    /**
     * Display the specified Address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->showAddress($id,'show');
    }

    /**
     * Show the form for editing the specified Address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $address = Address::findOrFail($id);
        $cities = City::all();

        return view('admin.addresses.edit',[
            'address' => $address,
            'cities'  => $cities
        ]);
    }

    /**
     * Update the specified Address from database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $address = Address::findOrFail($id);
        $this->createOrUpdateAddress($request,$address);

        return redirect()
            ->route('admin.addresses.index')
            ->with('status','Selected Address has been updated!');
    }

    /**
     * Remove the specified Address from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        
        if($address->orders->count()){
            return redirect()
                ->back()
                ->with('status','Cannot delete an address that belongs to an order!');
        }
        
        $address->delete();
        
        return redirect()
            ->route('admin.addresses.index')
            ->with('status','Selected address has been deleted!');
    }

    /**
     * Validate Request
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateRequest(Request $request){

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
        $postalcode = "/^[a-zA-Z0-9]+$/";

        return [
            'address_1'   => "required|regex:{$address}|min:5|max:500",
            'address_2'   => "required|regex:{$address}|min:5|max:500",
            'city'        => "required|integer",
            'postal_code' => "required|regex:{$postalcode}|min:3|max:50"
        ];
    }

    /**
     * custom validation message
     * 
     * @return array
     */
    private function messages(){
        return [
            'address_1.regex' => 'Only numbers, letters, dashes, and spaces are allowed',
            'address_2.regex' => 'Only numbers, letters, dashes, and spaces are allowed',
            'postal_code.regex' => 'Only numbers and letters are allowed'
        ];
    }

    /**
     * Create a new or update an existing 
     * address.
     * 
     * @param \Illuminate\Http\Request $request
     * @param App\Address $address
     * @return void
     */
    private function createOrUpdateAddress(Request $request,Address $address){
        $address->address_1 = $request->address_1;
        $address->address_2 = $request->address_2;
        $address->city_id = $request->city;
        $address->postal_code = $request->postal_code;
        $address->save();
    }

    /**
     * Show a view with address
     *  
     * @param int $id
     * @param string $view
     * @return \Illuminate\Http\Response
     */
    private function showAddress($id,$view){
        $address = Address::findOrFail($id);
        return view("admin.addresses.{$view}",[
            'address' => $address
        ]);
    }

    /**
     * modify the option name
     * 
     * @param string $option
     * @return string
     */
    private function optionName($option){
        switch ($option) {
            
            case 'address_2':
                return 'Address line 2';
            break;
            
            case 'city':
                return 'City';
            break;
            
            case 'postal_code':
                return 'Postal Code';
            break;
            
            case 'address_1':
            default:
                return 'Address line 1';
            break;
        }
    }

    /**
     * search for addresses.
     * 
     * @param string $option
     * @param string $search
     * @return \App\Address
     */
    private function getAddresses($option,$search){
        if($option == "city"){
            return Address::whereHas('city',function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%");
            })->paginate(10);
        }else{
            return Address::where($option,'LIKE',"%{$search}%")->paginate(10);
        }
    }
}
