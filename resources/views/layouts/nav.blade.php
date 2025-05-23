  <!-- Navigation Menu -->
  <div class="container">
    <!-- Mobile Menu Toggle Button -->
    <button class="btn nav-btn d-md-none w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavMenu" aria-expanded="false" aria-controls="mobileNavMenu">
        <i class="bi bi-list"></i> Menu
    </button>
    
    <!-- Desktop Navigation -->
    <nav class="nav mb-3 d-none d-md-flex flex-wrap">
        <!-- Wood Fence Dropdown -->
        <div class="dropdown">
            <li><a href="{{ route('woodfence') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="">WOOD FENCE</a></li>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/wood-fence/specs/6/2%201/2%20in.?styleTitle=Spaced+Picket">Spaced Picket Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('solid-board') }}">Solid Board Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('board-on-board') }}">Shadow Box Board On Board</a></li>
                <li><a class="dropdown-item" href="{{ route('stockade.index') }}">Stockade Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('board-on-board') }}">Board Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('tongue-groove') }}">Tongue Groove Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('postrail.index') }}">Posts & Rails</a></li>
                <li><a class="dropdown-item" href="{{ route('woodpostcaps.index') }}">Woodpost Caps</a></li>
                <li><a class="dropdown-item" href="">Loose Wood Fence</a></li>

            </ul>
        </div>
        
        <a href="#" class="nav-link btn nav-btn">VINYL FENCE</a>
        <!-- Chain Link Fence Dropdown -->
        <div class="dropdown">
            <a href="{{ route('chainlink.main') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="">CHAIN LINK</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '4ft']) }}">4ft Chain Link Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '5ft']) }}">5ft Chain Link Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '6ft']) }}">6ft Chain Link Fence</a></li>
            </ul>
        </div>
        
        <!-- Aluminum Fence Dropdown -->
        <div class="dropdown">
            <a href="{{ route('aluminumfence.main') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="">ALUMINUM FENCE</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('aluminumfence.index') }}">OnGuard Aluminum Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('aluminumfence.pickup') }}">Available for Pickup</a></li>
            </ul>
        </div>
        
        <div class="dropdown">
            <a href='{{ route('weldedwire') }}' class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="">WELDED WIRE</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=4%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">4"
                        x 4"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=3%2Bin.%2Bx%2B3%2Bin.&amp;coating=Vinyl%20PVC">3"
                        x 3"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=2%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">2"
                        x 4"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">2"
                        x 2"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">1
                        1/2" x 1 1/2"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%2B1%252F2%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">1
                        1/2" x 4"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=3%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">3"
                        x 2"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%2Bin.%2Bx%2B3%2Bin.&amp;coating=Vinyl%20PVC">1"
                        x 3"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">1"
                        x 2"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%2Bin.%2Bx%2B1%2Bin.&amp;coating=Vinyl%20PVC">1"
                        x 1"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%252F2%2Bin.%2Bx%2B1%2Bin.&amp;coating=Vinyl%20PVC">1/2"
                        x 1"</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%252F2%2Bin.%2Bx%2B1%252F2%2Bin.&amp;coating=Vinyl%20PVC">1/2"
                        Hardware Cloth</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%252F4%2Bin.%2Bx%2B1%252F4%2Bin.&amp;coating=Vinyl%20PVC">1/4"
                        Hardware Cloth</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%252F8%2Bin.%2Bx%2B1%252F8%2Bin.&amp;coating=Vinyl%20PVC">1/8"
                        Hardware Cloth</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=1%2Bin.%2Bx%2B1%2Bin.&coating=Vinyl%20PVC">1"
                        Hex Netting/Chicken Wire</a></li>
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&coating=Vinyl%20PVC">2"
                        Hex Netting/Chicken Wire</a></li>
                <!-- <li><a class="dropdown-item" href="#">Deer Fence</a></li> -->
                <!-- <li><a class="dropdown-item" href="#">Welded Wire Gates</a></li> -->
                <!-- <li><a class="dropdown-item" href="#">Silt/Erosion Fence</a></li> -->
                <!-- <li><a class="dropdown-item" href="#">Snow Fence</a></li> -->
                <li><a class="dropdown-item"
                        href="/wwf-product?meshSize=4%2Bin.%2Bx%2B4%2Bin.&amp;coating=Galvanized">Knock-In
                        Post</a></li>
                <!-- <li><a class="dropdown-item" href="#">Specialty Wire</a></li> -->
                <li><a class="dropdown-item" href="#">Fence Pen Kits</a></li>
                <!-- <li><a class="dropdown-item" href="#">Welded Wire Samples</a></li> -->
            </ul>
        </div>
        @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'main_menu')->orderBy('menu_order')->get() as $page)
            <a href='{{ route('category.show', ['slug' => $page->slug]) }}' class="nav-link btn nav-btn">{{ strtoupper($page->title ?: $page->category->family_category_name) }}</a>
        @endforeach
        <a href='{{ route('contact') }}' class="nav-link btn nav-btn">CONTACT US</a>
        <div class="dropdown">
            <a href="#" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-list"></i> Quick Menu
            </a>
            <ul class="dropdown-menu">
                
            </ul>
        </div>
    </nav>
    
    <!-- Mobile Navigation -->
    <div class="collapse mb-3" id="mobileNavMenu">
        <div class="d-flex flex-column">
            <!-- Wood Fence Dropdown -->
            <div class="dropdown mb-2">
                <a href="{{ route('woodfence') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">WOOD FENCE</a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('stockade.index') }}">Stockade Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('board-on-board') }}">Board Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('tongue-groove') }}">Tongue Groove Fence</a></li>
                <li><a class="dropdown-item" href="{{ route('postrail.index') }}">Posts & Rails</a></li>
                </ul>
            </div>
            
            <a href="#" class="nav-link btn nav-btn mb-2">VINYL FENCE</a>
            <!-- Chain Link Fence Dropdown -->
            <div class="dropdown mb-2">
                <a href="{{ route('chainlink.main') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">CHAIN LINK</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '4ft']) }}">4ft Chain Link Fence</a></li>
                    <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '5ft']) }}">5ft Chain Link Fence</a></li>
                    <li><a class="dropdown-item" href="{{ route('chainlink.height', ['height' => '6ft']) }}">6ft Chain Link Fence</a></li>
                </ul>
            </div>
            
            <!-- Aluminum Fence Dropdown -->
            <div class="dropdown mb-2">
                <a href="{{ route('aluminumfence.main') }}" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">ALUMINUM FENCE</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('aluminumfence.index') }}">OnGuard Aluminum Fence</a></li>
                    <li><a class="dropdown-item" href="{{ route('aluminumfence.pickup') }}">Available for Pickup</a></li>
                </ul>
            </div>
            
            <div class="dropdown">
                <a href='{{ route('weldedwire') }}' class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">WELDED WIRE</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                            href="/wwf-product?meshSize=4%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">4"
                            x 4"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=3%2Bin.%2Bx%2B3%2Bin.&amp;coating=Vinyl%20PVC">3"
                            x 3"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=2%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">2"
                            x 4"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">2"
                            x 2"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">1
                            1/2" x 1 1/2"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%2B1%252F2%2Bin.%2Bx%2B4%2Bin.&amp;coating=Vinyl%20PVC">1
                            1/2" x 4"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=3%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">3"
                            x 2"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%2Bin.%2Bx%2B3%2Bin.&amp;coating=Vinyl%20PVC">1"
                            x 3"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%2Bin.%2Bx%2B2%2Bin.&amp;coating=Vinyl%20PVC">1"
                            x 2"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%2Bin.%2Bx%2B1%2Bin.&amp;coating=Vinyl%20PVC">1"
                            x 1"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%252F2%2Bin.%2Bx%2B1%2Bin.&amp;coating=Vinyl%20PVC">1/2"
                            x 1"</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%252F2%2Bin.%2Bx%2B1%252F2%2Bin.&amp;coating=Vinyl%20PVC">1/2"
                            Hardware Cloth</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%252F4%2Bin.%2Bx%2B1%252F4%2Bin.&amp;coating=Vinyl%20PVC">1/4"
                            Hardware Cloth</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%252F8%2Bin.%2Bx%2B1%252F8%2Bin.&amp;coating=Vinyl%20PVC">1/8"
                            Hardware Cloth</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=1%2Bin.%2Bx%2B1%2Bin.&coating=Vinyl%20PVC">1"
                            Hex Netting/Chicken Wire</a></li>
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=2%2Bin.%2Bx%2B2%2Bin.&coating=Vinyl%20PVC">2"
                            Hex Netting/Chicken Wire</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Deer Fence</a></li> -->
                    <!-- <li><a class="dropdown-item" href="#">Welded Wire Gates</a></li> -->
                    <!-- <li><a class="dropdown-item" href="#">Silt/Erosion Fence</a></li> -->
                    <!-- <li><a class="dropdown-item" href="#">Snow Fence</a></li> -->
                    <li><a class="dropdown-item"
                            href="http://192.168.0.135/wwf-product?meshSize=4%2Bin.%2Bx%2B4%2Bin.&amp;coating=Galvanized">Knock-In
                            Post</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Specialty Wire</a></li> -->
                    <li><a class="dropdown-item" href="#">Fence Pen Kits</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Welded Wire Samples</a></li> -->
                </ul>
            </div>
            @foreach(\App\Models\CategoryPage::with('category')->where('menu_type', 'main_menu')->orderBy('menu_order')->get() as $page)
                <a href='{{ route('category.show', ['slug' => $page->slug]) }}' class="nav-link btn nav-btn mb-2">{{ strtoupper($page->title ?: $page->category->family_category_name) }}</a>
            @endforeach
            <a href='{{ route('contact') }}' class="nav-link btn nav-btn mb-2">CONTACT US</a>
            <div class="dropdown">
                <a href="#" class="nav-link btn nav-btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-list"></i> Quick Menu
                </a>
                <ul class="dropdown-menu">
                   
                </ul>
            </div>
        </div>
    </div>
</div>