<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'doctor_id' => 'required|exists:doctors,id',
                'user_id' => 'nullable|exists:users,id',
                'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
                'appointment_date_time' => 'required|date',
                'status' => 'required|in:Scheduled,Expired,Reserved',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'doctor_id' => 'required|exists:doctors,id',
                'user_id' => 'nullable|exists:users,id',
                'doctor_schedule_id' => 'required|exists:doctor_schedules,id',
                'appointment_date_time' => 'required|date',
                'status' => 'required|in:Scheduled,Expired,Reserved',
            ];
        } else {
            return [];
        }
    }
}
