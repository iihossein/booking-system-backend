<?php

namespace App\Http\Controllers;

use App\Classes\Otp;
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
    /**
     * @OA\Post(
     *     path="/api/auth/sendCode",
     *     tags={"Auth"},
     *     summary="Send OTP Code",
     *     description="Send OTP code to user's phone number",
     *     security={{"csrf":{}}},
     *     @OA\RequestBody(
     *         description="User phone number",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 example="09123456789"
     *             ),
     *             @OA\Property(
     *                 property="_token",
     *                 type="string",
     *                 description="CSRF Token"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="لطفا رمز خود را وارد کنید"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="اطلاعات ارسال شده درست نبوده است"
     *             )
     *         )
     *     )
     * )
     */
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
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'national_code' => ['required', 'min:5', 'integer'],
            'code' => ['required', 'integer'],
            'gender' => 'required',
            'birthday' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'اطلاعات ارسال شده درست نبوده است', 400);
        }

        $otp_class = new Otp();
        $check = $otp_class->checkOtp($request->phone, $request->code);

        if (!$check) {
            return $this->errorResponse('register', 'لطفا شماره موبایل خود را تایید کنید.', 400);
        }

        $register_class = new Register();

        $registered_user = $register_class->registerNewUser(
            $request->first_name,
            $request->last_name,
            $request->phone,
            $request->password,
            $request->national_code,
            $request->gender,
            $request->birthday,

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
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout",
     *     description="Logout the current user",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         description="",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="با موفقیت از حساب خود خارج شدید"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout()
    {
        $user = request()->user('sanctum');
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->successResponse('logged out', 'با موفقیت از حساب خود خارج شدید');
    }
}