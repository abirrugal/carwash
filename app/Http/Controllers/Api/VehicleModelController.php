<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleModelResource;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index()
    {
        $vechicles = VehicleModel::latest()->get();

        return apiResourceResponse(VehicleModelResource::collection($vechicles), 'Vechicle Model List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'model' => 'required|string|min:2',
        ]);
        $inputs['created_by'] = auth()->id();

        VehicleModel::create($inputs);

        return successResponse('Vechicle model created successfully!');
    }

    public function update(Request $request, VehicleModel $vehicle)
    {
        $inputs = $request->validate([
            'model' => 'nullable|string|min:2',
        ]);

        $vehicle->update($inputs);

        return successResponse('Vechicle model updated successfully!');
    }

    public function destroy(VehicleModel $vehicle)
    {
        $vehicle->delete();

        return successResponse('Vechicle model deleted successfully!');
    }
}
