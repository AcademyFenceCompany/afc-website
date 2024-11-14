<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = $this->generateBreadcrumbs();
    }

    private function generateBreadcrumbs()
    {
        $breadcrumbs = [];
        $segments = request()->segments();

        foreach ($segments as $index => $segment) {
            $breadcrumbs[] = [
                'name' => ucfirst(str_replace('-', ' ', $segment)),
                'url' => url(implode('/', array_slice($segments, 0, $index + 1))),
            ];
        }

        return $breadcrumbs;
    }

    public function render()
    {
        return view('components.breadcrumbs');
    }
}
