<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
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
            // اعتبارسنجی برای ایجاد پست جدید
            return [
                'doctor_id' => 'required|integer|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|max:255',
                'days_of_week' => 'required|max:100',
                'appointments_number' => 'required|integer|max:100',
            ];
        } elseif ($this->isMethod('put')) {
            // اعتبارسنجی برای ویرایش پست
            return [
                'doctor_id' => 'required|integer|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|max:255',
                'days_of_week' => 'required|max:100',
                'appointments_number' => 'required|integer|max:100',
            ];
        } else {
            return [];
        }
    }
}
