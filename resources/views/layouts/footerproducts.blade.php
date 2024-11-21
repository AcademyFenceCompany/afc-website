<!-- Product Section -->
<div class="mt-2 p-4">
    <h4 class="text-dark mb-4">SHOP FOR PRODUCT</h4>
    <div class="row g-4">
        @foreach(range(1, 4) as $product)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card product-card shadow-sm text-center p-3">
                <img src="/resources/images/woodpost.png" alt="Wood Post Caps" class="img-fluid mb-3">
                <h5 class="text-danger fw-bold">Wood Post Caps</h5>
                <a href="#" class="btn btn-danger text-white">View Product</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>