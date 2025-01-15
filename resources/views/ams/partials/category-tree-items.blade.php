@foreach ($categories as $category)
    <li class="category-item">
        <div class="d-flex align-items-center">
            @if ($category->children->isNotEmpty())
                <button class="btn btn-sm btn-link toggle-btn" type="button">
                    <i class="bi bi-chevron-right"></i>
                </button>
            @else
                <span class="ps-3"></span>
            @endif
            <a href="{{ route('products.index', ['category' => $category->family_category_id]) }}"
                class="category-link {{ request('category') == $category->family_category_id ? 'active' : '' }}">
                {{ $category->family_category_name }}
            </a>
        </div>
        @if ($category->children->isNotEmpty())
            <ul class="nested">
                @include('ams.partials.category-tree-items', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach
