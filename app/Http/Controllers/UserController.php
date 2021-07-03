<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    public function get()
    {
        return response()->json(['data' => User::all()]);
    }
}
