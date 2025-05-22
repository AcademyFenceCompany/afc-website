<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostCapsController extends Controller
{
    public function index(Request $request, $style = null)
    {
        // Category ID for Post and Rail
        $categoryId = 161;
        
        // Fetch products from the database
        $query = DB::connection('academyfence')
            ->table('productsqry')
            ->where('categories_id', $categoryId)
            ->where('enabled', 1);
    }
}