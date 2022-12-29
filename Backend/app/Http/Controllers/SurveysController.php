<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;
use Illuminate\Http\Request;

class SurveysController extends Controller
{
    //STORE
    function store(Request $request)
    {
        return SurveyService::create($request);
    }

    //GET ALL 

    function get(Request $request)
    {
        return SurveyService::getAll($request);
    }
}
