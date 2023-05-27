<?php

namespace App\Http\Controllers\Admin\Reports\Traits;

use Illuminate\Http\Request;

trait Report{

    /*
    |--------------------------------------------------------------------------
    | Report Trait
    |--------------------------------------------------------------------------
    |
    | This trait provides reusable methods like validation, report file name 
    | to be dowloaded, and report metadata.
    |
    */

    /**
     * Validate the Request.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    private function validateDates(Request $request){
        $this->validate($request,[
                'date_to' => 'required',
                'date_from' => 'required'
            ],[
                'required' => ':attribute is required'
            ]
        );
    }

    /**
     * Name of the Downloadable Report File.
     * @param string $dateFrom
     * @param string $dateTo
     * @return string
     */
    private function fileName($dateFrom,$dateTo){
        return 'From'.$dateFrom.' To '.$dateTo;
    }

    /**
     * Report Meta data.
     * 
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    private function reportMeta($dateFrom,$dateTo){
        return [
            'Generated On' => $dateFrom.' To '.$dateTo,
        ];
    }
}