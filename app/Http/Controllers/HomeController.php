<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Review;
use App\Category;
use App\City;
use Auth;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HomeController
    |--------------------------------------------------------------------------
    |
    | This controller will show pages like home page, products
    | page, displaying product details, about, cart, search, etc...
    |
    */


    /**
     * Display Index Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::take(8)->get();
        return view('home.index',[
            'products' => $products
        ]);
    }

    /**
     * Display Products Page
     *
     * @return \Illuminate\Http\Response
     */
    public function products(Request $request)
    {
        $this->validateRequest($request);

        $sortBy = $request->sort_by;
        
        //if we don't have any count then set it to 12.
        $items = ($request->items_per_page) ? : 12;

        $categories = Category::all();
        
        $category = $request->category;
        
        switch ($sortBy) {
            case 'name':
                $products = $this->getProducts($category,'title','desc',$items);
            break;
            
            case 'high-to-low':
                $products = $this->getProducts($category,'price','desc',$items);
            break;
            
            case 'low-to-high':
                $products = $this->getProducts($category,'price','asc',$items);
            break;
            
            case 'latest':
            default:
                $products = $this->getProducts($category,'created_at','desc',$items);
            break;
        }
        
        return view('home.products',[
          'products' => $products,
          'categories' => $categories,
        ]);
    }

    /**
     * Display a Single Product
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function showProduct($slug)
    {
        $product = Product::where('slug',$slug)
            ->first();
        
        $reviews = Review::where(['status' => true,'product_id' => $product->id])
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('home.product-details',[
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }

    /**
     * Display About Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function about()
    {
        return view('home.about');
    }

    /**
     * Display Contact Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('home.contact');
    }

    /**
     * Display Cart Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        return view('home.cart');
    }

    /**
     * Display Checkout/Order Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function checkout(){
        if(!Auth::check()){
            return redirect()
                ->route('login')
                ->with('status','Please Login or Register to Place the Order!');
        }

        if(!\Cart::count()){
            return redirect()->route('cart.index');
        }
        
        $cities = City::all();

        return view('home.checkout',[
            'cities' => $cities
        ]);
    }

    /**
     * Get products by options or just retrieve all.
     * 
     * @param string $category
     * @param string|created_at $sortBy
     * @param string|desc $order
     * @param int|12 $item
     * @return \Illuminate\Support\Collection
     */
    private function getProducts( $category, $sortBy = "created_at", $order = "desc", $items = 12){
        if(!$category || $category == "all"){
            return Product::orderBy($sortBy,$order)
                ->paginate($items);
        }else{
            return Category::where('slug',$category)
                ->first()
                ->products()
                ->orderBy($sortBy,$order)
                ->paginate($items);
        }
    }


    /**
     * Validate the Request
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
    private function rules(){
        return [
            'sort_by' => 'nullable|alpha_dash',
            'items_per_page' => 'nullable|integer|min:1|max:25',
            'category' => 'nullable|alpha_dash',
        ];
    }
}
