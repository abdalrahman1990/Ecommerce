<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Product;
use App\Category;

class ProductsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ProductsController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of products ,
    | displaying details of a single product , creating ,updating and
    | deleting products.
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
            $option = ($request->option) ? : 'title' ;
            $products = Product::where($option,'LIKE','%'.$search.'%')->paginate(10);
            $title = "Search results by {$option} for \"{$search}\"";
        }else{
            $products = Product::orderBy('created_at')->paginate(10);
        }
        return view('admin.products.index',[
            'products' => $products,
            'title'    => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',[
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateProduct($request,null);
        $product = new Product();
        if($request->hasFile('image')){
            $image = $this->uploadProductImage($request);
        }
        $this->createOrUpdateProduct($request,$product,$image);
        return redirect()->route('admin.products.index')->with('status','Product created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show',[
            'product' => $product
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit',[
            'product' => $product,
            'categories' => $categories
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
        $this->validateProduct($request,$id);
        $product = Product::findOrFail($id);
        $old_image = $product->image;
        if($request->hasFile('image')){
            $image = $this->uploadProductImage($request);
            Storage::delete('public/products/'.$old_image);
            
        }else{
            $image = '';
        }
        $this->createOrUpdateProduct($request,$product,$image);
        return redirect()
            ->route('admin.products.index')
            ->with('status','Selected Product has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrfail($id);
        
        //get the image associated with the product
        Storage::delete('public/products/'.$product->image);
        
        //get the product from database
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status','Selected Product has been deleted!');
    }


    /**
     *  Create or Update Product
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param App\Product $product
     *  @param string $image
     *  @return void
     */
    private function createOrUpdateProduct(Request $request,Product $product,$image){
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        if($request->hasFile('image')){
            $product->image = $image;
        }
        $product->slug = str_replace(' ','-',$request->title);
        $product->save();
    }

    /**
     *  Validate the Product Request
     * 
     *  @param \Illuminate\Http\Request $request
     *  @param int $id
     *  @return void
     */
    private function validateProduct(Request $request,$id){
        
        $rules = $this->rules($id);

        $messages = $this->messages();

        $this->validate($request,$rules,$messages);
        
    }

    /**
     * Validation rules.
     * 
     * @param int $id
     * @return array
     */
    private function rules($id){
        $title = "/^[a-zA-Z0-9. -]+$/";

        return [
            'title'        => "required|regex:{$title}|unique:products,title".( $id ? ",{$id}" : '' )."|min:10|max:50",
            'description'  => "required|string|min:30",
            'image'        => (($id) ? 'nullable|image|max:1999' : 'required|image|max:1999'),
            'category'     => 'required|integer',
            'price'        => 'required|numeric|min:1',
            'quantity'     => 'required|integer|min:1'
        ];
    }

    /**
     * Validation messages
     * 
     * @return array
     */
    private function messages(){
        return [
            'title.unique' => 'This product name already exists!',
            'regex' => 'Only numbers, letters, spaces, and dashes are allowed!'
        ];
    }

    /**
     *  Handle the image upload
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return string
     */
    private function uploadProductImage(Request $request){
        if($request->hasFile('image')){
            //get File name with extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            //get just Filename
            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);

            //get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();

            //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //upload the image
            $request->file('image')->storeAs('public/products',$fileNameToStore);

            return $fileNameToStore;
        }
    }
}
