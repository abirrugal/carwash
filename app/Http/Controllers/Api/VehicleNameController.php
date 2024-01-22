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
        $vechicles = VehicleName::latest();
        $type = $request->type;

        if($type){
            $vechicles = $vechicles->where('type', $type);
        }
        $vechicles = $vechicles->get();

        return apiResourceResponse(VehicleNameResource::collection($vechicles), 'Vechicle name List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|string|min:2',
            'type' => 'required|in:classic, modern'
        ]);
        $inputs['created_by'] = auth()->id();

        VehicleName::create($inputs);

        return successResponse('Vechicle Name created successfully!');
    }

    public function update(Request $request, VehicleName $vehicle)
    {
        $inputs = $request->validate([
            'name' => 'nullable|string|min:2',
            'type' => 'nullable|in:classic, modern'
        ]);

        $vehicle->update($inputs);

        return successResponse('Vechicle Name updated successfully!');
    }

    public function destroy(VehicleName $vehicle)
    {     
        $vehicle->delete();

        return successResponse('Vechicle Name deleted successfully!');
    }
}
