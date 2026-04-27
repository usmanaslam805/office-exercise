<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise01Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.*.id' => 'required|integer',
            'input.*.approved' => 'required|boolean',
            'input.*.rejected' => 'required|boolean',
            'input.*.time' => 'required|integer',
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
            $inputs = collect($request->input);

            $data = $inputs->where('approved', true)
                ->where('rejected', false)
                ->sortByDesc(['time', 'id'])
                ->first();

            if ($data) {
                $response['success'] = true;
                $response['data'] = ['id' => $data['id']];
            } else {
                $response['message'] = 'Not a single data valid for production';
            }
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
        }

        return response()->json($response);
    }
}
