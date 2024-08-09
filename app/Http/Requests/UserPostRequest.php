<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\\d{7}$/'],
            'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'national_code' => ['required', 'min:5', 'integer'],
            'code' => ['required', 'integer'],
            'gender' => ['required'],
            'birthday' => ['required'],
            'expertise_id' => ['required', 'integer', 'max:255'],
            'date_start_treatment' => ['required', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'office_phone' => ['required', 'max:255'],
            'days_of_week' => ['required', 'max:100'],
            'appointments_number' => ['required', 'integer', 'max:100'],
            'as_doctor' => ['required'],
        ];

    }
}