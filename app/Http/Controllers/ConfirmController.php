<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use AdsnBuzz\User;
use Auth;

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
                      ->paginate(10);
    		return view('user_confirm')->with('orders',$orders);
    	}
    }

    public function uploadView($id){
        $order = Order::find($id);
        return view('user_uploadbukti')->with('order',$order);
    }

    public function searchorder(Request $request){
        $order = Order::where("no_order",$request->search)->first();
        if (is_null($order)){
            return "not-found";
        } else {
            return $order;    
        }
    }

    public function uploadBukti(Request $request,$id){
        if($request->hasFile('buktibayar')){
            $this->validate($request, [
                'buktibayar' => 'required|file|max:2000'
            ]);

            $uploadedFile = $request->file('buktibayar');        
            $path = $uploadedFile->store('public/buktibayar');

            $order = Order::find($id);
            $order->buktibayar = $path;
            $order->save();
            return redirect() ->back() ->with('message','File berhasil diupload');
        } else {
            return redirect()->back()->with('message', 'Pilih file terlebih dahulu');
        }
    }

    public function confirmAdminView(){
    	$orders = Order::orderBy('konfirmasi', 'asc')->orderBy('id', 'desc')->paginate(10);
    	return view('admin_confirm')->with('orders',$orders);
    }

    public function confirmAdmin(Request $request){
        $orderr = Order::find($request->orderid);
    	$orderr->konfirmasi = '1';
        $orderr->save();

        $user = User::find($orderr->user_id);
        $user->deposit = $user->deposit + $orderr->jml_order;
        $user->save();
    }

    public function unconfirmAdmin(Request $request){
        $orderr = Order::find($request->orderid);
        $orderr->konfirmasi = '0';
        $orderr->save();

        $user = User::find($orderr->user_id);
        $user->deposit = $user->deposit - $orderr->jml_order;
        $user->save();
    }

    public function rejectorder(Request $request){
        $orderr = Order::find($request->orderid);
        $orderr->konfirmasi = '2';
        $orderr->save();

        /*$user = User::find($request->order['user_id']);
        $user->deposit = $user->deposit - $request->order['jml_order']; //masih bingung kalo pas udah diconfirm trus direject harus dikurangi
        $user->save();*/
    }

    public function unrejectorder(Request $request){
        $orderr = Order::find($request->orderid);
        $orderr->konfirmasi = '0';
        $orderr->save();

        /*$user = User::find($request->order['user_id']);
        $user->deposit = $user->deposit - $request->order['jml_order']; //masih bingung kalo pas udah diconfirm trus direject harus dikurangi
        $user->save();*/
    }
}
