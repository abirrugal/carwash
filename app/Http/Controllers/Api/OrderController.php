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
    // public function store(Request $request)
    // {
    //     $Orderinputs = $request->validate([
    //         'package_id' => 'required|exists:packages,id',
    //         'customer_name' => 'required|string',
    //         'customer_phone' => 'required|numeric',
    //         'customer_address' => 'required|string',
    //     ]);

    //     $package = Package::find($request->package_id);
    //     $Orderinputs['package_name'] = $package->title;
    //     $Orderinputs['package_details'] = $package->details;
    //     $Orderinputs['package_price'] = $package->price;
    //     $Orderinputs['package_time_limit'] = $package->time_limit;

    //     $order = Order::create($Orderinputs);

    //     $orderItems = $request->order_items;

    //     if (is_string($orderItems)) {
    //         $orderItems = json_decode($orderItems, true);
    //         if ($orderItems == null) {
    //             return response()->json(['error' => 'Invalid JSON format for billing_items'], 400);
    //         }
    //     }

    //     $additionalPriceIds = $request->additional_price_ids;

    //     foreach ($orderItems as $key => $orderItem) {

    //         $userVehicle = UserVehicle::find($orderItem['user_vehicle_id']);

    //         $orderItems['order_id'] = $order->id;
    //         $orderItems['user_vehicle_id'] = $orderItem['user_vehicle_id'];
    //         $orderItems['vehicle_name'] = $userVehicle->name;
    //         $orderItems['vehicle_model'] = $userVehicle->model;
    //         $orderItems['type'] = $userVehicle->type;

    //         $orderItemStore = OrderItem::create($orderItems);

    //         foreach ($additionalPriceIds as $key => $additionalPriceId) {

    //             $additional = Additional::find($additionalPriceId);
    //             $additionalItems['order_item_id'] = $orderItemStore->id;
    //             $additionalItems['title'] = $additional->title;
    //             $additionalItems['details'] = $additional->details;
    //             $additionalItems['price'] = $additional->price;
    //             OrderAdditionalPrice::create($additionalItems);
    //         }

    //     }

    //     return 'ok';
    // }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|numeric',
            'customer_address' => 'required|string',
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
            'package_time_limit' => $package->time_limit,
        ];

        // Create the order
        $order = Order::create($orderData);

        // Retrieve and decode order_items
        $orderItems = json_decode($request->input('order_items'), true);

        if (!is_array($orderItems)) {
            return response()->json(['error' => 'Invalid order_items format'], 400);
        }

        foreach ($orderItems as $orderItemData) {
            // Validate user_vehicle_id existence
            if (!isset($orderItemData['user_vehicle_id'])) {
                return response()->json(['error' => 'user_vehicle_id is required in order_items'], 400);
            }

            // Retrieve UserVehicle data
            $userVehicle = UserVehicle::find($orderItemData['user_vehicle_id']);

            // Check if the user_vehicle exists
            if (!$userVehicle) {
                return response()->json(['error' => 'Invalid user_vehicle_id in order_items'], 400);
            }

            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'user_vehicle_id' => $orderItemData['user_vehicle_id'],
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

        return response()->json(['status' => 'ok']);
    }
}
