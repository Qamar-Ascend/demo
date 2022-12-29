<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //GET ALL USER 
    function get()
    {
        return UserService::get();
    }
}
