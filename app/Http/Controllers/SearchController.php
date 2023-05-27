<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;

class SearchController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SearchController
    |--------------------------------------------------------------------------
    |
    | This controller Handle's AJAX search or just submitted product search.
    |
    */


    /**
     * Perform Product Search
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
        
        $str = $request->search;
        
        $products = Product::where('title','LIKE',"%{$str}%")
            ->orderBy('created_at','desc')
            ->paginate(12);

        $categories = Category::all();
        
        $title = "Search Results for \"{$str}\"";
        
        return view('home.products',[
            'products'   => $products,
            'categories' => $categories,
            'title'      => $title,
        ]);

    }

    /**
     * Perform AJAX search
     * 
     * @param string $str
     * @return \Illuminate\Http\JsonReponse
     */
    public function ajaxSearch($str){
        
        $products = Product::select(['title','slug'])
            ->where('title','LIKE',"%{$str}%")
            ->take(5)
            ->get();

        return response()->json([
            'products' => $products,
        ]);

    }
}
