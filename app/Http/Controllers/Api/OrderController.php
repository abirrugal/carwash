<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Additional;
use App\Models\Order;
use App\Models\OrderAdditionalPrice;
use App\Models\OrderItem;
use App\Models\Package;
use App\Models\UserVehicle;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        
    }

    public function store(Request $request)
    {
        // Validation
        $order = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|numeric',
            'customer_address' => 'required|string',
            'tips' => 'nullable|numeric',
        ]);

        // Retrieve package details
        $package = Package::find($request->package_id);

        // Check if the package exists
        if (!$package) {
            return response()->json(['error' => 'Invalid package_id'], 400);
        }

        $orderData = [
            'package_name' => $package->title,
            'package_details' => $package->details,
            'package_price' => $package->price,
            'package_work_time' => $package->time_limit,
            'user_id' => auth()->id()
        ];

        $orderData = array_merge($order, $orderData);

        // Create the order
        $order = Order::create($orderData);
        $orderItems = $request->input('order_items');

        if (!is_array($orderItems)) {
            return response()->json(['error' => 'Invalid order_items format'], 400);
        }

        foreach ($orderItems as $orderItemData) {
            // Retrieve UserVehicle data
            $userVehicle = UserVehicle::find($orderItemData);

            // Check if the user_vehicle exists
            if (!$userVehicle) {
                return response()->json(['error' => 'Invalid user_vehicle_id in order_items'], 400);
            }

            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'user_vehicle_id' => $orderItemData,
                'vehicle_name' => $userVehicle->name,
                'vehicle_model' => $userVehicle->model,
                'type' => $userVehicle->type,
            ]);

            $order->orderItems()->save($orderItem);
            // Retrieve additional_price_ids
            $additionalPriceIds = $request->input('additional_price_ids', []);
            foreach ($additionalPriceIds as $additionalPriceId) {
                // Retrieve Additional data
                $additional = Additional::find($additionalPriceId);

                // Check if the additional exists
                if ($additional) {
                    $additionalData = [
                        'order_item_id' => $orderItem->id,
                        'title' => $additional->title,
                        'details' => $additional->details,
                        'price' => $additional->price,
                    ];

                    OrderAdditionalPrice::create($additionalData);
                }
            }
        }

        return successResponse('Order Placed successfully.');
    }
}
