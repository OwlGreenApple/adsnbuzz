<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\User;
use AdsnBuzz\Allocation;

use AdsnBuzz\Mail\Confirmation;
use Auth,Mail,Validator,Storage,DB;

class ConfirmController extends Controller
{ 
  //Untuk inisialisasi auth user yang sedang login
	public function __construct(){
    $this->middleware('auth');
  }

  //Menampilkan view user untuk konfirmasi pembayaran
  public function confirmUserView(){
    if(Auth::check()){
    	$orders = Order::where("user_id",Auth::user()->id)
                      ->orderBy('id', 'desc')
                      ->paginate(5);
    	return view('user_confirm')->with('orders',$orders)->with('user',Auth::user());
    }
  }

  //Menampilkan view user untuk upload bukti pembayaran
  public function uploadView($id){
    $order = Order::find($id);
    return view('user_uploadbukti')->with('order',$order)->with('user',Auth::user());
  }

  //Mencari order berdasarkan no order di menu konfirmasi pembayaran (admin+user)
  public function searchorder(Request $request){
    $order = Order::where("no_order",'like','%'.$request->search.'%')->get();
    if (is_null($order)){
      $arr['status'] = "not-found";
      $arr['isi'] = "";
      $arr['url'] = "";
    } else {
      $arr['status'] = "found";
      $arr['isi'] = $order;
      if($order->buktibayar==null){
        $arr['url'] = null;
      } else {
        //$arr['url'] = url(Storage::url($order->buktibayar));
        $arr['url'] = url($order->buktibayar);
      }
    }
    return $arr;
  }

  //Method post untuk menyimpan path file bukti yang diupload ke database
  public function uploadBukti(Request $request,$id){
    $validator = Validator::make($request->all(), [
      'buktibayar'=>'mimes:jpg,jpeg,png,bmp|file|max:2000',
    ]);

    $order = Order::find($id);

    if($order->konfirmasi==1){
      $arr['status'] = 'error';
      $arr['message'] = 'Pesanan Anda telah dikonfirmasi oleh admin.';
      //return redirect()->back()->with('message', 'Pesanan Anda telah dikonfirmasi oleh admin');    
    } else if(!$request->hasFile('buktibayar')){
      $arr['status'] = 'error';
      $arr['message'] = 'Pilih file terlebih dahulu.';
    } else if($validator->fails()){
      $arr['status'] = 'error';
      $arr['message'] = 'File yang Anda masukkan salah.';
    } else {
      $uploadedFile = $request->file('buktibayar');        
      //$path = $uploadedFile->store('public/buktibayar');
      $path = $uploadedFile->store('buktibayar');
                  
      $order->buktibayar = '/storage/app/'.$path;
      $order->save();

      $arr['status'] = 'success';
      $arr['message'] = 'File bukti bayar berhasil diupload.';  
    }
    return $arr;
  } 

  //Method untuk view menu konfirmasi pembayaran untuk admin 
  public function confirmAdminView(){
    //Select tabel order dan user(email) urut berdasarkan order terbaru dan status konfirmasinya 
    $orders = DB::table('orders')
              ->join('users','orders.user_id','=','users.id')
              ->select('orders.*','users.email')
              ->orderBy('konfirmasi', 'asc')
              ->orderBy('id', 'desc')
              ->paginate(5);
    return view('admin_confirm')->with('orders',$orders);
  }

  //Method post untuk admin melakukan konfirmasi terhadap order 
  public function confirmAdmin(Request $request){
    $orderr = Order::find($request->orderid);
    $orderr->konfirmasi = '1';
    $orderr->save();

    $user = User::find($orderr->user_id);
    $user->deposit = $user->deposit + $orderr->jml_order;
    $user->save();

    $allocation = new Allocation;
    $allocation->user_id = $orderr->user_id;
    $allocation->order_id = $orderr->id;
    $allocation->kredit = $orderr->jml_order;
    $allocation->description = 'Deposit';
    $allocation->save();

    //Mengirim email ke user untuk pemberitahuan order sudah dikonfirmasi
    Mail::to($user->email)->queue(new Confirmation($user->email));    
  }

  //Method post untuk admin melakukan unkonfirmasi terhadap order 
  public function unconfirmAdmin(Request $request){
    $orderr = Order::find($request->orderid);
    $orderr->konfirmasi = '0';
    $orderr->save();

    $user = User::find($orderr->user_id);
    $user->deposit = $user->deposit - $orderr->jml_order;
    $user->save();

    $allocation = Allocation::where('order_id',$orderr->id)->first();
    $allocation->delete();
  }

  //Method post untuk admin melakukan reject terhadap order 
  public function rejectorder(Request $request){
    $orderr = Order::find($request->orderid);

    if($orderr->konfirmasi=='1'){
      $user = User::find($orderr->user_id);
      $user->deposit = $user->deposit - $orderr->jml_order;
      $user->save(); 
            
      $allocation = Allocation::where('order_id',$orderr->id)->first();
      $allocation->delete();          
    }

    $orderr->konfirmasi = '2';
    $orderr->save();
  }

  //Method post untuk admin melakukan unreject terhadap order 
  public function unrejectorder(Request $request){
    $orderr = Order::find($request->orderid);
    $orderr->konfirmasi = '0';
    $orderr->save();
  }
}