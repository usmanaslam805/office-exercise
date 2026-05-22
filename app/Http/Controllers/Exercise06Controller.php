<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise06Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.steps' => 'required|array',
            'input.steps.*.id' => 'required|string|distinct',
            'input.steps.*.depends_on' => 'nullable|string',
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
        $steps = $input['steps'];
        $validSteps = [];

        $validSteps = $steps;

        foreach ($steps as $key01 => $step01) {
            $validStep = $step01;

            if ($step01['depends_on'] != null) {
                foreach ($steps as $key02 => $step02) {
                    if ($key01 >= $key02 && $step01['depends_on'] == $step02['id']) {
                        $validStep['valid'] = true;
                        break;
                    } else {
                        $validStep['valid'] = false;
                    }
                }
                $validSteps[$key01] = $validStep;
            }
        }

        $valid = true;

        foreach ($validSteps as $step) {
            if (isset($step['valid'])) {
                if ($step['id'] == $step['depends_on'] || $step['valid'] == false) {
                    $valid = false;
                    break;
                }
            } else {
                $valid = true;
            }
        }

        $response['success'] = true;
        $response['data'] = ['valid' => $valid];

        return response()->json($response);
    }
}
