<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::latest()->select('message','user_id')->get();

        return apiResourceResponse(FeedbackResource::collection($feedback), 'Feedback list');
    }

    // public function myFeedBack()
    // {
    //     $myFeedback = Feedback::where('user_id', auth()->id())->latest()->get();

    //     return apiResponse(['myFeedback' => $myFeedback], 'My Feedback list');
    // }

    public function store(Request $request)
    {
        $request->validate(['message'=>'required|min:2|string']);

        Feedback::create(['user_id'=>auth()->id(), 'message'=>$request->message]);

        return successResponse('Your feedback submitted successfully');
    }
}
