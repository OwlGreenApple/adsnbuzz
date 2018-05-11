<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Coupon;

class CouponController extends Controller
{
    public function index(){
    	$coupons = Coupon::paginate(5);
       	return view('admin_coupon')
       	       ->with('coupons',$coupons);
    }

    public function create(){
    	return view('insertcoupon');
    }

    public function store(Request $request){
    	if($request->tipekupon=='Persen' && $request->diskon>100){
    		return 'not-valid';
    	} else {
    		$kupon 				= new Coupon;
	    	$kupon->kodekupon 	= $request->kodekupon;
	    	$kupon->tipekupon	= $request->tipekupon;
	    	$kupon->diskon		= $request->diskon;
	    	$kupon->save();
    	}
    }

    public function show($id){
        $coupon = Coupon::where('kodekupon',$id)->first();
        if(is_null($coupon)){
            $arr['status'] = "not-found";
            $arr['isi']= "";
        } else {
            $arr['status'] = "found";
            $arr['isi']= $coupon;
        }
        return $arr;
    }

    public function edit($id){
		$coupon = Coupon::find($id);
		return view('editcoupon') -> with('coupon',$coupon);
    }

    public function update(Request $request, $id){
    	if($request->tipekupon=='Persen' && $request->diskon>100) {
    		return 'not-valid';
    	} else {
    		$coupon = Coupon::find($id);
	    	$coupon->kodekupon 	= $request->kodekupon;
	    	$coupon->tipekupon 	= $request->tipekupon;
	    	$coupon->diskon		= $request->diskon;
	    	$coupon->save();
    	}
    }

    public function destroy($id){
    	$coupon = Coupon::find($id);
        $coupon->delete();
    }
}
