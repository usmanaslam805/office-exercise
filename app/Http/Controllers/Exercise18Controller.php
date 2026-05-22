<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise18Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.shopify' => 'present|array',
            'input.shopify.price' => 'required|integer|numeric:strict|min:0',
            'input.shopify.updated_at' => 'required|integer|numeric:strict|min:1',

            'input.internal' => 'present|array',
            'input.internal.price' => 'required|integer|numeric:strict|min:0',
            'input.internal.updated_at' => 'required|integer|numeric:strict|min:1',
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
        $internal = $input['internal'];
        $shopify = $input['shopify'];
        $value = 0;

        if ($internal['updated_at'] > $shopify['updated_at']) {
            $value = $internal['price'];
        } else {
            $value = $shopify['price'];
        }

        $response['success'] = true;
        $response['data'] = ['value' => $value];

        return response()->json($response);
    }
}
