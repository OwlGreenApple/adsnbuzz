<?php

namespace AdsnBuzz\Http\Controllers;

use Illuminate\Http\Request;
use AdsnBuzz\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
	public function send()
    {
        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'SenderUserName';
        $objDemo->receiver = 'ReceiverUserName';
 
        Mail::to("puspitanurhidayati@gmail.com")->send(new DemoEmail($objDemo));
    }
}
