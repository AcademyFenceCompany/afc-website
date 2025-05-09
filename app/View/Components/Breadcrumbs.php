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
        $currentUrl = '';
        
        // Special handling for wwf-product route to show weldedwire/coating/meshSize structure
        if (count($segments) > 0 && $segments[0] === 'wwf-product') {
            $coating = request()->input('coating');
            $meshSize = request()->input('meshSize');
            
            // Create weldedwire breadcrumb
            $breadcrumbs[] = [
                'name' => 'Welded Wire',
                'url' => url('/weldedwire'),
            ];
            
            // Create coating breadcrumb if available
            if ($coating) {
                $formattedCoating = ucwords(strtolower(urldecode($coating)));
                $breadcrumbs[] = [
                    'name' => $formattedCoating,
                    'url' => url('/weldedwire/' . $coating),
                ];
            }
            
            // Create mesh size breadcrumb if available
            if ($meshSize) {
                $formattedMeshSize = urldecode($meshSize);
                $breadcrumbs[] = [
                    'name' => $formattedMeshSize,
                    'url' => '#',
                ];
            }
            
            return $breadcrumbs;
        }

        foreach ($segments as $index => $segment) {
            $currentUrl .= '/' . $segment;
            
            // Special handling for chainlink fence routes
            if ($segment === 'chain-link-fence') {
                $name = 'Chain Link Fence';
            } elseif ($segment === 'complete' && isset($segments[$index-1]) && $segments[$index-1] === 'chain-link-fence') {
                $name = 'Complete';
            } elseif ($segment === 'package' && isset($segments[$index-1]) && $segments[$index-1] === 'chain-link-fence') {
                $name = 'Package';
            } elseif (in_array($segment, ['4ft', '5ft', '6ft']) && 
                     (isset($segments[$index-1]) && in_array($segments[$index-1], ['chain-link-fence', 'complete', 'package']))) {
                $name = $segment . ' Height';
            } elseif ($segment === 'system' && isset($segments[$index-1]) && in_array($segments[$index-1], ['4ft', '5ft', '6ft'])) {
                $name = 'System';
            } else {
                $name = ucfirst(str_replace('-', ' ', $segment));
            }
            
            $breadcrumbs[] = [
                'name' => $name,
                'url' => url($currentUrl),
            ];
        }

        return $breadcrumbs;
    }

    public function render()
    {
        return view('components.breadcrumbs');
    }
}
