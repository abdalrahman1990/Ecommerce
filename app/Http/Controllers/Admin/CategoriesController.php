<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoriesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CategoriesController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of categories,
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = null;
        if($request->search){
            $search = $request->search;
            $categories = Category::where('title','LIKE',"%{$search}%")->paginate(10);
            $title = "Search results for \"{$search}\"";
        }else{
            $categories = Category::orderBy('created_at')->paginate(10);
        }
        return view('admin.categories.index',[
            'categories' => $categories,
            'title' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCategory($request);
        $category = new Category();
        $this->createOrUpdateCategory($category,$request);
        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Category Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit',[
            'category' => $category
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
        $this->validateCategory($request);
        $category = Category::findOrFail($id);
        $this->createOrUpdateCategory($category,$request);
        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        //check if category has products.
        if($category->products->count()){
            /**
             * Note: foreign key constraint fails.
             * we cannot delete a category that
             * is related to a product.
             */

            return redirect()
                ->route('admin.categories.index')
                ->with('status','Cannot delete a category that has products!');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status','Selected Category has been deleted!');
    }

    /**
     *  Validate the Category Request
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return void
     */
    private function validateCategory(Request $request){

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
        $regex = "/^[a-zA-Z0-9_ -]+$/";

        return [
            'title' => "required|regex:{$regex}|min:5|max:50"
        ];
    }

    /**
     * Validation messages.
     * 
     * @return array
     */
    private function messages(){
        return [
            'regex' => 'Only numbers, letters, underscores, spaces, and dashes are allowed!'
        ];
    }

    /**
     *  Create or update Category
     *  
     *  @param \App\Category $category
     *  @param \Illuminate\Http\Request $request
     *  @return void
     */
    private function createOrUpdateCategory(Category $category,Request $request){
        $category->title = $request->title;
        $category->slug  = str_replace(' ','-',$request->title);
        $category->save();
    }
}
