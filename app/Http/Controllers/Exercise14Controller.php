<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise14Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.nums' => 'present|array',
            'input.nums.*' => 'integer|numeric:strict|min:1',

            'input.target' => 'integer|numeric:strict|min:0',
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
        $target = $input['target'];
        $numbersArray = $input['nums'];
        $outputArray = [];

        foreach ($numbersArray as $key => $value) {
            if ($value + $numbersArray[$key + 1] == $target) {
                $outputArray = [$key, $key + 1];
                break;
            }
        }

        if (!isset($outputArray[0])) {
            foreach ($numbersArray as $key01 => $value01) {
                foreach ($numbersArray as $key02 => $value02) {
                    if (($value01 + $value02) == $target) {
                        $outputArray = [$key01, $key02];
                        break;
                    }
                }
                if (isset($outputArray[0])) {
                    break;
                }
            }
        }

        $response['success'] = true;
        $response['data'] = $outputArray;

        return response()->json($response);
    }
}
