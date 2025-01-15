<li class="category-item">
    @if (count($category->children) > 0)
        <div class="category-header d-flex align-items-center" onclick="toggleChildren(event)">
            <div class="category-toggle me-2">
                <i class="bi bi-chevron-right"></i>
            </div>
            <span class="category-name">{{ $category->family_category_name }}</span>
        </div>
        <ul class="category-children list-unstyled ms-3" style="display: none;">
            @foreach ($category->children as $child)
                @include('ams.partials.category-tree-items', ['category' => $child])
            @endforeach
        </ul>
    @else
        <div class="category-link d-flex align-items-center"
            onclick="fetchProducts('{{ $category->family_category_id }}', this)">
            <span class="ms-4 category-name">{{ $category->family_category_name }}</span>
        </div>
    @endif
</li>
