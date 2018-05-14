<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\Coupon;
use AdsnBuzz\User;

use AdsnBuzz\Mail\MaxSpend;
use DB,Mail,Auth;

class OrderController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('user_order')->with('user',Auth::user());
    }

    public function store(Request $request, $id){
    	if($request->coupon_code==""){
    		$kodekupon = "-";
    	} else {
    		$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();
    		$kodekupon = $request->coupon_code;
    	}

    	if ($kodekupon!="-" && is_null($coupon)){
			return "failed";
		}
		else {
			if($kodekupon=="-"){
				$totalharga = $request->jml_order;
			} else if ($coupon->tipekupon == 'Nominal') {
				$totalharga = $request->jml_order - $coupon->diskon;
			} else {
				$totalharga = $request->jml_order - ($request->jml_order * ($coupon->diskon/100));
			}

			$noorder = date("Y").date("m").date("d");

	    	$orderall = Order::All();
	    	$lastorder = collect($orderall)->last();

	    	$tgllast = null;
	    	if($lastorder!=null){
	    		$tgllast = substr($lastorder->no_order, 0,8);
	    	}

	    	if($noorder==$tgllast){
	    		$number = (int)substr($lastorder->no_order,8,3);
	    		$noorder = $noorder.sprintf('%03d',$number+1);
	    	} else {
	    		$noorder = $noorder.sprintf('%03d',1);
	    	}

	    	$order = new Order;
	    	$order->user_id 	= $id;
	    	$order->tgl_order 	= date('Y-m-d H:i:s');
	    	$order->kodekupon 	= $kodekupon;
	    	$order->jml_order 	= $request->jml_order;
	    	$order->opsibayar 	= $request->opsibayar;
	    	$order->no_order	= $noorder;
	    	$order->totalharga 	= $totalharga;
	    	$order->save();

	    	return $order;
		}
    }

	public function pesan(Request $request,$id){
		$user = User::find($id);

		if($request->spend > $user->deposit){
			return "invalid";
		} else {
			//$user->deposit = $user->deposit - $request->spend;
			if($request->spend!=$user->spend_month){
				Mail::to('puspitanurhidayati@gmail.com')->queue(new MaxSpend($user->email,$user,$request->spend));
				$user->spend_month = $request->spend;
			}
			$user->companycategory = $request->companycategory;
			$user->save();

			return "valid";
		}

	}

	public function maxspendview(){
		if(Auth::check()){
			$user = User::find(Auth::user()->id);
			return view('user_maxspend')->with('user',$user);
		}
	}
}
