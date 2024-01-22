<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserVehicleResource;
use App\Models\UserVehicle;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\VehicleName;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $vehicles = UserVehicle::where('user_id', auth()->id())->latest()->get();

        return apiResourceResponse(UserVehicleResource::collection($vehicles), 'User Vehicle list.');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'vehicle_name_id' => 'required|exists:vehicle_names, id',
            'vehicle_model_id' => 'required|exists:vehicle_models, id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        unset($inputs['vehicle_name_id'], $inputs['vehicle_model_id']);
        $inputs['type'] = VehicleName::find($request->vehicle_name_id)->type;
        $inputs['name'] = VehicleName::find($request->vehicle_name_id)->name;
        $inputs['model'] = VehicleModel::find($request->vehicle_name_id)->model;

        if ($request->file('image') && $request->file('image')->isValid()) {
            $image = upload($request->file('image'), 'uservehicles');
            $inputs['image'] = $image;
        }

        $inputs['user_id'] = auth()->id();
        UserVehicle::create($inputs);

        return successResponse('User vehicle created successfully.');
    }

    public function update(Request $request, UserVehicle $vehicle)
    {
        $inputs = $request->validate([
            'vehicle_name_id' => 'nullable|exists:vehicle_names, id',
            'vehicle_model_id' => 'nullable|exists:vehicle_models, id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);
        
        unset($inputs['vehicle_name_id'], $inputs['vehicle_model_id']);
        $inputs['name'] = VehicleName::find($request->vehicle_name_id)->name;
        $inputs['type'] = VehicleName::find($request->vehicle_name_id)->type;
        $inputs['model'] = VehicleModel::find($request->vehicle_name_id)->model;

        if ($request->file('image') && $request->file('image')->isValid()) {
            detach($vehicle->image);
            $image = upload($request->file('image'), 'uservehicles');
            $inputs['image'] = $image;
        }
        $vehicle->update($inputs);

        return successResponse('User vehicle created successfully.');
    }

    public function destroy(UserVehicle $vehicle)
    {
        $vehicle->delete();
    }
}
