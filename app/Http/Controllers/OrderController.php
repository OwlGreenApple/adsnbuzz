<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
    	return view('user_order');
    }
}
