<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
    /**
     * Display a listing of the filtered products.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Example: Retrieve filters from the request
        return view('filter/products', [
            'filters' => "hello world"
        ]);
    }
    public function height($h)
    {
        // Example: Retrieve filters from the request
        return view('filter/products', [
            'filters' => "hello world",
            'height' => $h
        ]);
    }
}