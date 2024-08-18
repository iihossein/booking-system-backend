<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorScheduleRequest extends FormRequest
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
                'schedules' => 'array|required',
                'schedules.*.day_of_week' => 'required|string|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
                'schedules.*.start_time' => 'nullable|date_format:H:i:s',
                'schedules.*.end_time' => 'nullable|date_format:H:i:s|after:schedules.*.start_time',
                'schedules.*.appointment_duration' => 'nullable|integer|min:1',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'schedules' => 'array|required',
                'schedules.*.day_of_week' => 'required|string|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday',
                'schedules.*.start_time' => 'nullable|date_format:H:i:s',
                'schedules.*.end_time' => 'nullable|date_format:H:i:s|after:schedules.*.start_time',
                'schedules.*.appointment_duration' => 'nullable|integer|min:1',
            ];
        } else {
            return [];
        }

    }
}
