<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;

class ReviewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ReviewsController
    |--------------------------------------------------------------------------
    |
    | This controller will store customer reviews for products to the database.
    |
    */

    /**
     * Create a controller instance
     * 
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Store a new Customer Review
     * to the database.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //validate the review request
        $this->validateRequest($request);

        //create a review
        $this->createReview($request);

        return redirect()
            ->back()
            ->with('status','Your review has been published!');
    }

    /**
     * Validate the Request.
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
        $description = "/^[a-zA-Z0-9. -]+$/";
        
        return [
            'product_id'    => 'required|integer',
            'description'   => "required|regex:{$description}|min:5|max:500",
            'rating'        => 'required|integer|digits_between:1,5',
        ];
    }

    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'description.regex' => 'Only numbers, letters, and dashes are allowed!'
        ];
    }

    /**
     * Create the Review.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void 
     */
    private function createReview(Request $request){
        Review::create([
            'product_id' => $request->product_id,
            'user_id'    => Auth::id(),
            'text'       => $request->description,
            'rating'     => $request->rating,
        ]);
    }
}
