<?php

namespace App\Http\Controllers\Private\Delete;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param User $user
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(User $user)
    {
        $foundUser = User::find($user->id);
        $foundUser?->delete();

        return response('User successfully deleted.', 200);
    }

}
