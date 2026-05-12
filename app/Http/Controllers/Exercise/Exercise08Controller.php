<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise08Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.ordered' => 'required|integer|numeric:strict|min:1',
            'input.shipped' => 'required|array',
            'input.shipped.*' => 'required|integer|numeric:strict|min:1',
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
        $ordered = $input['ordered'];
        $totalShipped = 0;

        foreach ($input['shipped'] as $shipped) {
            $totalShipped += $shipped;
        }

        if ($ordered < $totalShipped) {
            $response['message'] = "Order quantity issue";
            $response['error'] = 'Total shipped quantity cannot be greater than ordered quantity.';

            return response()->json($response);
        }

        $response['success'] = true;
        $response['data']['remaining'] = $ordered - $totalShipped;

        return response()->json($response);
    }
}
