<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvalidEndpointController extends Controller
{
    public function index()
    {
        return response()->json([
            'status'  => false,
            'code' => 404,
            'data' => [],
            'msg' => 'Invalid api end point.'
        ]);
    }
}
