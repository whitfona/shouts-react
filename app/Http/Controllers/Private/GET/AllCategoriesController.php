<?php

namespace App\Http\Controllers\Private\GET;

use App\Models\Category;
use Illuminate\Routing\Controller;

class AllCategoriesController extends Controller
{
    /**
     * GET all categories
     *
     */
    public function __invoke()
    {
        $categories = Category::all();

        return response()->json($categories);
    }
}
