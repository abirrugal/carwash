<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function signup(Request $request)
    {
        $request->validate([
            'phone_code' => 'required|string',
            'phone' => 'required|numeric|digits_between:10,15',
        ]);
        $user = User::firstOrCreate(
            [
                'phone_code' => $request->phone_code,
                'phone' => $request->phone
            ]
        );

        $user->otp = $otp = mt_rand(100000, 999999);
        $user->save();
        $phoneCode = $user->phone_code;
        $phoneNumber = $user->phone;

        return apiResponse([
            'user' => UserResource::make($user),
            'otp' => $otp
        ], 'Login Successful');
    }


    public function verifyCode(Request $request)
    {
        $validator = validateRequest($request, [
            'phone_code' => 'required|string',
            'phone' => 'required|string',
            'otp' => 'required|numeric|digits:6'
        ]);

        if ($validator->fails()) {
            return sendValidationError($validator->errors());
        }

        $user = User::where([
            'phone_code' => $request->phone_code,
            'phone' => $request->phone
        ])->first();

        if (!$user) {
            return errorResponse('User Not Found!', 404);
        }

        if ($user->otp != $request->otp) {
            return errorResponse('Invalid OTP', 422);
        }

        return apiResponse([
            'user' => UserResource::make($user),
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 'Login Successful');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'phone_code' => 'required|string',
            'phone' => 'required|numeric|digits_between:11,15',
        ]);

        $user = User::firstOrCreate(
            [
                'phone_code' => $request->phone_code,
                'phone' => $request->phone
            ]
        );

        return apiResponse([
            'user' => UserResource::make($user),
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 'Login Successful');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return successResponse('Logged out successfully');
    }
}
