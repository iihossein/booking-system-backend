<?php

namespace app\Classes;

use App\Traits\HttpResponses;
use Carbon\Carbon;
use App\Models\User;
use Cryptommer\Smsir\Smsir;
use Cryptommer\Smsir\Objects\Parameters;


class Otp
{
    use HttpResponses;

    public function sendOtp($phone)
    {
        $check_otp = User::where('phone', $phone)->first();
        $code = mt_rand(1000, 9999);



        // if otp already exists in database
        if ($check_otp) {

            // check last request time
            // $last_request = Carbon::parse($check_otp->updated_at);


            // check time difference
            // $diff_from_now_sec = $last_request->diffInSeconds(Carbon::now());

            // check how many times user requrested
            // 2 minutes if less than 5 times
            // 5 minutes if more than 5 times
            // if ($check_otp->try <= 5) {
            //     $wait_time = 120;
            // } else {
            //     $wait_time = 300;
            // }

            // if user waited
            // if ($diff_from_now_sec >= $wait_time) {

            // save new otp code in database
            $check_otp->code = $code;
            // $check_otp->try = $check_otp->try + 1;
            $check_otp->save();

            $name = "CODE";
            $parameter = new Parameters($name, $code);
            $parameters = array($parameter);
            $send = Smsir::Send();
            $templateId = 100000;
            $tmp = $send->Verify($phone, $templateId, $parameters);
            ddd($tmp);
            return $this->successResponse('', 'code sent', 'کد تایید ارسال شد');

            // } else {
            //     // if user did not wait and requested again
            //     return response()->json(
            //         [
            //             'status' => 'error',
            //             'description' => 'too many requests - wait',
            //             'time' => $wait_time - $diff_from_now_sec,
            //             'message' => 'لطفا ' . $wait_time - $diff_from_now_sec . ' ثانیه صبر کنید',
            //         ],
            //         400
            //     );
            // }
        } else {


            // if there is no otp saved in database for this user
            $otp = new User();
            $otp->phone = $phone;
            $otp->code = $code;
            $otp->save();

            $name = "CODE";
            $parameter = new Parameters($name, $code);
            $parameters = array($parameter);
            $send = Smsir::Send();
            $templateId = 100000;
            $send->Verify($phone, $templateId, $parameters);
            return $this->successResponse('', 'code sent', 'کد تایید ارسال شد');
        }
    }



    // check if user otp is correct and not expired
    public function checkOtp($phone, $code)
    {
        $otp = User::where([['phone', $phone], ['code', $code]])->first();

        if ($otp) {

            // if ($this->checkExpiredOtp($otp->updated_at)) {
            //     return response()->json(
            //         [
            //             'status' => 'error',
            //             'description' => 'code expired',
            //             'message' => 'کد تایید منقضی شده است',
            //             // 'code' => $code,
            //         ],
            //         400
            //     );
            // }
            return $this->successResponse('', 'correct code', 'کد تایید درست وارد شده');
        } else {
            return $this->errorResponse('', 'code not found', 'کد تایید اشتباه وارد شده است');
        }
    }



    // code is expired after 30 mins
    // public function checkExpiredOtp($updated_at)
    // {
    //     $last_request_time = Carbon::parse($updated_at);
    //     $diff_from_now_sec = $last_request_time->diffInSeconds(Carbon::now());


    //     // change here for different expiration time
    //     if ($diff_from_now_sec >= 1800) {
    //         // expired
    //         return true;
    //     } else {
    //         // not expired
    //         return false;
    //     }
    // }
}
