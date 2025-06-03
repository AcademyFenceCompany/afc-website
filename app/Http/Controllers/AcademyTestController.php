<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart; // Assuming you have a ShoppingCart model

class AcademyTestController extends Controller
{
    private function getDatabaseConnection()
    {
        try {
            \DB::connection()->getPdo();
            if (\DB::connection()->getDatabaseName()) {
                echo "Connected to database: " . \DB::connection()->getDatabaseName();
            } else {
                echo "Not connected to any database.";
            }
        } catch (\Exception $e) {
            echo "Could not connect to the database. Please check your configuration. Error: " . $e->getMessage();
        }
    }
    public function index()
    {
        
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $fenceCategories = [
            ['id' => 1, 'name' => 'Wooden Fences', 'description' => 'Durable and classic wooden fences.'],
            ['id' => 2, 'name' => 'Vinyl Fences', 'description' => 'Low-maintenance and long-lasting vinyl fences.'],
            ['id' => 3, 'name' => 'Chain Link Fences', 'description' => 'Affordable and secure chain link fences.'],
            ['id' => 4, 'name' => 'Wrought Iron Fences', 'description' => 'Elegant and sturdy wrought iron fences.'],
            ['id' => 5, 'name' => 'Bamboo Fences', 'description' => 'Eco-friendly and stylish bamboo fences.'],
            ['id' => 6, 'name' => 'Aluminum Fences', 'description' => 'Lightweight and rust-resistant aluminum fences.'],
            ['id' => 7, 'name' => 'Composite Fences', 'description' => 'Sustainable and attractive composite fences.'],
            ['id' => 8, 'name' => 'Electric Fences', 'description' => 'High-security electric fences for protection.'],
            ['id' => 9, 'name' => 'Privacy Fences', 'description' => 'Tall and solid privacy fences for seclusion.'],
            ['id' => 10, 'name' => 'Garden Fences', 'description' => 'Decorative garden fences for landscaping.'],

        ];
        $shoppingCart = new ShoppingCart();
        $cart = $shoppingCart->getCart();
        return view('academy', compact('majCategories', 'subCategories', 'fenceCategories', 'cart'));
    }
    public function height($h)
    {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $height = $h;
        return view('academy', compact('majCategories', 'subCategories', 'height'));
    }
    public function category()
    {
        
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        $fenceCategories = [
            ['id' => 1, 'name' => 'Wooden Fences', 'description' => 'Durable and classic wooden fences.'],
            ['id' => 2, 'name' => 'Vinyl Fences', 'description' => 'Low-maintenance and long-lasting vinyl fences.'],
            ['id' => 3, 'name' => 'Chain Link Fences', 'description' => 'Affordable and secure chain link fences.'],
            ['id' => 4, 'name' => 'Wrought Iron Fences', 'description' => 'Elegant and sturdy wrought iron fences.'],
            ['id' => 5, 'name' => 'Bamboo Fences', 'description' => 'Eco-friendly and stylish bamboo fences.'],
            ['id' => 6, 'name' => 'Aluminum Fences', 'description' => 'Lightweight and rust-resistant aluminum fences.'],
            ['id' => 7, 'name' => 'Composite Fences', 'description' => 'Sustainable and attractive composite fences.'],
            ['id' => 8, 'name' => 'Electric Fences', 'description' => 'High-security electric fences for protection.'],
            ['id' => 9, 'name' => 'Privacy Fences', 'description' => 'Tall and solid privacy fences for seclusion.'],
            ['id' => 10, 'name' => 'Garden Fences', 'description' => 'Decorative garden fences for landscaping.'],

        ];
        return view('academy', compact('majCategories', 'subCategories', 'fenceCategories'));
    }
}