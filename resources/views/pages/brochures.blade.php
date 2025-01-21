@extends('layouts.main')
@include('layouts.aboutHeader')

<!-- Brochures Grid -->
<div class="d-flex flex-wrap justify-content-center mb-5" style="gap: 20px;">
    @foreach ([
        ['title' => 'General Products', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/general_print_catalogue.pdf'],
        ['title' => 'Wood Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/wood_fencing_print_catalogue.pdf'],
        ['title' => 'Ornamental Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/ornamental_fence_print_catalogue.pdf'],
        ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/chainlink_print_catalogue.pdf'],
        ['title' => 'Industrial Division', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/industrial_print_catalogue.pdf'],
        ['title' => 'Welded Wire', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/vinyl_coated_welded_wire_catalogue.pdf'],
        ['title' => 'Dog Run Kennels', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/dog_run_catalogue.pdf'],
        ['title' => 'Fence Inserts', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/fence_inserts_print_catalogue.pdf'],
        ['title' => 'Hand Rail Fittings', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/hand_rail_fittings_print_catalogue.pdf'],
        ['title' => 'Privacy Screening', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/portable_screening_print_catalogue.pdf'],
        ['title' => 'Razor Wire', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/razor_wire_catalogue.pdf'],
        ['title' => 'Aluminum Railing', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/alluminumrailings.pdf'],
        ['title' => 'Solar Post Caps', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/solar_post_cap.pdf'],
        ['title' => 'Vinyl Post Caps', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/vinyl_post_caps.pdf'],
        ['title' => 'Wood Post Caps', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/wood_post_caps.pdf'],
        ['title' => 'Fence Tools', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/fence_tools.pdf'],
        ['title' => 'Blank Vinyl Posts', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/blank_vinyl_post_catalogue.pdf'],
        ['title' => 'Temporary Construction Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/Temp Construction Fence.pdf'],
        ['title' => 'Custom Wood Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/Academy_Fence_Guide_to_Custom_Wood_Fence.pdf'],
        ['title' => 'Deer Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/academy_deer_fence.pdf'],
        ['title' => 'Hex Netting', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/black_hex_netting.pdf'],
        ['title' => 'Vinyl Fence', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/Academy PVC.pdf'],
        ['title' => 'Wholesale', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/ACADEMY FLYER wholesale contractor.pdf'],
        ['title' => 'Welded Wire General', 'image' => '/resources/images/brochure.png', 'url' => 'resources/brochures/WW_General.pdf'],
    ] as $brochure)
        <div class="flex-item"
            style="flex: 0 1 calc(20% - 20px); background-color: #f9f9f9; border-radius: 10px; padding: 15px; text-align: center; box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);">
            <img src="{{ $brochure['image'] }}" alt="{{ $brochure['title'] }}" class="img-fluid mb-3"
                style="max-height: 100px;">
            <h5 class="fw-bold" style="color: var(--secondary-color); font-size: 15px;">{{ $brochure['title'] }}</h5>
            <a href="{{ $brochure['url'] }}" target="_blank" class="btn mt-3"
                style="background-color: var(--secondary-color); color: #fff; border-radius: 5px;">
                View / Print
            </a>

        </div>
    @endforeach
</div>

@include('layouts.footerproducts')
</main>
@endsection
