<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function failedAuthorization()
    {
        throw new AuthorizationException(response()->json([
            'status' => false,
            'code' => 403,
            'data' => [],
            'msg' => 'You are not authorized to perform this action!'
        ], 403));
    }
}
