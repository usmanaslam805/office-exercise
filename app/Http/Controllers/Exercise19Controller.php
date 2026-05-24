<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise19Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.options' => 'present|array',
            'input.options.*.name' => 'required|string',
            'input.options.*.values' => 'required|integer|numeric:strict|min:0',

            'input.limit' => 'required|integer|numeric:strict|min:0',
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
        $options = $input['options'];
        $limit = $input['limit'];
        $totalCombinations = [];

        $totalCombinations = 1;

        foreach ($options as $option) {
            $totalCombinations *= $option['values'];
        }

        $isExceeded = $totalCombinations > $limit;

        $response['success'] = true;
        $response['data'] = [
            'combinations' => $totalCombinations,
            'limit_exceeded' => $isExceeded,
        ];

        return response()->json($response);
    }
}
