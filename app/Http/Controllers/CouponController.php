<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Coupon;

class CouponController extends Controller
{
    public function index(){
    	$coupons = Coupon::orderBy('id', 'desc')->paginate(5);
      return view('admin_coupon')->with('coupons',$coupons);
    }

    public function create(){
    	return view('insertcoupon');
    }

    public function store(Request $request){
      //dd(preg_match('/^[1-9][0-9]*$/',$request->diskon));
      if($request->diskon=='' || $request->kodekupon==''){
        $arr['status'] = 'error';
        $arr['message'] = 'Isi form terlebih dahulu.';
        $arr['isi'] = '';
      }
      else if(preg_match('/^[1-9][0-9]*$/',$request->diskon)!=1){
        $arr['status'] = 'error';
        $arr['message'] = 'Masukkan input hanya angka pada form diskon.';
        $arr['isi'] = '';
        //return 'not-valid';
      } else if($request->tipekupon=='Persen' && $request->diskon>100){
    		$arr['status'] = 'error';
        $arr['message'] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
        $arr['isi'] = '';
        //return 'not-valid';
    	} else {
    		$kupon 				= new Coupon;
	    	$kupon->kodekupon 	= $request->kodekupon;
	    	$kupon->tipekupon	= $request->tipekupon;
	    	$kupon->diskon		= $request->diskon;
	    	$kupon->save();

        $arr['status'] = 'success';
        $arr['message'] = '';
        $arr['isi'] = $kupon;
    	}

      return $arr;
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
    	if($request->diskon=='' || $request->kodekupon==''){
        $arr['status'] = 'error';
        $arr['message'] = 'Isi form terlebih dahulu.';
      }
      else if(preg_match('/^[1-9][0-9]*$/',$request->diskon)!=1){
        $arr['status'] = 'error';
        $arr['message'] = 'Masukkan input hanya angka pada form diskon.';
        //return 'not-valid';
      } else if($request->tipekupon=='Persen' && $request->diskon>100){
        $arr['status'] = 'error';
        $arr['message'] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
        //return 'not-valid';
      } else {
    		$coupon = Coupon::find($id);
	    	$coupon->kodekupon 	= $request->kodekupon;
	    	$coupon->tipekupon 	= $request->tipekupon;
	    	$coupon->diskon		= $request->diskon;
	    	$coupon->save();

        $arr['status'] = 'success';
        $arr['message'] = '';
    	}
      return $arr;
    }

    public function destroy($id){
    	$coupon = Coupon::find($id);
      $coupon->delete();
    }
}
