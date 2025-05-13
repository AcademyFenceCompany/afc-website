<div class="modal-content" style="height:auto;">
    <div class="modal-header bg-primary text-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Now editing: {{$product->product_name}}</h1>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="{{ route('ams.product-report.edit') }}" method="POST" enctype="multipart/form-data" onchange="App.submitForm(this)">
    @csrf
    <div class="modal-body p-4">
        <div id="alert-container"></div>
        <div class="row">  
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">General Product Details</h5>
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" value="{{ $product->product_name }}" required>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-3">
                                    <label for="item_no" class="form-label">Item No</label>
                                    <input type="text" name="item_no" id="item_no" class="form-control" placeholder="Enter item number" value="{{ $product->item_no }}" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="in_stock" class="form-label">In Stock</label>
                                    <input type="number" name="in_stock" id="in_stock" class="form-control" placeholder="Enter stock quantity" value="{{ $product->in_stock }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="desc_short" class="form-label">Short Description</label>
                            <input type="text" name="desc_short" id="desc_short" class="form-control" placeholder="Enter short description" value="{{ $product->desc_short }}">
                        </div>
                        
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Specifications and Sizing</h5>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color</label>
                                    <input type="text" name="color" id="color" class="form-control" placeholder="Enter color" value="{{ $product->color }}">
                                </div>
                                <div class="mb-3">
                                    <label for="size2" class="form-label">Size 2</label>
                                    
                                    <select name="size2" id="size2" class="form-control">
                                        @foreach ($size2 as $ob)
                                            @if ($product->size2 == $ob)
                                                <option value="{{$product->size2}}" selected>{{$product->size2}}</option>
                                            @else
                                                <option value="{{$ob}}">{{$ob}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size</label>
                                    <input type="text" name="size" id="size" class="form-control" placeholder="Enter size" value="{{ $product->size }}">
                                </div>
                                <div class="mb-3">
                                    <label for="size3" class="form-label">Size 3</label>
                                    <input type="text" name="size3" id="size3" class="form-control" placeholder="Enter size 3" value="{{ $product->size3 }}">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group mb-3">
                            <label for="categories_id">Category</label>
                            <select name="categories_id" id="categories_id" class="form-control" required>
                                @foreach ($subCategories as $ob)
                                    @if ($product->categories_id == $ob->id)
                                        <option value="{{$ob->id}}" selected>{{$ob->cat_name}}</option>
                                    @else
                                        <option value="{{$ob->id}}">{{$ob->cat_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Product Details</h5>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" placeholder="Enter notes">{{ $product->notes }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="img_large" class="form-label">Large Image</label>
                            <input type="file" name="img_large" id="img_large" class="form-control">
                            @if($product->img_large)
                                <img src="http://192.168.0.8/storage/products/{{$product->img_large}}" class="img-thumbnail" alt="...">
                                <small>Current Image: {{ $product->img_large }}</small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="product_accessories" class="form-label">Product Accessories</label>
                            <textarea name="product_accessories" id="product_accessories" class="form-control" placeholder="Enter product accessories">{{ $product->product_accessories }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Product Details</h5>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="spacing" class="form-label">Spacing</label>
                                        <select name="spacing" id="spacing" class="form-control">
                                            @foreach ($spacing as $ob)
                                                @if ($product->spacing == $ob)
                                                    <option value="{{$product->spacing}}" selected>{{$product->spacing}}</option>
                                                @else
                                                    <option value="{{$ob}}">{{$ob}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="coating" class="form-label">Coating</label>
                                        <select name="coating" id="coating" class="form-control">
                                            @foreach ($coating as $ob)
                                                @if ($product->coating == $ob)
                                                    <option value="{{$product->coating}}" selected>{{$product->coating}}</option>
                                                @else
                                                    <option value="{{$ob}}">{{$ob}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="material" class="form-label">Material</label>
                                        <select name="material" id="material" class="form-control">
                                            @foreach ($material as $ob)
                                                @if ($product->material == $ob)
                                                    <option value="{{$product->material}}" selected>{{$product->material}}</option>
                                                @else
                                                    <option value="{{$ob}}">{{$ob}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="speciality" class="form-label">Speciality</label>
                                        <input type="text" name="speciality" id="speciality" class="form-control" placeholder="Enter speciality" value="{{ $product->speciality }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pricing Details</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" value="{{ $product->price }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="cost" class="form-label">Cost</label>
                                    <input type="number" name="cost" id="cost" class="form-control" placeholder="Enter cost" value="{{ $product->cost }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="list" class="form-label">List</label>
                                    <input type="number" name="list" id="list" class="form-control" placeholder="Enter list" value="{{ $product->list }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Shipping Details</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Length</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Enter price">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="cost" class="form-label">Width</label>
                                    <input type="number" name="cost" id="cost" class="form-control" placeholder="Enter cost">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="list" class="form-label">Height</label>
                                    <input type="number" name="list" id="list" class="form-control" placeholder="Enter list">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Product Details</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="enabled" class="form-label">Enabled</label>
                                    <input type="checkbox" name="enabled" id="enabled" class="form-check-input" value="1" {{ $product->enabled ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                <label for="shippable" class="form-label">Shippable</label>
                                <input type="checkbox" name="shippable" id="shippable" class="form-check-input" {{ $product->shippable ? 'checked' : '' }}>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="id" value="{{ $product->id }}">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <!-- <button type="submit" class="btn btn-primary" >Save</button> -->
    </div>
    </form>
</div>