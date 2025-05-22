@for ($i = 0; $i < $height; $i++)
    <div class="col-4 mb-4">
        <div class="card system-complete-card">
            <img src="{{ asset('assets/images/defaultfenceSG.png') }}" class="card-img-top py-3" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title"><strong>System 1</strong></h5>
                <p class="card-desc">Our complete fence systems include all necessary hardware for your fence installation.</p>
                <p class="card-text p-1 m-0"><strong>Frame:</strong> Galvanized</p>
                <p class="card-text p-1 m-0"><strong>Wire:</strong> Galvanized</p>
                <p class="card-text p-1 m-0"><strong>Mesh Size:</strong> 2 x 2</p>
                <p class="card-text p-1 m-0"><strong>Gauge:</strong> 9</p>
            </div>
            <div class="card-footer d-flex justify-content-between bg-light gap-3">
                <button class="btn btn-primary flex-fill">Add To Cart</button>
                <button class="btn btn-secondary flex-fill">Customize</button>
            </div>
        </div>
    </div>
@endfor