<ul class="dropdown-menu col-4" id="big-menu" aria-labelledby="big-menu">
    @foreach ($majCategories as $category)
        <li class="d-flex flex-sm-row justify-content-between align-items-center">
            @php
                $subCategories = \DB::table('categories')->where('majorcategories_id', $category->id)->get();
            @endphp
            <a href="#" class="dropdown-item">{{ $category->cat_name }}</a>
            @if (!$subCategories->isEmpty()) <i class="bi bi-chevron-right"></i> @endif
            <!-- Second Level menu-->
            <ul class="dropdown-menu dropdown-submenu">
                @foreach ($subCategories as $subcategory)
                    <li>
                        <a href="#" class="dropdown-item d-flex justify-space-between">
                            {{ \Illuminate\Support\Str::words($subcategory->cat_name, 3, '...') }}
                            {{ $subcategory->id }}
                            @if ($subcategory->shippable == 0)
                            <span class="badge rounded-pill ms-auto text-bg-success float-right me-3">Pick Up</span>
                            @endif
                            <i class="bi bi-chevron-right"></i>
                        </a>
                        @if($subcategory->id == 163)
                        <!-- Third level menu -->
                        <ul class="dropdown-menu dropdown-submenu">
                            @foreach ($subCategories as $subcategory)
                                @include('partials.submenu-list', ['subcategory' => $subcategory])
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach
</ul>