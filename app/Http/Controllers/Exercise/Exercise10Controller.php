<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise10Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.created_at' => 'required|string|regex:/^\d{4}-\d{2}-\d{2}$/',
            'input.valid_days' => 'required|integer|numeric:strict|min:1',
            'input.current_date' => 'required|string|regex:/^\d{4}-\d{2}-\d{2}$/',
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

        $currentDate = Carbon::parse($input['current_date']);
        $createdAt = Carbon::parse($input['created_at']);

        if ($currentDate < $createdAt) {
            $response['message'] = "Date correction error";
            $response['error'] = "Created date must not be greater than current data";

            return response()->json($response);
        }

        $days = Carbon::parse($createdAt)->diffInDays($currentDate);
        $valid = false;

        if ($days >= $input['valid_days']) {
            $valid = true;
        }

        $response['success'] = true;
        $response['data'] = ['valid' => $valid];

        return response()->json($response);
    }
}
