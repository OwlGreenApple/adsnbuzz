<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\User;
use AdsnBuzz\Allocation;

use AdsnBuzz\Mail\Confirmation;
use Auth,Mail,Validator,Storage;

class ConfirmController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmUserView(){
    	if(Auth::check()){
    		$orders = Order::where("user_id",Auth::user()->id)
                      ->orderBy('id', 'desc')
                      ->paginate(5);
    		return view('user_confirm')->with('orders',$orders)->with('user',Auth::user());
    	}
    }

    public function uploadView($id){
        $order = Order::find($id);
        return view('user_uploadbukti')->with('order',$order)->with('user',Auth::user());
    }

    public function searchorder(Request $request){
        $order = Order::where("no_order",$request->search)->first();
        if (is_null($order)){
            return "not-found";
        } else {
            $arr['isi'] = $order;
            if($order->buktibayar==null){
                $arr['url'] = null;
            } else {
                $arr['url'] = url(Storage::url($order->buktibayar));
            }
            return $arr;    
        }
    }

    public function uploadBukti(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'buktibayar' => 'mimes:jpg,jpeg,png,bmp|required|file|max:2000',
        ]);

        if($request->hasFile('buktibayar')){
            if($validator->fails()){
                return redirect()->back()->with('message', 'File yang Anda masukkan salah');
            } else {
                $uploadedFile = $request->file('buktibayar');        
                $path = $uploadedFile->store('public/buktibayar');

                $order = Order::find($id);
                $order->buktibayar = $path;
                $order->save();
                return redirect() ->back() ->with('message','File berhasil diupload');
            }
        } else {
            return redirect()->back()->with('message', 'Pilih file terlebih dahulu');
        }
    }

    public function confirmAdminView(){
    	$orders = Order::orderBy('konfirmasi', 'asc')->orderBy('id', 'desc')->paginate(5);
    	return view('admin_confirm')->with('orders',$orders);
    }

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

        Mail::to($user->email)->queue(new Confirmation($user->email));    
    }

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

    public function unrejectorder(Request $request){
        $orderr = Order::find($request->orderid);
        $orderr->konfirmasi = '0';
        $orderr->save();
    }
}
