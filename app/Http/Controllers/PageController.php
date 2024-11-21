<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class PageController extends BaseController
{
    public function showPage($pageName)
    {
        $pages = [
            'about' => ['title' => 'About Us', 'header' => 'About Us'],
            'policies' => ['title' => 'Policies, Terms & Conditions', 'header' => 'Policies & Terms'],
            'contact' => ['title' => 'Contact Us', 'header' => 'Contact Us'],
        ];

        // Check if the page exists, otherwise set a default
        $pageData = $pages[$pageName] ?? ['title' => 'Page Not Found', 'header' => 'Page Not Found'];

        return view('page-template', $pageData);
    }
}
