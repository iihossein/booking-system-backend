<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReviewsRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\HttpResponses;

class ReviewController extends Controller
{
    use HttpResponses;
    public function index()
    {
        return ReviewResource::collection(Review::all());
    }
    public function store(ReviewRequest $request)
    {
        $validatedData = $request->validated();

        // ایجاد یک نمونه جدید از مدل Review
        $review = Review::create([
            'user_id' => $validatedData['user_id'],
            'doctor_id' => $validatedData['doctor_id'],
            'text' => $validatedData['text'],
            'rate' => $validatedData['rate'],
        ]);
        if ($review->save()) {
            return $this->successResponse('created', 'نظر شما با موفقیت ثبت شد');
        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در ثبن نظر پیش امد لطفا یک بار دیگر امتحان کنید', 400);
        }

    }


    public function show(string $id)
    {
        $doctor = Review::findOrFail($id);
        return new ReviewResource($doctor);
    }




    public function update(ReviewRequest $request, $id)
    {
        // پیدا کردن نظر بر اساس ID
        $review = Review::find($id);

        if (!$review) {
            return $this->errorResponse('not found', 'نظر مورد نظر پیدا نشد', 404);
        }

        // به‌روزرسانی فیلدهای نظر
        $review->update([
            'text' => $request->input('text', $review->text), // اگر متن جدیدی وجود نداشته باشد، از متن قبلی استفاده می‌شود
            'rate' => $request->input('rate', $review->rate), // اگر نمره جدیدی وجود نداشته باشد، از نمره قبلی استفاده می‌شود
        ]);

        // بازگشت پاسخ موفقیت‌آمیز
        return $this->successResponse('updated', 'نظر با موفقیت بروزرسانی شد');
    }



    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        if ($review->destroy($id)) {
            return $this->successResponse('created', 'عملیات حذف نظر با موفقیت انجام شد');

        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در حین حذف کردن نظر پیش امد لطفا یک بار دیگر تلاش کنید', 400);
        }
    }
}
