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
    	$order = new Order;
    	$order->user_id = $id;
    	$order->tgl_order = date('Y-m-d H:i:s');
    	$order->kodekupon = $request->coupon_code;
    	$order->jml_order = $request->jml_order;
    	$order->opsibayar = $request->opsibayar;
    	$order->save();

    	/*$user = User::find($id);
    	$user->deposit = $user->deposit + $request->jml_order;
    	$user->save();*/
    }
		
	public function calc_coupon(Request $request){
		$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();
		if (is_null($coupon)){
			$arr["value"] = "";
			$arr['status'] = 'not-found';
			$arr['tipe'] = "";
			return $arr;    
		}
		else {
			$arr["value"] = $coupon->diskon;
			$arr['status'] = 'found';
			$arr['tipe'] = $coupon->tipekupon;
			return $arr;    
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
