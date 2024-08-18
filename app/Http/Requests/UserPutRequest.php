<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->input('as_doctor')) {
            return [
                'first_name' => ['nullable', 'string'],
                'last_name' => ['nullable', 'string'],
                'phone' => ['nullable', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\\d{7}$/'],
                'password' => ['nullable', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                'national_code' => ['nullable', 'min:5', 'integer'],
                'code' => ['nullable', 'integer'],
                'gender' => ['nullable'],
                'birthday' => ['nullable'],
                'expertise_id' => ['nullable', 'integer', 'max:255'],
                'date_start_treatment' => ['nullable', 'max:100'],
                'as_doctor' => ['nullable'],
            ];
        } else {
            return [
                'first_name' => ['nullable', 'string'],
                'last_name' => ['nullable', 'string'],
                'phone' => ['nullable', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\\d{7}$/'],
                'password' => ['nullable', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                'national_code' => ['nullable', 'min:5', 'integer'],
                'code' => ['nullable', 'integer'],
                'gender' => ['nullable'],
                'birthday' => ['nullable'],
                'as_doctor' => ['nullable'],
            ];
        }
    }
}