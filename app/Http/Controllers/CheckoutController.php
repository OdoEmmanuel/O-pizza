<?php

namespace App\Http\Controllers;

use App\Checkout;
use Mail;
use Cart;
use Session;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {   
 
        return view('/home', ['checkouts' => Checkout::all(),]);
    }

    public function create(){
     if(Cart::content()->count() == 0)
     {
         Session::flash('info', 'Your cart is empty. cart some Items');
             return redirect()->back();
         }
             return view('checkout');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'mphone' => 'required',
            'item' => 'required',
            'quantity' => 'required',
            'amount' => 'required'
        ]);
        $chekout = new Checkout;
        $chekout->first_name = $request->fname;
        $chekout->last_name = $request->lname;
        $chekout->email = $request->email;

        $chekout->state = $request->state;
        $chekout->city = $request->city;
        $chekout->address = $request->address;
        $chekout->mobile_phone = $request->mphone;
        $chekout->item = $request->item;
        $chekout->quantity = $request->quantity;
        $chekout->amount = $request->amount;

        // dd($chekout);
         $chekout->save();

        Session::flash('success', 'Order Placed successfully.');

        Cart::destroy();

        return redirect('/');
    }
}
