@props([
    'styleGroups',
    'category'
])

@php
    // Define the preferred order for styles
    $styleOrder = ['Straight On Top', 'Concave', 'Convex'];
    
    // Define the specialty order for Board On Board
    $specialityOrderMap = [
        'Straight On Top' => ['Slant Ear', 'Gothic Point', 'French Gothic'],
        'Concave' => ['Flat Picket', 'Gothic Point', 'French Gothic'],
        'Convex' => ['Flat Picket', 'Gothic Point', 'French Gothic']
    ];
    
    $isSpacedPicket = false;
    $isBoardOnBoard = true;
    
    // Product ID mapping for Board On Board category
    $productIdMap = [
        'Straight On Top' => [
            'Slant Ear' => 'product/3028',
            'Gothic Point' => 'product/3150',
            'French Gothic' => 'product/3220'
        ],
        'Concave' => [
            'Flat Picket' => 'product/3118',
            'Gothic Point' => 'product/3167',
            'French Gothic' => 'product/3236'
        ],
        'Convex' => [
            'Flat Picket' => 'product/3135',
            'Gothic Point' => 'product/3176',
            'French Gothic' => 'product/3253'
        ]
    ];
@endphp

<h3 class="text-center mt-4 mb-4">Wood Fence Specifications - Board On Board</h3>

@foreach ($styleOrder as $styleName)
    @php
        // Find the style group if it exists
        $styleGroup = null;
        foreach ($styleGroups as $group) {
            if ($group['style'] === $styleName) {
                $styleGroup = $group;
                break;
            }
        }
        
        // Skip if style doesn't exist
        if (!$styleGroup) continue;
        
        // Filter out Dog Ear, Flat Top, Knob Top, and Solid Top specialities
        $filteredProducts = $styleGroup['combos']->filter(function($product) use ($styleGroup) {
            // Base filtering for all styles
            $baseFilter = !in_array($product['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top', 'Solid Top']) && 
                          isset($product['web_enabled']) && $product['web_enabled'] == 1;
            
            // Style-specific filtering
            if ($styleGroup['style'] === 'Straight On Top') {
                // For Straight On Top, hide Flat Picket
                return $baseFilter && $product['speciality'] !== 'Flat Picket';
            } elseif (in_array($styleGroup['style'], ['Concave', 'Convex'])) {
                // For Concave and Convex, hide Slant Ear
                return $baseFilter && $product['speciality'] !== 'Slant Ear';
            }
            
            return $baseFilter;
        });
        
        // Group filtered products by speciality
        $filteredProductsBySpeciality = [];
        foreach ($filteredProducts as $product) {
            $speciality = $product['speciality'] ?? 'Standard';
            if (!isset($filteredProductsBySpeciality[$speciality])) {
                $filteredProductsBySpeciality[$speciality] = [];
            }
            $filteredProductsBySpeciality[$speciality][] = $product;
        }
        
        // Order specialities according to the preferred order
        $orderedFilteredProductsBySpeciality = [];
        if (isset($specialityOrderMap[$styleGroup['style']])) {
            foreach ($specialityOrderMap[$styleGroup['style']] as $specialityName) {
                if (isset($filteredProductsBySpeciality[$specialityName])) {
                    $orderedFilteredProductsBySpeciality[$specialityName] = $filteredProductsBySpeciality[$specialityName];
                } else {
                    // For Board On Board, we want to show all specialities even if no products exist
                    $orderedFilteredProductsBySpeciality[$specialityName] = [];
                }
            }
        }
        
        // Replace with ordered specialities
        $filteredProductsBySpeciality = $orderedFilteredProductsBySpeciality;
    @endphp
    
    <h2 class="section-title mt-5 mb-4" style="background-color: #000; color: #fff; padding: 10px; text-align: center; text-transform: uppercase;">{{ $styleGroup['style'] }}</h2>
    
    <div class="row">
        @foreach ($filteredProductsBySpeciality as $specialityName => $products)
            <div class="col-md-4 mb-4">
                <x-woodfence.specialty-card 
                    :styleGroup="$styleGroup" 
                    :specialityName="$specialityName" 
                    :products="$products" 
                    :isBoardOnBoard="$isBoardOnBoard"
                    :productIdMap="$productIdMap"
                />
            </div>
        @endforeach
    </div>
@endforeach
