<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise05Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.price' => 'required|integer',
            'input.discounts' => 'required|array',
            'input.discounts.*.type' => 'required|string|in:percentage,flat',
            'input.discounts.*.value' => 'required|numeric',
        ]);

        $response = [
            'success' => false,
            'error' => null
        ];

        if ($validator->fails()) {
            $response['message'] = "Validation error";
            $response['error'] = $validator->messages()->first();

            return response()->json($response);
        }

        $input = $request['input'];
        $price = $input['price'];
        $discounts = $input['discounts'];

        $tempFinalPrices = [];

        foreach ($discounts as $key => $discount) {
            if ($discount['type'] == 'percentage') {
                $tempFinalPrices[$key] = $price - ($price * ($discount['value'] / 100));
            } else {
                $tempFinalPrices[$key] = $price - $discount['value'];
            }
        }

        $tempFinalPrice = collect($tempFinalPrices)->sort()->first();

        if ($tempFinalPrice < 0) {
            $tempFinalPrice = 0;
        }

        $response['success'] = true;
        $response['data']['final_price'] = $tempFinalPrice;

        return response()->json($response);
    }
}
