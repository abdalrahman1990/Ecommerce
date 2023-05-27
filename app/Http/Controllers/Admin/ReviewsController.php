<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;
use App\Product;
use App\User;

class ReviewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ReviewsController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of customer reviews
    | for products, updating and deleting those reviews.
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
            $option = ($request->option) ? : 'customer_name' ;
        
            switch ($option) {
                case 'product_name':
                    $reviews = Review::whereHas('product',function($query) use ($search){
                        $query->where('title','LIKE',"%{$search}%");
                    })->paginate(10);
                break;
        
                case 'rating':
                    $rating = ($search <= 5 && $search >= 1) ? $search : 1;
                    $reviews = Review::where('rating',$rating)->paginate(10);
                break;
        
                case 'customer_name':
                default:
                    $reviews = Review::whereHas('user',function($query) use ($search){
                        $query->where('name','like',"%{$search}%");
                    })->paginate(10);
                break;
            }
        
            $title = "Search results by{$option} for \"{$search}\"";
        
        }else{
            $reviews = Review::orderBy('created_at','desc')->paginate(10);
        }
        
        return view('admin.reviews.index',[
            'reviews' => $reviews,
            'title'   => $title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.reviews.edit',[
            'review' => $review,
            'users' => $users,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $this->updateReview($request, $id);

        return redirect()
            ->route('admin.reviews.index')
            ->with('status','Selected review has been updated!');
    }

    /**
     * Show a specified resource from storage
     * @param int id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $review = Review::findOrFail($id);
        
        return view('admin.reviews.show',[
            'review' => $review,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()
            ->route('admin.reviews.index')
            ->with('status','Selected review has been deleted!');
    }

    /**
     * Validate the Request
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
        $regex = "/^[a-zA-Z0-9. -]+$/";
        
        return [
            'user'        => 'required|integer|min:1',
            'product'     => 'required|integer|min:1',
            'description' => "required|regex:{$regex}|min:20|max:500",
            'rating'      => 'required|between:1,5',
            'status'      => 'required|boolean'
        ];
    }

    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'regex' => 'Only numbers, letters, dashes, and spaces are allowed!'
        ];
    }

    /**
     * Update Review
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function updateReview(Request $request,$id){
        $review = Review::findOrFail($id);
        $review->user_id = $request->user;
        $review->product_id = $request->product;
        $review->text = $request->description;
        $review->rating = $request->rating;
        $review->status = $request->status;
        $review->save();
    }
}
