<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ProfileController
    |--------------------------------------------------------------------------
    |
    | This controller will Show and Update customer profile.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // for guests that are not logged in as admin.
        // Except for logout method.
        $this->middleware('auth');
    }
    
    /**
     * Show Admin Profile
     *  
     * @return \Illuminate\Http\Response
     */
    public function show(){
        return view('profile.index');
    }

    /**
     * update Profile
     *  
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $this->validateRequest($request);
        
        $this->updateUser($request);

        return redirect()
            ->back()
            ->with('status','User profile has been updated!');
    }

    /**
     * Delete customer account including reviews
     * and wishlist.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        
        //just to make sure that the id matches
        if(!Auth::id() === $id){
            return redirect()->back();
        }

        $user = Auth::user();

        //delete all the wishlist items
        $user->wishlist()->where('user_id',$id)->delete();
        
        //delete all the reviews
        $user->reviews()->where('user_id',$id)->delete();
        
        //logout the customer
        Auth::logout();
        
        //delete the customer
        $user->delete();
        
        //Notify the user with email
        $user->customerHasBeenDeleted();

        return redirect()->route('index')->with('status','your account has been deleted!');
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
        $name = "/^[a-zA-Z0-9 ]+$/";
        $password = "/^[a-zA-Z0-9_ -]+$/";
        
        return [
            'name' => "required|regex:{$name}|min:3|max:50",
            'email' => 'required|email|min:7|max:150',
            'password' => "nullable|regex:{$password}|min:7|max:100"
        ];
    }

    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'name.regex' => 'Only letters and spaces are allowed!',
            'password.regex' => 'Only numbers, letters, underscores, and dashes are allowed!'
        ];
    }

    /**
     *  Update the Customer (User)
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return void
     */
    private function updateUser(Request $request){
        // get the current admin with Auth facade
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        /**
         *  if we are updating the password.
         *  if left empty then don't update
         *  password. 
         */
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
    }
}
