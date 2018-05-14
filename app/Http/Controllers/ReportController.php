<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\User;
use AdsnBuzz\Report;
use AdsnBuzz\Allocation;

use AdsnBuzz\Mail\Deposit;
use DB,Excel,Mail,Auth, Validator;

class ReportController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
    	/*$users = User::where('admin','=','0')->get();
    	return view('admin_report')->with('users',$users);*/
      $user = User::find($id);
      return view('admin_report')->with('user',$user);
    }

    public function user_index(){
    	return view('user_report')->with('user',Auth::user());
    }

    public function savecsv(Request $request){
    	$validator = Validator::make($request->all(), [
    		'filecsv' => 'mimes:csv,txt',
    	]);

    	if($request->agencyfee>100){
	    	echo "<script> alert('Masukkan agency fee antara 0 - 100%'); 
	    	window.location.href='adsnbuzz/public/report'; </script>";	
    	} else if($request->hasFile('filecsv')){
    		if($validator->fails()){
    			return redirect()->back()->with('message', 'File yang Anda masukkan salah');
    		} else {
    			//dd($request->file('filecsv'));
				$path = $request->file('filecsv')->getRealPath();
				$data = Excel::load($path)->get();
				$jmlads = 0;
				if(!empty($data) && $data->count()){
					foreach ($data as $key => $value) {
						$report = new Report;
						$report->user_id		= $request->userid;
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
						$jmlads 				= $jmlads+$value->amount_spent_idr;
						$report->ends 			= $value->ends;
						$report->pta 			= $value->people_taking_action;
						$report->agencyfee		= $request->agencyfee;
						$report->created_at 	= date('Y-m-d H:i:s', time());
						$report->save();
					}

					$user = User::find($report->user_id);
					
					$allocation = new Allocation;
					$allocation->user_id 		= $report->user_id;
					$allocation->debit 			= $jmlads;
					$allocation->description 	= 'Ads '.date('M').date('Y');
					$allocation->totaldebit 	= $jmlads + ($user->spend_month*($request->agencyfee/100));
					$allocation->save();

					//mengurangi deposit user 
					$user->deposit = $user->deposit - $allocation->totaldebit;
					$user->save();

					if($user->deposit<=$user->spend_month){
						Mail::to($user->email)->queue(new Deposit($user->email,$user->deposit));	
					}
					return redirect()->back()->with('message', 'File report berhasil diupload');
				}
    		}
		}
    }

    public function showData(Request $request, $id){
    	//dd($request->tglmulai);
    	$data = Report::where("user_id",$id)
    					->where("report_starts",'>=',$request->tglmulai)
              ->where("report_starts",'<=',$request->tglakhir)
              ->where("report_ends",'>=',$request->tglmulai)
    				    ->where("report_ends",'<=',$request->tglakhir)->get();
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
