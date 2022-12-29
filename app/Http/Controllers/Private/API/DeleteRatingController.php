<?php

namespace App\Http\Controllers\Private\API;

use App\Models\Rating;

class DeleteRatingController
{
    public function __invoke(Rating $rating)
    {
        $ratingToDelete = Rating::findOrFail($rating->id);

        $ratingToDelete->delete();
        return response('Rating successfully deleted.', 200);
    }
}
