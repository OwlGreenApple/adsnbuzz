<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Order;
use Auth;

class ConfirmController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmUser(){
    	if(Auth::check()){
    		$orders = Order::where("user_id",Auth::user()->id)->get();
    		return view('user_confirm')->with('orders',$orders);
    	}
    }

    public function confirmAdminView(){
    	$orders = Order::paginate(10);
    	return view('admin_confirm')->with('orders',$orders);
    }

    public function confirmAdmin(){
    	$id = $_POST["id"];
        return $id;
    }
}
