<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpertiseRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\ExpertiseResource;
use App\Models\Expertise;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExpertiseController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $expertises = Expertise::all();
        return ExpertiseResource::collection($expertises);
    }

    public function store(ExpertiseRequest $request)
    {
        $expertise = Expertise::create([
            'name' => $request->name,
            'slug' => $request->slug ?? null, // اگر slug موجود نباشد، مقدار null قرار می‌دهیم
        ]);
        if ($expertise->save()) {
            return $this->successResponse('created', 'عملیات افزودن تخصص با موفقیت انجام شد');
        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در حین اضافه کردن تخصص پیش امد لطفا یک بار دیگر تلاش کنید', 400);
        }

    }
    public function show(string $id)
    {
        $expertise = Expertise::findOrFail($id);
        return new ExpertiseResource($expertise);
    }


    public function update(ExpertiseRequest $request, string $id)
    {
        $expertise = Expertise::findOrFail($id);

        // بررسی وجود تخصص
        if (!$expertise) {
            return $this->errorResponse('not found', 'تخصص مورد نظر پیدا نشد', 404);
        }

        // به‌روزرسانی تخصص
        $expertise->update([
            'name' => $request->name,
            'slug' => $request->slug ?? null, // اگر slug موجود نباشد، مقدار null قرار می‌دهیم
        ]);

        // بازگشت پاسخ موفقیت‌آمیز
        return $this->successResponse('updated', 'عملیات ویرایش تخصص با موفقیت انجام شد');
    }


    public function destroy(string $id)
    {
        $expertise = Expertise::find($id);
        if ($expertise->destroy($id)) {
            return $this->successResponse('created', 'عملیات حذف تخصص با موفقیت انجام شد');

        } else {
            return $this->errorResponse('creatation failed', 'مشکلی در حین حذف کردن تخصص پیش امد لطفا یک بار دیگر تلاش کنید', 400);
        }
    }

    public function search(string $id)
    {
        $expertise = Expertise::with('doctors')->where('id', $id)->first();
        return DoctorResource::collection($expertise->doctors);
    }
}
