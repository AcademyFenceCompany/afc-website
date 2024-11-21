@extends('layouts.main')
@include('layouts.aboutHeader')

<!-- Brochures Grid -->
<div class="row g-4 text-center mb-5">
    @foreach([
        ['title' => 'General Products', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/general-products.pdf'],
            ['title' => 'Wood Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/wood-fence.pdf'],
            ['title' => 'Ornamental Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/ornamental-fence.pdf'],
            ['title' => 'Ornamental Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/ornamental-fence.pdf'],
            ['title' => 'Ornamental Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/ornamental-fence.pdf'],
            ['title' => 'Ornamental Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/ornamental-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf'],
            ['title' => 'Chain Link Fence', 'image' => '/resources/images/brochure.png', 'url' => '/brochures/chainlink-fence.pdf']



    ] as $brochure)
    <div class="col-md-6 col-lg-3">
        <div class="card text-center shadow-sm border-0" style="background-color: #f9f9f9; border-radius: 10px;">
            <div class="card-body">
                <img src="{{ $brochure['image'] }}" alt="{{ $brochure['title'] }}" class="img-fluid mb-3" style="max-height: 100px;">
                <h5 class="card-title fw-bold" style="color: var(--secondary-color);">{{ $brochure['title'] }}</h5>
                <a href="{{ $brochure['url'] }}" class="btn mt-3" style="background-color: var(--secondary-color); color: #fff; border-radius: 5px;">
                    View / Print
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('layouts.footerproducts')
</main>
@endsection