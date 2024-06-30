<?php

namespace App\Http\Controllers;


use Cryptommer\Smsir\Smsir;
use Illuminate\Http\Request;
use Cryptommer\Smsir\Objects\Parameters;

class SmsVerificationController extends Controller
{
    public function sendsms(Request $request)
    {
        $mobile = $request->phone;
        $name = "CODE";
        $value = rand(1000, 9999);
        $parameter = new Parameters($name, $value);
        $parameters = array($parameter);
        $send = Smsir::Send();
        $templateId = 100000;
        $send->Verify($mobile, $templateId, $parameters);
    }
}
