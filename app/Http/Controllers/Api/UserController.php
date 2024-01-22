<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $vehicles = UserVehicle::where('user_id', auth()->id())->latest()->get();

        return apiResourceResponse($vehicles, 'User Vehicle list.');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        if($request->file('image') && $request->file('image')->isValid()){
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        if($request->file('image') && $request->file('image')->isValid()){
            $image = upload($request->file('image'), 'uservehicles');
            $inputs['image'] = $image;
        }
        $inputs['user_id'] = auth()->id();
        UserVehicle::create($inputs);

        return successResponse('User vehicle created successfully.');
    }
}
