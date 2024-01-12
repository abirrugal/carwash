<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

if (!function_exists('apiResponse')) {
    function apiResponse(object|array $data, string|null $message = null, int $statusCode = 200,)
    {
        $response['status'] = true;

        if (isset($message)) $response['message'] = $message;
        if (!empty($data)) $response['data'] = $data;

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('successResponse')) {
    function successResponse(string $message, int $statusCode = 200)
    {
        $response['status'] = true;

        if (isset($message)) $response['message'] = $message;

        return response()->json($response, $statusCode);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message ?? 'Something went wrong!',
        ], $statusCode);
    }
}

if (!function_exists('apiResourceResponse')) {
    function apiResourceResponse(object $collection, string|null $message = null, array $extraData = [], int $statusCode = 200)
    {
        $response['status'] = true;
        if (isset($message)) $response['message'] = $message;
        if (!empty($extraData)) $response['extraData'] = $extraData;

        if (!empty($collection)) {
            $collection = $collection->additional($response)->response()->getData();
        }

        return response()->json($collection, $statusCode);
    }
}

if (!function_exists('str_slug')) {
    function str_slug($title)
    {
        return Str::slug($title);
    }
}

if (!function_exists('sendValidationError')) {
    function sendValidationError($errors)
    {
        return response()->json([
            'status' => false,
            'message' => $errors->first()
        ], 422);
    }
}

if (!function_exists('validateRequest')) {
    function validateRequest(Request $request, array $rules)
    {
        return Validator::make($request->all(), $rules);
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($url = null)
    {
        if(!$url){
            return asset('default/default.png');
        }

        return asset($url);
    }
}

if (!function_exists('upload')) {
    function upload($file, $path = null)
    {
        if($path){
            $path = 'image/'. $path;
        }else{
            $path = 'image';
        }
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $storeName = $path . '/' . $name;
        $file->move(public_path($path), $name);

        return $storeName;
    }
}

if (!function_exists('detach')) {
    function detach($path)
    {
        if(file_exists($path)){
            unlink($path);
        }
    }
}