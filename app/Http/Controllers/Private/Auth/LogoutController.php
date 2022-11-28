<?php

namespace App\Http\Controllers\Private\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LogoutController extends Controller
{
    /**
     * Logout User and remove Token
     * @param Request $request - User to log out
     * @return Response - User with token
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['You successfully logged out'], 201);
    }
}
