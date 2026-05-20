<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise16Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.order' => 'present|array',
            'input.order.amount' => 'required|integer|numeric:strict|min:1',
            'input.order.country' => 'required|string',

            'input.order.previous_orders' => 'nullable|integer|numeric:strict|min:1',

            'input.rules' => 'present|array',
            'input.rules.max_amount' => 'required|integer|numeric:strict|min:1',
            'input.rules.blocked_countries' => 'present|array',
            'input.rules.blocked_countries.*' => 'required|string',
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
        $order = $input['order'];
        $rules = $input['rules'];
        $flagged = false;

        if (isset($order['amount']) && isset($rules['max_amount'])) {
            if ($order['amount'] > $rules['max_amount']) {
                $flagged = true;
            }
        }

        if (in_array($order['country'], $rules['blocked_countries'])) {
            $flagged = true;
        }

        $response['success'] = true;
        $response['data'] = ['flagged' => $flagged];

        return response()->json($response);
    }
}
