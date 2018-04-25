<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\User;
use AdsnBuzz\Report;
use DB;
use Excel;

class ReportController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$users = User::where('admin','=','0')->get();

    	return view('admin_report')->with('users',$users);
    }

    public function user_index(){
    	return view('user_report');
    }

    public function savecsv(Request $request){
    	if($request->hasFile('filecsv')){
    		echo "dataaa1";
    		//dd($request->file('filecsv'));
			$path = $request->file('filecsv')->getRealPath();
			$data = Excel::load($path)->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$report = new Report;
					$report->user_id		= $request->listuser;
					$report->report_starts	= $value->reporting_starts;
					$report->report_ends 	= $value->reporting_ends;
					$report->campaignname 	= $value->campaign_name;
					$report->delivery 		= $value->delivery;
					$report->results 		= $value->results;
					$report->result_ind 	= $value->result_indicator;
					$report->reach 			= $value->reach;
					$report->impressions 	= $value->impressions;
					$report->cost 			= $value->cost_per_results;
					$report->amountspent 	= $value->amount_spent_idr;
					$report->ends 			= $value->ends;
					$report->pta 			= $value->people_taking_action;
					$report->created_at 	= date('Y-m-d H:i:s', time());
					$report->save();
				}
				dd('Insert Record successfully.');
			}
		}
    }

    public function showData(Request $request, $id){
    	//dd($request->tglmulai);
    	$data = Report::where("user_id",$id)
    					->where("report_starts",$request->tglmulai)
    				    ->where("report_ends",$request->tglakhir)->get();
    	//dd($data);
    	if ($data->isEmpty()){
			$arr["status"] = 'not-found';
			$arr['isi'] = "";
			return $arr;    
		}
		else {
			$arr["status"] = 'found';
			$arr['isi'] = $data;
			return $arr;    
		}
    }
}
