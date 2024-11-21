<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorScheduleRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\DoctorScheduleResource;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Http\Requests\UpdateDoctorScheduleRequest;
use App\Models\Appointment;
use App\Traits\HttpResponses;
use Carbon\Carbon;

class DoctorScheduleController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctor_schedules = DoctorSchedule::all();
        return DoctorScheduleResource::collection($doctor_schedules);
    }



    public function store(DoctorScheduleRequest $request)
    {
        $userId = auth()->user()->id;
        $doctor = Doctor::where('user_id', $userId)->first();

        try {
            foreach ($request->schedules as $scheduleData) {
                // اگر برای یک روز خاص زمان شروع یا پایان وجود داشته باشد، رکورد جدید ایجاد می‌کنیم
                if (!is_null($scheduleData['start_time']) && !is_null($scheduleData['end_time'])) {
                    $nextWeekStart = Carbon::now()->next('Saturday')->startOfDay();

                    DoctorSchedule::create([
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $scheduleData['day_of_week'],
                        'schedule_date' => $nextWeekStart->copy()->next($scheduleData['day_of_week'])->format('Y-m-d'),
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                        'appointment_duration' => $scheduleData['appointment_duration'],
                        'cost' => $scheduleData['cost'],
                    ]);
                }
            }

            return $this->successResponse('created', 'زمان بندی نوبت‌ دهی با موفقیت ایجاد شد');
        } catch (\Throwable $th) {
            return $this->errorResponse('creation failed', 'مشکلی در حین ایجاد زمان‌ بندی پیش آمد، لطفاً یک بار دیگر تلاش کنید', 400);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor_schedules = DoctorSchedule::where('doctor_id', $id)->get();
        return DoctorScheduleResource::collection($doctor_schedules);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorScheduleRequest $request, $id)
    {
        $userId = auth()->user()->id;
        $doctor = Doctor::where('user_id', $userId)->first();

        // لیست روزهای هفته موجود در دیتابیس برای این دکتر
        $existingSchedules = DoctorSchedule::where('doctor_id', $doctor->id)
            ->pluck('day_of_week')
            ->toArray();

        // لیست روزهای هفته‌ای که از فرم ارسال شده‌اند
        $newSchedules = array_column($request->schedules, 'day_of_week');

        // حذف زمان‌بندی‌های موجود در دیتابیس که در درخواست ارسال نشده‌اند
        $daysToDelete = array_diff($existingSchedules, $newSchedules);
        DoctorSchedule::where('doctor_id', $doctor->id)
            ->whereIn('day_of_week', $daysToDelete)
            ->delete();

        // به‌روزرسانی یا ایجاد زمان‌بندی‌های جدید
        foreach ($request->schedules as $scheduleData) {
            if (!is_null($scheduleData['start_time']) && !is_null($scheduleData['end_time'])) {
                $nextWeekStart = Carbon::now()->next('Saturday')->startOfDay();

                $schedule = DoctorSchedule::updateOrCreate(
                    [
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $scheduleData['day_of_week']
                    ],
                    [
                        'start_time' => $scheduleData['start_time'],
                        'end_time' => $scheduleData['end_time'],
                        'appointment_duration' => $scheduleData['appointment_duration'],
                        'schedule_date' => $nextWeekStart->copy()->next($scheduleData['day_of_week'])->format('Y-m-d'),
                        'cost' => $scheduleData['cost'],
                    ]
                );
            }
        }

        return $this->successResponse('updated', 'زمان‌بندی نوبت‌دهی با موفقیت به‌روزرسانی شد');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (
            DoctorSchedule::where('doctor_id', $id)
                ->delete()
        ) {
            return $this->successResponse('created', 'عملیات حذف زمان بندی نوبت دهی با موفقیت انجام شد');

        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در حین حذف کردن زمان بندی نوبت دهی پیش امد لطفا یک بار دیگر تلاش کنید', 400);
        }
    }
    function getAppointmentsForSchedule($schedule_id)
    {
        $appointments = Appointment::where('doctor_schedule_id', $schedule_id)->get();
        return AppointmentResource::collection($appointments);
    }
}
