@foreach ($categories as $category)
    <li class="category-item">
        <div class="d-flex align-items-center">
            @if ($category->children->count() > 0)
                <button class="btn btn-sm btn-link toggle-btn" type="button">
                    <i class="bi bi-chevron-right"></i>
                </button>
            @else
                <span class="ps-3"></span>
            @endif
            <a href="javascript:void(0)" 
                class="category-link {{ request('category') == $category->family_category_id ? 'active' : '' }}"
                data-category-id="{{ $category->family_category_id }}" data-action="load-products">
                {{ $category->family_category_name }}
                <span class="badge bg-secondary float-end">{{ $category->products_count }}</span>
            </a>
        </div>
        @if ($category->children->count() > 0)
            <ul class="nested">
                @include('ams.partials.category-tree-items', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach
