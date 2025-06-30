<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandardPagesController extends Controller
{
    //
    public function woodfence()
    {
        $majCategories = DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = DB::table('categories')->where('majorcategories_id', 1)->get();
        return view('standard-pages.woodfence', compact('majCategories', 'subCategories'));
    }
}
