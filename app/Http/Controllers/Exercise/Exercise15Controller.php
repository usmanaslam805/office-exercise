<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise15Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.order' => 'present|array',
            'input.order.weight' => 'required|integer|numeric:strict|min:1',
            'input.order.country' => 'required|string',

            'input.rules' => 'present|array',
            'input.rules.*' => 'present|array',

            'input.rules.*.id' => 'required|integer|numeric:strict|min:1',
            'input.rules.*.max_weight' => 'nullable|integer|numeric:strict|min:1',
            'input.rules.*.country' => 'nullable|string',
            'input.rules.*.method' => 'required|string',
            'input.rules.*.priority' => 'required|integer|numeric:strict|min:1',
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
        $extractedRules = [];
        $count = 0;

        foreach ($rules as $rule) {
            if (isset($order['weight']) && isset($rule['max_weight'])) {
                if ($rule['max_weight'] > $order['weight']) {
                    $extractedRules[$count] = $rule;
                    $count++;
                }
            } else if (isset($order['country']) && isset($rule['country'])) {
                $extractedRules[$count] = $rule;
                $count++;
            }
        }

        $requiredMethod = collect($extractedRules)->sortBy('priority')->first()['method'];

        $response['success'] = true;
        $response['data'] = ['shipping_method' => $requiredMethod];

        return response()->json($response);
    }
}
