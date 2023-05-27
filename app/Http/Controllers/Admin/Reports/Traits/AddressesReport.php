<?php

namespace App\Http\Controllers\Admin\Reports\Traits;

trait AddressesReport{
    
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
    private function addressColumns(){
        return 
        [
            'ID'             => 'id',
            'Address Line 1'   => function($result){
                return $result->address_1;
            },
            'Address Line 2'   => function($result){
                return $result->address_2;
            },
            'City'           => function($result){
                return $result->city->name;
            },
            'Postal Code'           => function($result){
                return $result->postal_code;
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
    private function AddressReportTitle(){
        return "Customer Addresses Report";
    }

}