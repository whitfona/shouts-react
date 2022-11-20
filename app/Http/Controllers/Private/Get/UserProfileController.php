<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\User;
use Illuminate\Routing\Controller;

class UserProfileController extends Controller
{
    /**
     * Get user profile information
     *
     */
    public function __invoke()
    {
        $user = User::find(auth()->user()->id);

        return response()->json($user);
    }
}
