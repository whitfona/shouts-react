<?php

namespace App\Http\Controllers\Public\Get;

use App\Models\Category;
use Illuminate\Routing\Controller;

class AllCategoriesController extends Controller
{
    /**
     * Get all categories
     *
     */
    public function __invoke()
    {
        $categories = Category::all();

        return response()->json($categories);
    }
}
