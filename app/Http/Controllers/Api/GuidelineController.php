<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuidelineResource;
use App\Models\Guideline;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function index(Request $request)
    {
        $guideline = Guideline::latest()->get();

        return apiResourceResponse(GuidelineResource::collection($guideline), 'Guideline List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|string|min:2',
            'details' => 'required|string|min:3',
        ]);
        Guideline::create($inputs);

        return successResponse('Guideline created successfully!');
    }

    public function update(Request $request, Guideline $guideline)
    {
        $inputs = $request->validate([
            'title' => 'nullable|string|min:2',
            'details' => 'nullable|string|min:2',
        ]);

        $guideline->update($inputs);

        return successResponse('Guideline updated successfully!');
    }

    public function destroy(Guideline $guideline)
    {
        $guideline->delete();

        return successResponse('Guideline deleted successfully!');
    }
}
