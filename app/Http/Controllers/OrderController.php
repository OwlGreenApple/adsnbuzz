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
  //Untuk inisialiasi auth user yang sedang login
	public function __construct() {
    $this->middleware('auth');
  }

  //Memanggil view user_order pada menu deposit halaman user
  public function index() {
    return view('user_order')->with('user',Auth::user());
  }

  //Method post untuk menyimpan order deposit user 
  public function store(Request $request, $id){
    if($request->coupon_code==""){
    	$kodekupon = "-";
    } else {
    	$coupon = Coupon::where("kodekupon",$request->coupon_code)->first();
    	$kodekupon = $request->coupon_code;
    }

    if ($kodekupon!="-" && is_null($coupon)){
			$arr['status'] = "failed";
      return $arr;
		} else {
			if($kodekupon=="-"){
				$totalharga = $request->jml_order;
			} else if ($coupon->tipekupon == 'Nominal') {
				$totalharga = $request->jml_order - $coupon->diskon;
			} else {
				$totalharga = $request->jml_order - ($request->jml_order * ($coupon->diskon/100));
			}

      //Untuk meng-set no order dengan format yyyy-mm-dd-noorder
			$noorder = date("Y").date("m").date("d");

	    $orderall = Order::All();
	    $lastorder = collect($orderall)->last();

	    $tgllast = null;
      
	    if($lastorder!=null){
        //Memotong no order database terakhir untuk mendapatkan tanggal order terakhir
	    	$tgllast = substr($lastorder->no_order, 0,8);
	    }

      //Men-check jika tanggal order terakhir sama dengan tanggal order yg akan disimpan, maka melanjutkan no order brdasarkan no order terakhir 
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

  //Method post untuk menyimpan perubahan max spend
	public function pesan(Request $request,$id){
		$user = User::find($id);

		if($request->spend==''){
      $arr['status'] = 'error';
      $arr['message'] = 'Isi form terlebih dahulu.';
    } else if($request->spend > $user->deposit){
      $arr['status'] = 'error';
      $arr['message'] = 'Jumlah spend terlalu besar. Silahkan lakukan deposit terlebih dahulu.';
		} else if(preg_match('/^[1-9][0-9]*$/',$request->spend)!=1){
      $arr['status'] = 'error';
      $arr['message'] = 'Masukkan input hanya angka pada form max spend.';
    }else {
			//$user->deposit = $user->deposit - $request->spend;
			if($request->spend!=$user->spend_month){
        //Mengirim email warning max spend ke admin
				Mail::to('puspitanurhidayati@gmail.com')->queue(new MaxSpend($user->email,$user,$request->spend));
				$user->spend_month = $request->spend;
			}
			$user->companycategory = $request->companycategory;
			$user->save();

      $arr['status']='success';
      $arr['message']='Max spend berhasil dirubah.';
		}

    return $arr;

	}

  //Memanggil view user_maxspend untuk menu max spend halaman user 
	public function maxspendview(){
		if(Auth::check()){
			$user = User::find(Auth::user()->id);
			return view('user_maxspend')->with('user',$user);
		}
	}
}
