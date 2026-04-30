<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise03Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.*.id' => 'required|integer|distinct',
            'input.*.required' => 'required|boolean',
            'input.*.done' => 'required|boolean',
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

        try {
            $inputs = $request->input;

            $invalidItemIds = [];
            $index = 0;

            foreach ($inputs as $value) {
                if ($value['required'] == true && $value['done'] == false) {
                    $invalidItemIds[$index] = $value['id'];
                    $index++;
                }
            }

            if ($invalidItemIds == []) {
                $response['message'] = "All inputs are valid";
                $response['data']['valid'] = true;
            }else{
                $response['data']['valid'] = false;
            }
            $response['data']['invalid_items'] = $invalidItemIds;
            $response['success'] = true;
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
        }

        return response()->json($response);
    }
}
