<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpertiseResource;
use App\Models\Expertise;
use Illuminate\Http\Request;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expertises = Expertise::all();
        return ExpertiseResource::collection($expertises);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expertise = Expertise::findOrFail($id);
        return new ExpertiseResource($expertise);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expertise = Expertise::findOrFail($id);
        $expertise->destroy($id);
        return json_encode([
               'messages' => 'تخصص مورد نظر با موفقیت حذف شد.'
        ]);
    }
}
