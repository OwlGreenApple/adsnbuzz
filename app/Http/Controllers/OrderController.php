<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\Coupon;
use AdsnBuzz\User;
use DB;

class OrderController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('user_order');
    }

    public function store(Request $request, $id){
    	$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();

    	if (is_null($coupon)){
			return "failed";
		}
		else {
			if($coupon->tipekupon == 'Nominal'){
				$totalharga = $request->jml_order - $coupon->diskon;
			} else {
				$totalharga = $request->jml_order - ($request->jml_order * ($coupon->diskon/100));
			}

			$noorder = date("Y").date("m").date("d");

	    	$orderall = Order::All();
	    	$lastorder = collect($orderall)->last();
	    	$tgllast = substr($lastorder->no_order, 0,8);

	    	if($noorder==$tgllast){
	    		$number = (int)substr($lastorder->no_order,8,3);
	    		$noorder = $noorder.sprintf('%03d',$number+1);
	    	} else {
	    		$noorder = $noorder.sprintf('%03d',1);
	    	}

	    	$order = new Order;
	    	$order->user_id 	= $id;
	    	$order->tgl_order 	= date('Y-m-d H:i:s');
	    	$order->kodekupon 	= $request->coupon_code;
	    	$order->jml_order 	= $request->jml_order;
	    	$order->opsibayar 	= $request->opsibayar;
	    	$order->no_order	= $noorder;
	    	$order->totalharga 	= $totalharga;
	    	$order->save();
		}
    
    	/*$user = User::find($id);
    	$user->deposit = $user->deposit + $request->jml_order;
    	$user->save();*/
    }
		
	public function calc_coupon(Request $request){
		$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();

		if (is_null($coupon)){
			return 'not-found';
		}
		else {
			if($coupon->tipekupon == 'Nominal'){
				return $request->jmlorder - $coupon->diskon;
			} else {
				return $request->jmlorder - ($request->jmlorder * ($coupon->diskon/100));
			}	  
		}
	}

	public function pesan(Request $request,$id){
		$user = User::find($id);

		if($request->spend > $user->deposit){
			return "invalid";
		} else {
			//$user->deposit = $user->deposit - $request->spend;
			$user->spend_month = $request->spend;
			$user->companycategory = $request->companycategory;
			$user->save();
			return "valid";
		}

	}
}
