<?php

namespace App\Http\Controllers;

use App\Models\CarUsage;
use App\Rules\FreeRule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CarUsageController extends Controller
{
    public function create(Request $request)
    {
        $valid = $this->validate(
            $request,
            [
                'time_from' => 'required|date',
                'time_to' => 'required|date|after:time_from',
                'car_id' => [
                    'required',
                    'exists:cars,id',
                    new FreeRule(
                        $request->input('time_from', null),
                        $request->input('time_to', null),
                        'time_from',
                        'time_to',
                        'car_usage'
                    )
                ],
                'user_id' => [
                    'required',
                    'exists:users,id',
                    new FreeRule(
                        $request->input('time_from', null),
                        $request->input('time_to', null),
                        'time_from',
                        'time_to',
                        'car_usage'
                    )
                ],
            ]
        );

        $carUsage = CarUsage::create($valid);

        return response()->json($carUsage);
    }
}
