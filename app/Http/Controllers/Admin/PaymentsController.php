<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;

class PaymentsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OrdersController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for displaying a list of payments that have
    | been processed with braintree or failed payments and also responsible for
    | deleting those payments.
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
     * Display a listing of the Payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::orderBy('created_at')->paginate(10);
        return view('admin.payments.index',[
            'payments' => $payments
        ]);
    }

    /**
     * Remove the specified payment from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::findOrfail($id);
        $payment->delete();
        return redirect()
            ->back()
            ->with('status','Selected payment has been deleted!');
    }
}
