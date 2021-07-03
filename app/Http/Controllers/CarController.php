<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CarController
{
    public function get()
    {
        return response()->json(['data' => Car::all()]);
    }
}
