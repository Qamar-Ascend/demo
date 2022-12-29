<?php

namespace App\Services;

use App\Models\Surveys;
use Illuminate\Support\Facades\Validator;

class SurveyService
{
    public static function getAll()
    {
        $Surveys = Surveys::get();
        return response()->json(['data' => $Surveys], 200);
    }
    public static function find($id)
    {
        $Surveys = Surveys::where('_id', $id)->first();
        if (isset($Surveys)) {
            return response()->json(['data' => $Surveys], 200);
        } else {
            return response()->json(['data' => []], 400);
        }
    }
    public static function create($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',

        ]);
        if ($validation->fails()) {
            //
        }
        $data = [
            'name' => $request->input('name'),
        ];
        Surveys::create($data);
        return response()->json(['data' => 'Survey Successfully created'], 200);
    }
    public static function update($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',

        ]);
        if ($validation->fails()) {
            //
        }
        Surveys::where('_id', $request->id)->update([
            'name' => $request->name,
        ]);
        return response()->json(['data' => 'Surveys Successfully Updated'], 200);
    }
    public static function destroy($id)
    {
        if (Surveys::doesntExist('_id', $id)) return response()->json(['data' => 'Surveys Does Not Exist'], 400);
        Surveys::where('_id', $id)->delete();
        return response()->json(['data' => 'Surveys Successfully Deleted'], 200);
    }
}
