<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Coupon;

class CouponController extends Controller
{
    public function index(){
    	return view('admin_coupon');
    }

    public function store(Request $request){
    	if($request->tipekupon=='Persen' && $request->diskon>100){
    		dd('Input diskon terlalu besar. Masukkan angka antara 0 sampai 100.');
    	} else {
    		$kupon 				= new Coupon;
	    	$kupon->kodekupon 	= $request->kodekupon;
	    	$kupon->tipekupon	= $request->tipekupon;
	    	$kupon->diskon		= $request->diskon;
	    	$kupon->save();
	    	dd('Insert kupon berhasil');
    	}
    }

    public function create(){

    }

    public function show(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
