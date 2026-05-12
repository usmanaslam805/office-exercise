<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise09Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.*.id' => 'required|string',
            'input.*.time' => 'required|integer|numeric:strict',
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

        $input = collect($request['input']);
        $data = [];
        
        foreach ($input->pluck('id')->unique()->toArray() as $value) {
            array_push($data, $value);
        }

        $response['success'] = true;
        $response['data'] = $data;

        return response()->json($response);
    }
}
