<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserService
{

    public static function get()
    {
        $Surveys = User::get();
        return response()->json(['data' => $Surveys], 200);
    }
}
