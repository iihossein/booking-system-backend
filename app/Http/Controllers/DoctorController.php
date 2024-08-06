<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $doctors = Doctor::all();
        return DoctorResource::collection($doctors);
    }


    // public function store(DoctorRequest $request)
    // {
    //     $doctor = Doctor::create([
    //         'user_id' => $request->user_id,
    //         'expertise_id' => $request->expertise_id,
    //         'date_start_treatment' => $request->date_start_treatment,
    //         'is_active' => true, // می‌توانید این مقدار را بر اساس نیاز تغییر دهید
    //     ]);
    //     if ($doctor->save()) {
    //         return $this->successResponse('created', 'عملیات افزودن دکتر با موفقیت انجام شد');
    //     } else {
    //         return $this->errorResponse('creatation failed', 'مشکلی در حین اضافه کردن دکتر پیش امد لطفا یک بار دیگر تلاش کنید', 400);
    //     }
    // }


    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        return new DoctorResource($doctor);
    }

    // public function update(DoctorRequest $request, string $id)
    // {
    //     $doctor = Doctor::find($id);

    //     // به‌روزرسانی اطلاعات دکتر با استفاده از داده‌های اعتبارسنجی شده
    //     $doctor->update([
    //         'user_id' => $request->user_id,
    //         'expertise_id' => $request->expertise_id,
    //         'date_start_treatment' => $request->date_start_treatment,
    //         'is_active' => $request->is_active, // فرض بر این است که این فیلد هم در درخواست وجود دارد
    //     ]);
    //     if ($doctor->save()) {
    //         return $this->successResponse('created', 'عملیات ویرایش دکتر با موفقیت انجام شد');
    //     } else {
    //         return $this->errorResponse('creatation failed', 'مشکلی در حین ویرایش کردن دکتر پیش امد لطفا یک بار دیگر تلاش کنید', 400);
    //     }
    // }
    public function destroy(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        if ($doctor->destroy($id)) {
            return $this->successResponse('created', 'عملیات حذف دکتر با موفقیت انجام شد');

        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در حین حذف کردن دکتر پیش امد لطفا یک بار دیگر تلاش کنید', 400);
        }
    }



}
