<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    private $token_arg = "dalali_app_token";

    public function login(Request $request)
    {
        $clean_data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::where("email", $clean_data['email'])->first();

        if (!$user) return response([
            "message" => "Invalid credentials",
        ]);

        $pass_match = Hash::check($clean_data['password'], $user->password);


        if (!$pass_match) return response([
            "message" => "Invalid credentials",
        ]);

        $response = [
            "user" => $user,
            "token" => $user->createToken($this->token_arg)->plainTextToken
        ];

        return response($response);

        // return $request->all();
    }

    public function register(Request $request)
    {
        $clean_data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $clean_data["password"] = Hash::make($clean_data["password"]);

        $user = new User($clean_data);
        $user->save();

        $token = $user->createToken($this->token_arg)->plainTextToken;
        $response = [
            "user" => $user,
            "token" => $token
        ];
        return response($response);
    }

    public function logout()
    {
        return auth()->user()->tokens()->delete();
    }
}
