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
    	$jml_order = $request->input('jml_order');
    	$opsibayar = $request->input('opsibayar');
		// DB::insert('insert into orders (id,tgl_order,jml_order,opsibayar,konfirmasi) values(?,NOW(),?,?,0)',[$id,$jml_order,$opsibayar]);
		return "Order berhasil disimpan.<br> Silahkan melakukan pembayaran terlebih dahulu.";
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
