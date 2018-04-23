<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\User;
use DB;

class ReportController extends Controller
{
    public function index(){
    	$users = User::where('admin','=','0')->get();

    	return view('admin_report')->with('users',$users);
    }

    public function savecsv(){
    	if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = ['report_starts' => $value->Reporting Starts, 'report_ends' => $value->description, 'campaignname' => $value->description, 'delivery' => $value->description, 'results' => $value->description, 'result_ind' => $value->description, 'reach' => $value->description, 'impressions' => $value->description, 'cost' => $value->description, 'amountspent' => $value->description, 'ends' => $value->description, 'pta' => $value->description];
				}
				if(!empty($insert)){
					DB::table('reports')->insert($insert);
					dd('Insert Record successfully.');
				}
			}
		}
		return back();
    }
}
