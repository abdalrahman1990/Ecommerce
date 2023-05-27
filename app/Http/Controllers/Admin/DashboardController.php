<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use App\Order;
use App\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DashboardController
    |--------------------------------------------------------------------------
    |
    | This controller will display the admin dashboard.
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
     *  Show the Dashboard View
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index(){
        // Get Current date
        $date_current = Carbon::now()->toDateTimeString();
        
        /** 
         * Get date of previous month 
         */
        $prev_date1 = $this->getPrevMonth(1);
        $prev_date2 = $this->getPrevMonth(2);
        $prev_date3 = $this->getPrevMonth(3);
        $prev_date4 = $this->getPrevMonth(4);
        $prev_date5 = $this->getPrevMonth(5);

        //get orders count from a given range
        $order_ct_1 = $this->getOrderCount($prev_date1,$date_current);
        $order_ct_2 = $this->getOrderCount($prev_date2,$prev_date1);
        $order_ct_3 = $this->getOrderCount($prev_date3,$prev_date2);
        $order_ct_4 = $this->getOrderCount($prev_date4,$prev_date3);
        $order_ct_5 = $this->getOrderCount($prev_date5,$prev_date4);


        $orders_ct = $this->number_format_short(Order::count());
        $products_ct = $this->number_format_short(Product::count());
        $customers_ct = $this->number_format_short(User::count());
        $total_payments = $this->number_format_short(Order::sum('total'));

        $orders = Order::whereBetween('created_at',[
                $this->getPrevFiveDays(5),
                $date_current,
            ])
            ->orderBy('created_at','desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index',[
            'orders_ct'    =>  $orders_ct,
            'products_ct'  =>  $products_ct,
            'customers_ct' =>  $customers_ct,
            'total_payments'  =>  $total_payments,
            'order_ct_1'   =>  $order_ct_1,
            'order_ct_2'   =>  $order_ct_2,
            'order_ct_3'   =>  $order_ct_3,
            'order_ct_4'   =>  $order_ct_4,
            'order_ct_5'   =>  $order_ct_5,
            'orders'          =>  $orders,
        ]);
    }

    /**
     * Use to convert large positive numbers in to short form
     * like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc.
     * Credit: https://gist.github.com/RadGH/84edff0cc81e6326029c
     * (this method is taken from a comment)
     * 
     * @param int $n
     * @return string
     */
    private function number_format_short( $n ) {
        if ($n >= 0 && $n < 1000) {
            // 1 - 999
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 1000 && $n < 1000000) {
            // 1k-999k
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else if ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        } else if ($n >= 1000000000000) {
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix = 'T+';
        }

        return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }

    /**
     *  get the sub month of the given integer
     * 
     *  @param int $num
     *  @return string
     */
    private function getPrevMonth($num){
        return Carbon::now()
            ->subMonths($num)
            ->toDateTimeString();
    }

    /**
     *  get the date of previous 5 days of the given integer
     * 
     *  @param int $num
     *  @return string
     */
    private function getPrevFiveDays($num){
        return Carbon::now()
            ->subDays($num)
            ->toDateTimeString();
    }

    /**
     * get order count of given dates.
     * 
     * @param $date1
     * @param $date2
     * @return int
     */
    private function getOrderCount($date1,$date2){
        return Order::whereBetween('created_at',[$date1,$date2])
            ->count();
    }

}
