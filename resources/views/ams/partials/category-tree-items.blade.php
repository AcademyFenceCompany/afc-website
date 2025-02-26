@foreach($categories as $subcategory)
    <li class="category-item">
        <div class="d-flex align-items-center">
            @if(count($subcategory->children) > 0)
                <button class="btn btn-sm btn-link toggle-btn" type="button">
                    <i class="bi bi-chevron-right"></i>
                </button>
            @else
                <span class="ps-3"></span>
            @endif
            <a href="javascript:void(0)" 
               class="category-link {{ request('category') == $subcategory->family_category_id ? 'active' : '' }}"
               data-category-id="{{ $subcategory->family_category_id }}"
               onclick="loadProductsByCategory('{{ $subcategory->family_category_id }}')">
                {{ $subcategory->family_category_name }}
                <span class="badge bg-secondary float-end">{{ $subcategory->products_count ?? 0 }}</span>
            </a>
        </div>
        @if(count($subcategory->children) > 0)
            <ul class="nested">
                @include('ams.partials.category-tree-items', ['categories' => $subcategory->children])
            </ul>
        @endif
    </li>
@endforeach
