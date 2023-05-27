<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;

class CitiesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CitiesController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of cities,
    | creating, updating and deleting cities.
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
     * Display a listing of the cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        if($request->search){
            $search = $request->search;
            $cities = City::where('name','LIKE',"%{$search}%")->paginate(10);
            $title = "Search results for \"{$search}\"";
        }else{
            $cities = City::orderBy('created_at','desc')->paginate(12);
        }
        
        return view('admin.cities.index',[
            'cities' => $cities,
            'title'  => $title
        ]);
    }

    /**
     * Show the form for creating a new city.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created city in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);
        
        $city = new City();
        $this->createOrUpdateCity($city,$request->name);
        
        return redirect()
            ->route('admin.cities.index')
            ->with('status','City has been created successfully!');
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->showCity($id,'edit');
    }

    /**
     * Update the specified city in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $city = City::findOrFail($id);
        $this->createOrUpdateCity($city,$request->name);
        
        return redirect()
            ->route('admin.cities.index')
            ->with('status','Selected city has been updated!');
    }

    /**
     * Remove the specified city from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        
        return redirect()
            ->back()
            ->with('status','Selected city has been deleted!');
    }

    /**
     * Validate the request.
     * 
     * @param \Illuminate\Htto\Request $request
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
        $city = "/^[a-zA-Z0-9 ]+$/";
        return [
            'name' => "required|regex:{$city}|min:5|max:50"
        ];
    }

    /**
     * Validation rules.
     * 
     * @return array
     */
    private function messages(){
        return [
            'regex' => 'Only numbers, letters, and spaces are allowed'
        ];
    }

    /**
     * Create a new or update an existing city.
     * 
     * @param \App\City $city
     * @param string $name
     * @return void
     */
    private function createOrUpdateCity($city,$name){
        $city->name = $name;
        $city->save();
    }

    /**
     * Show a view with city.
     * 
     * @param int $id
     * @param string $view
     * @return \Illuminate\Http\Response
     */
    private function showCity($id,$view){
        $city = City::findOrFail($id);
        return view("admin.cities.{$view}",[
            'city' => $city
        ]);
    }
}
