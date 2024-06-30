<?php

namespace App\Http\Controllers;

use app\Classes\Otp;
use App\Models\User;
use app\Classes\Login;
use app\Classes\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('phone', $request->phone)->first();


        if ($user) {
            if ($user->status == 0) {
                return response()->json(['status' => 'error', 'description' => 'user status'], 400);
            } else {
                return response()->json(['status' => 'success', 'description' => 'password'], 200);
            }
        } else {
            $otp_class = new Otp();
            $send_otp = $otp_class->sendOtp($request->phone);
            return $send_otp;
        }
    }

    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'min:5', 'integer'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $otp_class = new Otp();
        $check_otp = $otp_class->checkOtp($request->phone, $request->code);


        if ($check_otp) {
            return response()->json(
                [
                    'status' => 'success',
                    'step' => 'check code',
                    'description' => 'good code',
                    'message' => 'کد تایید وارد شده صحیح است.',
                ],
                200
            );
        } else {


            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'check code',
                    'description' => 'wrong code',
                    'message' => 'کد تایید وارد شده اشتباه است.',
                ],
                400
            );
        }
    }

    public function checkPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('phone', $request->phone)->first();


        if (Hash::check($request->password, $user->password)) {
            $login_class = new Login;
            $token = $login_class->makeToken($user->phone);


            return response()->json(
                [
                    'status' => 'success',
                    'step' => 'check password',
                    'description' => 'good password',
                    'message' => '',
                    'token' => $token,
                ],
                200
            );
        } else {

            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'check password',
                    'description' => 'wrong password',
                    'message' => 'رمز عبور اشتباه وارد شده است.',
                ],
                400
            );
        }
    }
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'name' => 'required',
            'family_name' => 'required',
            'code' => ['required', 'min:5', 'integer'],
            'ref_code' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $otp_class = new Otp();
        $check = $otp_class->checkOtp($request->phone, $request->code);

        if (!$check) {
            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'register',
                    'description' => 'register',
                    'message' => 'لطفا شماره موبایل خود را تایید کنید.',
                ],
                400
            );
        }

        $register_class = new Register();

        $registered_user = $register_class->registerNewUser(
            $request->password,
            $request->name,
            $request->family_name,
            $request->phone
        );

        if ($registered_user) {


            $login_class = new Login;
            $token = $login_class->makeToken($request->phone);


            return response()->json(
                [
                    'status' => 'success',
                    'description' => 'registered',
                    'step' => 'register',
                    'message' => 'حساب کاربری ایجاد شد.',
                    'token' => $token,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'register',
                    'description' => 'registration failed',
                    'message' => 'خطا در ایجاد حساب کاربری',
                ],
                400
            );
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
            // 'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            // 'code' => ['required', 'min:5', 'integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $otp_class = new Otp();
        $send_otp = $otp_class->sendOtp($request->phone);

        return $send_otp;
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'code' => ['required', 'min:5', 'integer'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $otp_class = new Otp();
        $check = $otp_class->checkOtp($request->phone, $request->code);

        if (!$check) {
            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'reset password',
                    'description' => 'otp expired',
                    'message' => 'لطفا شماره موبایل خود را تایید کنید.',
                ],
                400
            );
        }

        $user = User::where('phone', $request->phone)->first();

        $user->password = Hash::make($request->password);

        if ($user->save()) {

            $login_class = new Login;
            $token = $login_class->makeToken($request->phone);

            return response()->json(
                [
                    'status' => 'success',
                    'step' => 'reset password',
                    'description' => 'registered',
                    'token' => $token,
                    'message' => 'رمز عبور با موفقیت تغییر کرد',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'step' => 'reset password',
                    'description' => 'password reset failed',
                    'message' => 'خطا در ایجاد تغییر رمز عبور',
                ],
                400
            );
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'status' => 'success',
                'step' => 'logout',
                'description' => 'logged out',
                'message' => '',
            ],
            200
        );
    }
}