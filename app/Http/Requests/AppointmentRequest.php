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
            // اعتبارسنجی برای ایجاد پست جدید
            return [
                'office_id' => 'required|integer|max:255',
                'user_id' => 'required|integer|max:255',
                'date' => 'required|max:255',
                'number' => 'required|integer|max:100',
            ];
        } elseif ($this->isMethod('put')) {
            // اعتبارسنجی برای ویرایش پست
            return [
                'office_id' => 'required|integer|max:255',
                'user_id' => 'required|integer|max:255',
                'date' => 'required|max:255',
                'number' => 'required|integer|max:100',
            ];
        } else {
            return [];
        }
    }
}
