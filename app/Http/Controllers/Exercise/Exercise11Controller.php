<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise11Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.customer' => 'required|array',
            'input.customer.tags' => 'required|array',
            'input.customer.tags.*' => 'required|string',

            'input.products' => 'required|array',
            'input.products.*.id' => 'required|integer|numeric:strict|distinct',
            'input.products.*.allow' => 'present|array',
            'input.products.*.block' => 'present|array',
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
        $customersTags = $input['customer']['tags'];
        $products = $input['products'];

        $outputArray = [];

        foreach ($customersTags as $customersTag) {
            $tempCount = 0;

            foreach ($products as $product) {
                if (in_array($customersTag, $product['allow']) && in_array($customersTag, $product['block'])) {
                    $response['message'] = "Logic error";
                    $response['error'] = "A customer cannot be allowed and blocked for a product at the same time";

                    return response()->json($response);
                } else if (in_array($customersTag, $product['allow'])) {
                    $outputArray[$customersTag][$tempCount] = $product['id'];
                    $tempCount++;
                }
            }
        }

        $response['success'] = true;
        $response['data'] = $outputArray;

        return response()->json($response);
    }
}
