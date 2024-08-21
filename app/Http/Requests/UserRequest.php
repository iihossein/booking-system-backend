<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            if ($this->input('as_doctor') == true) {
                return [
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
                    'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                    'national_code' => ['required', 'min:5', 'integer'],
                    'code' => ['required', 'integer'],
                    'gender' => 'required',
                    'birthday' => 'required|date_format:Y/m/d',
                    'expertise_id' => 'required|integer|max:255',
                    'date_start_treatment' => 'required|date_format:Y',
                    'address' => 'required|string',
                    'clinic_phone' => 'nullable|string',
                    'as_doctor' => 'required',
                ];
            } else {
                return [
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'phone' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
                    'password' => ['required', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                    'national_code' => ['required', 'min:5', 'integer'],
                    'code' => ['required', 'integer'],
                    'gender' => 'required',
                    'birthday' => 'required',
                    'as_doctor' => 'required',
                ];
            }

        } elseif ($this->isMethod('put')) {
            if ($this->input('as_doctor') == true) {
                return [
                    'first_name' => ['nullable', 'string'],
                    'last_name' => ['nullable', 'string'],
                    'phone' => ['nullable', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
                    'password' => ['nullable', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                    'national_code' => ['nullable', 'min:5', 'integer'],
                    'code' => ['nullable', 'integer'],
                    'gender' => 'nullable',
                    'birthday' => 'nullable',
                    'expertise_id' => 'nullable|integer|max:255',
                    'date_start_treatment' => 'nullable|date_format:Y',
                    'address' => 'required|string',
                    'clinic_phone' => 'nullable|string',
                    'as_doctor' => 'required',
                ];
            } else {
                return [
                    'first_name' => ['nullable', 'string'],
                    'last_name' => ['nullable', 'string'],
                    'phone' => ['nullable', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
                    'password' => ['nullable', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
                    'national_code' => ['nullable', 'min:5', 'integer'],
                    'code' => ['nullable', 'integer'],
                    'gender' => 'nullable',
                    'birthday' => 'nullable',
                    'as_doctor' => 'required',
                ];
            }
        } else {
            return [];
        }
    }
}
