<?php

namespace App\Http\Controllers\Private\API;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordUpdateController
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'max:255'],
            'new_password' => ['required', 'string', 'max:255'],
            'confirm_password' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find($request->user()->id);

        if (! $user || ! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => ['The provided password is incorrect.'],
            ]);
        }

        if ($request->new_password !== $request->confirm_password) {
            throw ValidationException::withMessages([
                'confirmPassword' => ['The confirm password does not match the new password.'],
            ]);
        }

        $user->password = Hash::make($request->new_password);

        $user->save();

        return response('Password successfully updated.', 200);
    }
}
