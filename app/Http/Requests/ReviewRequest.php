<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
                'user_id' => 'required|exists:users,id', // بررسی وجود کاربر
                'doctor_id' => 'required|exists:doctors,id', // بررسی وجود پزشک
                'text' => 'required|string|max:1000', // بررسی متن نظر
                'rate' => 'required|integer|between:1,5', // بررسی نمره
            ];
        } else {
            return [
                'text' => 'nullable|string|max:1000', // متن نظر می‌تواند خالی باشد
                'rate' => 'nullable|integer|between:1,5', // نمره می‌تواند خالی باشد
            ];
        }
    }
}
