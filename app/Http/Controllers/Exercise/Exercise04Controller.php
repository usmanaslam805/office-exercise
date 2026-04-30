<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise04Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.order_qty' => 'required|integer|min:1',
            'input.vendors' => 'required|array',
            'input.vendors.*.id' => 'required|integer|distinct',
            'input.vendors.*.stock' => 'required|integer',
        ], [
            'input.order_qty.min' => "The required quantity must be greater than 0",
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
            $input = $request->input;
            $requiredQuantity = $input['order_qty'];
            $vendors = $input['vendors'];

            $allocatedQuantity = 0;
            $allocatedToAllVendors = [];

            foreach ($vendors as $key => $vendor) {
                $quantityAllocatedToVendor = 0;
                $allocatedToAllVendors[$key] = ['vendor_id' => $vendor['id'], 'allocated' => $quantityAllocatedToVendor];

                for ($i = 0; $i < $vendor['stock']; $i++) {
                    if ($allocatedQuantity < $requiredQuantity) {
                        $allocatedQuantity++;
                        $quantityAllocatedToVendor++;
                    }

                    $allocatedToAllVendors[$key]['allocated'] = $quantityAllocatedToVendor;
                }
            }

            if ($allocatedQuantity < $requiredQuantity) {
                $response['success'] = false;
                $response['message'] = "Order cannot be placed as required quantity cannot be full filled form vendors";
            } else {
                $response['success'] = true;
                $response['data'] = $allocatedToAllVendors;
            }
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
        }

        return response()->json($response);
    }
}
