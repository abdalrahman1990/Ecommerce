<?php

namespace App\Http\Controllers\Admin\Reports\Traits;

trait CustomersReport
{
    /*
    |--------------------------------------------------------------------------
    | CustomersReport Trait
    |--------------------------------------------------------------------------
    |
    | This trait provides reusable methods like customer columns that are 
    | displayed on reports and report title, so we can just reuse these methods
    | in all three reports controller.
    |
    */

    /**
     * Columns name to display on the report.
     * 
     * @return array
     */
    private function customerColumns(){
        return 
        [
            'ID' => 'id',
            'Name' => 'name',
            'Email' => 'email',
            'Created at' => function($result) {
                return $result->created_at->format('d M Y');
            },
            'Updated at' => function($result) {
                return $result->updated_at->format('d M Y');
            },
        ];
    }

    /**
     * Report Title
     * 
     * @return string
     */
    private function customerReportTitle(){
        return "Customers Report";
    }
}
