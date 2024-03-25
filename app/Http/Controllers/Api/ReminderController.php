<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function reminders()
    {
        $reminder = Reminder::latest()->select('text')->get();

        return apiResponse(['reminder'=>$reminder], 'Reminders');
    }

    public function updateReminders(Request $request)
    {
        $request->validate(['text'=> 'required|min:2']);
        Reminder::updateOrCreate(
            [],
            ['text' => $request->text]
        );
    
        return successResponse('Reminder updated successfully');
    }
    

    public function promotions()
    {
        $promotion = Promotion::latest()->select('text')->get();

        return apiResponse(['promotion'=>$promotion], 'promotions');
    }

    public function updatePromotion(Request $request)
    {
        $request->validate(['text'=> 'required|min:2']);
        Promotion::updateOrCreate(
            [],
            ['text' => $request->text]
        );
    
        return successResponse('Reminder updated successfully');
    }
}
