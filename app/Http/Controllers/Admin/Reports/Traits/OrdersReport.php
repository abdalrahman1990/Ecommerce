<?php

namespace App\Http\Controllers\Admin\Reports\Traits;

trait OrdersReport{
    
    /*
    |--------------------------------------------------------------------------
    | OrdersReport Trait
    |--------------------------------------------------------------------------
    |
    | This trait provides reusable methods like order columns that are 
    | displayed on reports and report title, so we can just reuse these methods
    | in all three reports controller.
    |
    */

    /**
     * Columns name to display on the report.
     * 
     * @return array
     */
    private function orderColumns(){
        return 
        [
            'ID'             => 'id',
            'Total'          => function($result) {
                return number_format($result->total,2);
            },
            'Products'   => function($result){
                $products = [];
                foreach($result->products as $product){
                    //get all the product ids related
                    //to the order.
                    $products[] = "ID: {$product->id} | Qty: {$product->pivot->qty}";
                }
                //put all the array items together and
                //make it a string.
                return implode($products,', ');
            },
            'Address ID'     => 'address_id',
            'City'           => function($result){
                return $result->address->city->name;
            },
            'Transaction ID' => function($result){
                return $result->payment->transaction_id;
            },
            'Customer ID'    => 'user_id',
            'Customer Email' => function($result){
                return $result->user->email;
            },
            'Order Status'         => function($result){
                return $result->paid ? 'Paid' : 'Failed';
            },
            'Created at'     => function($result) {
                return $result->created_at->format('d M Y');
            }

        ];
    }

    /**
     * Report Title
     * 
     * @return string
     */
    private function reportTitle(){
        return "Customer Orders Report";
    }

}