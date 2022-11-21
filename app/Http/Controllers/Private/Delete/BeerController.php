<?php

namespace App\Http\Controllers\Private\Delete;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BeerController extends Controller
{
    /**
     * DELETE a beer for the authenticated user
     *
     */
    public function __invoke(Request $request)
    {
        $rating = Rating::where('beer_id', $request->beer_id)->where('user_id', auth()->user()->id)->first();
        $rating->delete();

        return redirect(route('dashboard'))->with('message', 'Bevvie successfully deleted.');
    }
}
