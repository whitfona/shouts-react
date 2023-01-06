<?php

namespace App\Http\Controllers\Private\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Register User using the API
     * @param Request $request - Name, Email, Password & Password Confirmation of registering user
     * @return array - User with token
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'profile_image' => 'zzzno-profile-image.png',
        ]);

        $token = $user->createToken($request->email);

        return ['user' => $user, 'token' => $token->plainTextToken];
    }
}
