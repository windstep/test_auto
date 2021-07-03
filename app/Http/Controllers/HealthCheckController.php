<?php

namespace App\Http\Controllers;

class HealthCheckController extends Controller
{
    public function healthcheck()
    {
        return response()->json(['status' => true, 'message' => 'ok']);
    }
}
