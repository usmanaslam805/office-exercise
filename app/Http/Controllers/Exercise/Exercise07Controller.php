<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise07Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.stock' => 'required|integer',
            'input.requests' => 'required|array',
            'input.requests.*' => 'required|integer|min:1',
        ]);

        $response = [
            'success' => false,
            'error' => null
        ];

        if ($validator->fails()) {
            $response['message'] = "Validation error";
            $response['error'] = $validator->messages()->all();

            return response()->json($response);
        }

        $input = $request['input'];
        $stock = $input['stock'];
        $inputRequests = $input['requests'];
        $output = [];

        try {
            $remainingStocks = $stock;

            foreach ($inputRequests as $key => $inputRequest) {
                $remainingStocks =  $remainingStocks - $inputRequest;

                if ($remainingStocks >= 0) {
                    $output[$key] = true;
                } else {
                $remainingStocks =  $remainingStocks + $inputRequest;
                $output[$key] = false;
                }
            }

            $response['success'] = true;
            $response['data'] = $output;
        } catch (\Throwable $th) {
            $response['success'] = false;
            $response['error'] = $th->getMessage();
        }

        return response()->json($response);
    }
}
