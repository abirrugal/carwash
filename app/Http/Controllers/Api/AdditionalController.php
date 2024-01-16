<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdditionalResource;
use App\Models\Additional;
use Illuminate\Http\Request;

class AdditionalController extends Controller
{
    public function index(Request $request)
    {
        $additional = Additional::latest()->get();

        return apiResourceResponse(AdditionalResource::collection($additional), 'Additional List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|string|min:2',
            'details' => 'required|string|min:3',
            'price' => 'required|numeric',
            'mini_title' => 'nullable|string'
        ]);
        Additional::create($inputs);

        return successResponse('Additional created successfully!');
    }

    public function update(Request $request, Additional $additional)
    {
        $inputs = $request->validate([
            'title' => 'nullable|string|min:2',
            'details' => 'nullable|string|min:2',
            'price' => 'nullable|numeric',
            'mini_title' => 'nullable|string'
        ]);

        $additional->update($inputs);

        return successResponse('Additional updated successfully!');
    }

    public function destroy(Additional $additional)
    {
        $additional->delete();

        return successResponse('Additional deleted successfully!');
    }
}
