<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $vechicles = Package::latest()->get();

        return apiResourceResponse(PackageResource::collection($vechicles), 'Package List');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|string|min:2',
            'details' => 'required|string|min:3',
            'time_limit' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $image = upload($request->file('image'), 'packages');
            $inputs['image'] = $image;
        }

        Package::create($inputs);

        return successResponse('Package created successfully!');
    }

    public function update(Request $request, Package $package)
    {
        $inputs = $request->validate([
            'title' => 'nullable|string|min:2',
            'details' => 'nullable|string|min:3',
            'time_limit' => 'nullable|string',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        if ($request->file('image') && $request->file('image')->isValid()) {
            detach($package->image);
            $image = upload($request->file('image'), 'packages');
            $inputs['image'] = $image;
        }
        $package->update($inputs);

        return successResponse('Package updated successfully!');
    }

    public function destroy(Package $package)
    {        
        detach($package->image);
        $package->delete();

        return successResponse('Package deleted successfully!');
    }
}
