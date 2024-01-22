<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleNameResource;
use App\Models\VehicleName;
use Illuminate\Http\Request;

class VehicleNameController extends Controller
{
    public function index(Request $request)
    {
        $vechicles = VehicleName::latest()->get();

        return apiResourceResponse(VehicleNameResource::collection($vechicles), 'Vechicles List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|string|min:2',
        ]);
        $inputs['created_by'] = auth()->id();

        VehicleName::create($inputs);

        return successResponse('Vechicle Name created successfully!');
    }

    public function update(Request $request, VehicleName $vehicle)
    {
        if ($vehicle->user_id != auth()->id()) return 'Permission denied';

        $inputs = $request->validate([
            'name' => 'nullable|string|min:2',
        ]);

        $vehicle->update($inputs);

        return successResponse('Vechicle Name updated successfully!');
    }

    public function destroy(VehicleName $vehicle)
    {
        if ($vehicle->user_id != auth()->id()) return 'Permission denied';
        
        $vehicle->delete();

        return successResponse('Vechicle Name updated successfully!');
    }
}
