<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Wishlist;
use Auth;

class WishlistsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WishlistsController
    |--------------------------------------------------------------------------
    |
    | This controller handles all the functionality related to customer's
    | wishlist like add products to wishlist,checking if that product already
    | exists, removing the products from wishlist.
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
        $this->middleware('auth');
    }

    /**
     * Display a list of customer's wishlist
     * items.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $wishlists = Auth::user()->wishlist()->paginate(10);
        return view('wishlist.index',[
            'wishlists' => $wishlists
        ]);
    }
    
    /**
     *  Store a wishlist product to storage.
     * 
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        if(!Auth::check()){
            return $this->addWishlistResponse('Please Login/Register to use Wishlist!');
        }
        
        //Validate incoming request
        $this->validate($request,['_id' => 'required|integer']);

        $product = Product::findOrFail($request->_id);

        $p_id = $product->id;

        $result = $this->createWishlist($p_id);
        
        //Product Already Exists
        if(!$result->wasRecentlyCreated){
            return $this->addWishlistResponse('Product already exists in the wishlist!');
        }

        return $this->addWishlistResponse('Product added to wishlist');
    }
    
    /**
     * Return Json Response when adding an
     * item to customer's wishlist
     * 
     * @param string $msg
     * @return \Illuminate\Http\Response
     */
    private function addWishlistResponse($msg){
        return response()
            ->json([
                'message' => $msg
            ]);
    }

    /**
     * Remove product from customer's wishlist.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $wishlist = Wishlist::destroy($id);
        
        return redirect()
            ->back()
            ->with('status','Wishlist item has been deleted!');
    }

    /**
     * Retrieve the first matching wishlist item or
     * create one.
     * 
     * @param int $p_id
     * @return App\Wishlist
     */
    private function createWishlist($p_id){
        return Wishlist::firstOrCreate([
            'product_id' => $p_id,
            'user_id' => Auth::id()
        ]);
    }
}
