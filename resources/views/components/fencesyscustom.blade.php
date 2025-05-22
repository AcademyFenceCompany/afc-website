<section>
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <h2>Academy Fences: 5 Chainlink Systems</h2>
                <p>Build your perfect fence, start by choosing your color and mesh size to meet your needs.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <x-sidebar-filter />
            </div>
            <div class="col-9">
                <div class="row" id="product-list">
                    <div class="col-4">
                        <div class="card system-complete-card">
                            <img src="{{ asset('assets/images/defaultfenceSG.png') }}" class="card-img-top py-3" alt="Product Image">
                            <div class="card-body">
                                @include('partials.product-desc-hover')
                                <h5 class="card-title"><strong>Academy System 1</strong></h5>
                                <p class="card-desc">Our complete fence systems include all necessary hardware for your fence installation.</p>
                                <p class="card-text p-1 m-0"><strong>Frame:</strong> Galvanized</p>
                                <p class="card-text p-1 m-0"><strong>Wire:</strong> Galvanized</p>
                                <p class="card-text p-1 m-0"><strong>Mesh Size:</strong> 2 x 2</p>
                                <p class="card-text p-1 m-0"><strong>Gauge:</strong> 9</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light gap-3">
                                <button class="btn btn-primary flex-fill d-none">Add To Cart</button>
                                <button class="btn btn-secondary flex-fill">Customize</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card system-complete-card">
                            <img src="{{ asset('assets/images/defaultfenceDG.png') }}" class="card-img-top py-3" alt="Product Image">
                            <div class="card-body">
                                @include('partials.product-desc-hover')
                                <h5 class="card-title"><strong>Academy System 2</strong></h5>
                                <p class="card-desc">Our complete fence systems include all necessary hardware for your fence installation.</p>
                                <p class="card-text p-1 m-0"><strong>Frame:</strong> Galvanized</p>
                                <p class="card-text p-1 m-0"><strong>Wire:</strong> Vinyl</p>
                                <p class="card-text p-1 m-0"><strong>Mesh Size:</strong> 2 x 2</p>
                                <p class="card-text p-1 m-0"><strong>Gauge:</strong> 9</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light gap-3">
                                <button class="btn btn-primary flex-fill d-none">Add To Cart</button>
                                <button class="btn btn-secondary flex-fill">Customize</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card system-complete-card">
                            <img src="{{ asset('assets/images/defaultfenceSG.png') }}" class="card-img-top py-3" alt="Product Image">
                            <div class="card-body">
                                @include('partials.product-desc-hover')
                                <h5 class="card-title"><strong>Academy System 3</strong></h5>
                                <p class="card-desc">Our complete fence systems include all necessary hardware for your fence installation.</p>
                                <p class="card-text p-1 m-0"><strong>Frame:</strong> Vinyl</p>
                                <p class="card-text p-1 m-0"><strong>Wire:</strong> Vinyl</p>
                                <p class="card-text p-1 m-0"><strong>Mesh Size:</strong> 2 x 2</p>
                                <p class="card-text p-1 m-0"><strong>Gauge:</strong> 9</p>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light gap-3">
                                <button class="btn btn-primary flex-fill">Add To Cart</button>
                                <button class="btn btn-secondary flex-fill d-none">Customize</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>