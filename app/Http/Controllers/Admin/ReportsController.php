<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\User;
use App\Address;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ReportsController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying page that will generate
    | orders, customers, and products reports.
    |
    */

    public function __construct(){
        $this->middleware('auth:admin');
    }

    /**
     * This method handle's requests for report
     * types and date filters or just a
     * normal reponse with a view.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Reponse
     */
    public function index(Request $request){

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        
        $dates = [
                new Carbon($dateFrom),
                new Carbon($dateTo)
            ];
        
        $items = null;

        switch ($request->type) {
            case 'customers':
                ($dateFrom && $dateTo) ? 
                $items = User::whereBetween('created_at',$dates)->paginate(10) :
                $items = User::orderBy('created_at','desc')->paginate(10);
            break;

            case 'products':
                ($dateFrom && $dateTo) ? 
                $items = Product::whereBetween('created_at',$dates)->paginate(10) :
                $items = Product::orderBy('created_at','desc')->paginate(10);
            break;

            case 'addresses':
                ($dateFrom && $dateTo) ? 
                $items = Address::whereBetween('created_at',$dates)->paginate(10) :
                $items = Address::orderBy('created_at','desc')->paginate(10);
            break;
            
            case 'orders':
            default:
                ($dateFrom && $dateTo) ? 
                $items = Order::whereBetween('created_at',$dates)->paginate(10) :
                $items = Order::orderBy('created_at','desc')->paginate(10);
            break;
        }

        return view('admin.reports.index',[
            'items' => $items
        ]);

    }
}
