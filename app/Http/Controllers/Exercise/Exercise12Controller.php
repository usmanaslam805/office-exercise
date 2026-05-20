<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise12Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.items' => 'present|array',
            'input.items.*.id' => 'required|integer|numeric:strict|min:1',
            'input.items.*.price' => 'required|integer|numeric:strict|min:0',

            'input.bundle_price' => 'required|integer|numeric:strict|min:0',
            'input.apply_bundle' => 'required|boolean',
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
        $items = $input['items'];
        $bundlePrice = $input['bundle_price'];
        $combinedPrice = 0;
        $finalPrice = 0;

        foreach ($items as $key => $item) {
            $combinedPrice += $item['price'];
        }

        $finalPrice = $combinedPrice;

        if ($input['apply_bundle']) {
            if ($bundlePrice > $combinedPrice) {
                $finalPrice =  $bundlePrice;
            }
        }

        $response['success'] = true;
        $response['data'] = ["final_calculated_price" => $finalPrice];

        return response()->json($response);
    }
}
