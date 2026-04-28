<?php

namespace App\Http\Controllers\Exercise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise02Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',
            'input.quantity' => 'required|integer',
            'input.tiers' => 'required|array',
            'input.tiers.*.min' => 'required|integer|distinct',
            'input.tiers.*.price' => 'required|integer',
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
            $input = $request['input'];

            $quantity = $input['quantity'];
            $selectedTier = null;

            $sortedTiers = collect($input['tiers'])->sortByDesc('min')->reverse()->toArray();

            foreach ($sortedTiers as  $tier) {
                if ($tier['min'] <= $quantity) {
                    $selectedTier = $tier;
                }
            }

            if ($selectedTier == null) {
                $response['message'] = "Not a single tier is a valid tier";
            } else {
                $response['success'] = true;
                $response['data'] = ['price' => $selectedTier['price']];
            }
        } catch (\Throwable $th) {
            $response['message'] = $th->getMessage();
        }

        return response()->json($response);
    }
}
