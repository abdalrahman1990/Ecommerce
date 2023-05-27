<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree_ClientToken;

class BraintreeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BraintreeController
    |--------------------------------------------------------------------------
    | 
    | This controller will get the braintree client token that's essential
    | for processing payment.
    |
    |
    */

    /**
     *  get the braintree client token.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function token(){
        return response()->json([
            'token' => Braintree_ClientToken::generate()
        ]);
    }
}
