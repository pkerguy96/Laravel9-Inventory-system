<?php

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

if (!function_exists('verifySupplierIce')) {

    function verifySupplierIce(Request $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ];
        }

        return [
            'status' => 'success'
        ];
    }
}
