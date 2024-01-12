<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VechicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vechicles = Vehicle::latest();
        if ($request->type) {
            $vechicles =  $vechicles->where('type', $request->type);
        }
        $vechicles = $vechicles->get();

        return apiResourceResponse(VechicleResource::collection($vechicles), 'Vechicles List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|string|min:2',
            'model' => 'required|string|min:2',
            'type' => 'required|string|in:classic, modern',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $image = upload($request->file('image'), 'vechicles');
            $inputs['image'] = $image;
        }

        $inputs['user_id'] = auth()->id();

        Vehicle::create($inputs);

        return successResponse('Vechicle created successfully!');
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $inputs = $request->validate([
            'name' => 'nullable|string|min:2',
            'model' => 'nullable|string|min:2',
            'type' => 'nullable|string|in:classic, modern',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);  

        if($request->file('image') && $request->file('image')->isValid()){
            
        }

        $vehicle->update($inputs);
    }
}
