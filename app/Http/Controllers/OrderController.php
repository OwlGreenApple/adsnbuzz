<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\Coupon;
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
    	$order = new Order;
    	$order->id = $id;
    	$order->tgl_order = date('Y-m-d H:i:s');
    	$order->kodekupon = $request->coupon_code;
    	$order->jml_order = $request->jml_order;
    	$order->opsibayar = $request->opsibayar;
    	$order->save();
    }
		
	public function calc_coupon(Request $request){
		$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();
		if (is_null($coupon)){
			$arr["value"] = "";
			$arr['type'] = 'not-found';
			return $arr;    
		}
		else {
			$arr["value"] = $coupon->diskon;
			$arr['type'] = 'found';
			return $arr;    
		}
	}
}
