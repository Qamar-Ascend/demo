<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //Register 

    function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',

        ]);

        if ($validation->fails()) {
            return response()->json(['validation' => $validation->errors()->getMessages()], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json(['New user' => $user, 'Message' => "User register successfully!"], 200);
    }
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function facebookCallBack()
    {
        try {
            $google_user = Socialite::drive("facebook")->user();
            // $user = User::where("google_id", $google_user->getId())->first();
            // if (!$user) {
            //     $new_user = User::create(
            //         [
            //             "name" => $google_user->getName(),
            //             "email" => $google_user->getEmail(),
            //             "google_id" => $google_user->getId(),
            //         ]
            //     );
            //     dd($new_user);
            // } else {
            //     dd($user);
            // }
            dd($google_user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function redirectToProvider()
    {
        // return Socialite::driver('google')->redirect();
        return Socialite::driver('google')->setScopes(['openid', 'email'])->redirect();
    }
    public function googleCallBack(Request $request)
    {
        // dd($request->all());
        try {
            $google_user = Socialite::driver("google")->user();
            $user = User::where("email", $google_user->getEmail())->first();
            if (!$user) {
                $new_user = User::create(
                    [
                        "name" => $google_user->getName(),
                        "email" => $google_user->getEmail(),
                        "google_id" => $google_user->getId(),
                    ]
                );
                $token = $new_user->createToken('PassportAuth')->accessToken;
                return redirect('http://localhost:5173/' . "token" . $token); // with token

            } else {
                $token = $user->createToken('PassportAuth')->accessToken;
                return redirect('http://localhost:5173/' . "token" . $token); // with token

            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
