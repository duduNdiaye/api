<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function inscription(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed']
        ]);

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password'])
        ]);

        return response($user, 201);
    }

    public function connexion(Request $request)
    {
        $userData = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:30']
        ]);

        $user = User::where("email", $userData['email'])->first();
        if (!$user) {
            return response(["message" => "User not found"], 404);
        }
        if (!Hash::check($userData['password'], $user->password)) {
            return response(["message" => "User not found"], 404);
        }
        $token = $user->createToken("CLE_SECRETE")->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,
            'message' => 'Authentification réussie'
        ], 200);
    }

    public function deconnexion(Request $request)
    {
        if (!$request->user()) {
            return response(['message' => 'User not authenticated.'], 401);
        }

        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'User logged out.'], 200);
    }
}
