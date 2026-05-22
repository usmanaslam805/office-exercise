<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise13Controller extends Controller
{
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|array',

            'input.guest' => 'present|array',
            'input.guest.*.id' => 'required|integer|numeric:strict|distinct|min:1',
            'input.guest.*.qty' => 'required|integer|numeric:strict|min:1',

            'input.user' => 'present|array',
            'input.user.*.id' => 'required|integer|numeric:strict|distinct|min:1',
            'input.user.*.qty' => 'required|integer|numeric:strict|min:1',
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
        $guestData = $input['guest'];
        $userData = $input['user'];

        $outputArray = [];
        $mergedArray = array_merge($guestData, $userData);

        $pluckedIds = collect($mergedArray)->pluck('id')->toArray();

        foreach ($pluckedIds as $key => $id) {
            $tempQuantity = 0;
            foreach ($mergedArray as $data) {
                if ($data['id'] == $id) {
                    $tempQuantity += $data['qty'];
                }
            }

            $tempIds = collect($outputArray)->pluck('id')->toArray();

            if (!in_array($id, $tempIds)) {
                $outputArray[$key] = ['id' => $id, 'qty' => $tempQuantity];
            }
        }

        $finalOutputArray = [];
        $count = 0;

        foreach ($outputArray as  $value) {
            $finalOutputArray[$count] = [
                'id' => $value['id'],
                'qty' => $value['qty']
            ];

            $count++;
        }

        $response['success'] = true;
        $response['data'] = $finalOutputArray;

        return response()->json($response);
    }
}
