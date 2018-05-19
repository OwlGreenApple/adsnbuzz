<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\User;
use DB, Auth;

class UserController extends Controller
{
	public function manageuserview () {
		$users = User::where('admin','0')->paginate(5);
		return view('admin_manageuser')->with('users',$users);
	}

	public function manageuserlogin(Request $request, $id) {
		if (session()->has('hasClonedUser')) {
	        auth()->loginUsingId(session()->remove('hasClonedUser'));
	        session()->remove('hasClonedUser');
	        return redirect('/manage-user');
	    }

	    //only run for developer, clone selected user and create a cloned session
	    if (Auth::user()->admin == 1) {
	        session()->put('hasClonedUser', auth()->user()->id);
	        auth()->loginUsingId($id);
	        return redirect()->back();
	    }
	}

	public function search(Request $request){
		$user = User::where('email','like','%'.$request->search.'%')
            ->orWhere('name','like','%'.$request->search.'%')
            ->get();

		if(is_null($user)){
			$arr['status'] = "not-found";
			$arr['isi'] = "";
		} else {
			$arr['status'] = "found";
			$arr['isi'] = $user;
		}
		return $arr;
	}
}
