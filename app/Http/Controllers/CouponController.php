<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Coupon;

class CouponController extends Controller
{ 
  //Memanggil view untuk menu kupon pada halaman admin
  public function index(){
    $coupons = Coupon::orderBy('id', 'desc')->paginate(5);
    return view('admin_coupon')->with('coupons',$coupons);
  }

  //Memanggil view insert kupon ketika meng-klik button tambah
  public function create(){
    return view('insertcoupon');
  }

  //Method post untuk menyimpan data kupon ke database (menu tambah)
  public function store(Request $request){
    if($request->diskon=='' || $request->kodekupon==''){
      $arr['status'] = 'error';
      $arr['message'] = 'Isi form terlebih dahulu.';
      $arr['isi'] = '';
    }
    else if(preg_match('/^[1-9][0-9]*$/',$request->diskon)!=1){
      $arr['status'] = 'error';
      $arr['message'] = 'Masukkan input hanya angka pada form diskon.';
      $arr['isi'] = ''; 
    } else if($request->tipekupon=='Persen' && $request->diskon>100){
    	$arr['status'] = 'error';
      $arr['message'] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
      $arr['isi'] = '';  
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

  //Method post untuk cari data kupon
  public function show($id){
    $coupon = Coupon::where('kodekupon','like','%'.$id.'%')->get();
    if(is_null($coupon)){
      $arr['status'] = "not-found";
      $arr['isi']= "";
    } else {
      $arr['status'] = "found";
      $arr['isi']= $coupon;
    }
    return $arr;
  }

  //Memanggil view edit kupon ketika meng-klik button update berdasarkan id
  public function edit($id){
  	$coupon = Coupon::find($id);
  	return view('editcoupon') -> with('coupon',$coupon);
  }

  //Method post untuk update data kupon
  public function update(Request $request, $id){
    if($request->diskon=='' || $request->kodekupon==''){
      $arr['status'] = 'error';
      $arr['message'] = 'Isi form terlebih dahulu.';
      $arr['isi'] = '';
    }
    else if(preg_match('/^[1-9][0-9]*$/',$request->diskon)!=1){
      $arr['status'] = 'error';
      $arr['message'] = 'Masukkan input hanya angka pada form diskon.';
      $arr['isi'] = '';
    } else if($request->tipekupon=='Persen' && $request->diskon>100){
      $arr['status'] = 'error';
      $arr['message'] = 'Masukkan diskon antara 0 - 100 untuk tipe persen.';
      $arr['isi'] = '';
    } else {
    	$coupon = Coupon::find($id);
	    $coupon->kodekupon 	= $request->kodekupon;
	    $coupon->tipekupon 	= $request->tipekupon;
	    $coupon->diskon		= $request->diskon;
	    $coupon->save();

      $arr['status'] = 'success';
      $arr['message'] = '';
      $arr['isi'] = $coupon;
    }
    return $arr;
  }

  //Method post untuk delete data kupon
  public function destroy($id){
    $coupon = Coupon::find($id);
    $coupon->delete();
  }
}
