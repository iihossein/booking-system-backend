<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return AppointmentResource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
    public function book(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::find($request->appointment_id);

        if ($appointment->user_id !== null) {
            return $this->errorResponse('creatation failed', 'This appointment is already booked', 400);
        }

        $appointment->user_id = Auth::id();
        $appointment->save();

        return $this->successResponse('created', 'Appointment booked successfully');
    }
    public function cancel(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = Appointment::find($request->appointment_id);

        if ($appointment->user_id !== Auth::id()) {
            return $this->errorResponse('cancelation failed', 'You cannot cancel this appointment', 403);
        }

        // بررسی اینکه نوبت حداقل دو روز بعد باشد
        $appointmentDate = Carbon::parse($appointment->appointment_date_time); // فرض می‌کنیم فیلد 'date' تاریخ نوبت باشد
        $now = Carbon::now();
        if ($appointmentDate->diffInDays($now) < 2) {
            return $this->errorResponse('cancelation failed', 'You can only cancel the appointment at least 2 days in advance', 400);
        }

        $appointment->user_id = null;
        $appointment->save();

        return $this->successResponse('canceled', 'Appointment cancelled successfully');
    }
}
