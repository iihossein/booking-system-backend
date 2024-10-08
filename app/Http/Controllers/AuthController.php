<?php

namespace App\Http\Controllers;

use App\Classes\Otp;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Classes\Login;
use App\Classes\Register;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'اطلاعات ارسال شده درست نبوده است', 400);
        }

        $user = User::where('phone', $request->phone)->first();


        if ($user and $user->password != null) {
            if ($user->status == 0) {
                return $this->errorResponse('user status', 'حساب کاربری شما محدود شده است', 400);

            } else {
                return $this->successResponse('password', 'لطفا رمز خود را وارد کنید');
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
            'code' => ['required', 'integer'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'اطلاعات ارسال شده درست نبوده است', 400);
        }

        $otp_class = new Otp();
        $check_otp = $otp_class->checkOtp($request->phone, $request->code);


        if ($check_otp) {
            return $this->successResponse('good code', 'کد تایید وارد شده صحیح است.');
        } else {

            return $this->errorResponse('wrong code', 'کد تایید وارد شده اشتباه است.', 400);
        }
    }

    public function checkPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'اطلاعات ارسال شده درست نبوده است', 400);
        }

        $user = User::where('phone', $request->phone)->first();


        if (Hash::check($request->password, $user->password)) {
            $login_class = new Login;
            $token = $login_class->makeToken($user->phone);

            return $this->successResponse('good password', 'رمز وارد شده درست است', $token);
        } else {
            return $this->errorResponse('wrong password', 'رمز عبور به اشتباه وارد شده است', 400);
        }
    }

    public function registerUser(UserRequest $request)
    {
        if ($request->has('as_doctor')) {
            $role = 'doctor';
        } else {
            $role = 'patient';
        }

        $otp_class = new Otp();
        $check = $otp_class->checkOtp($request->phone, $request->code);

        if (!$check) {
            return $this->errorResponse('register', 'لطفا شماره موبایل خود را تایید کنید.', 400);
        }
        $user_data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'national_code' => $request->input('national_code'),
            'code' => $request->input('code'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
        ];
        $doctor_data = [
            'expertise_id' => $request->input('expertise_id'),
            'date_start_treatment' => $request->input('date_start_treatment'),
        ];
        $register_class = new Register();
        $registered_user = $register_class->registerNewUser(
            $role,
            $user_data,
            $doctor_data,
        );
        if ($registered_user) {
            $login_class = new Login;
            $token = $login_class->makeToken($request->phone);
            return $this->successResponse('registered', 'حساب کاربری ایجاد شد.', $token);
        } else {
            return $this->errorResponse('registration failed', 'خطا در ایجاد حساب کاربری', 400);
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

    public function logout()
    {
        $user = request()->user('sanctum');
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->successResponse('logged out', 'با موفقیت از حساب خود خارج شدید');
    }
}