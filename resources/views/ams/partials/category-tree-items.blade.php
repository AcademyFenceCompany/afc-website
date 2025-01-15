<li class="category">
    @if (count($category->children) > 0)
        <h5 class="toggle-btn" onclick="toggleChildren(event)">
            {{ $category->family_category_name }}
        </h5>
        <ul class="children list-unstyled ml-3" style="display: none;">
            @foreach ($category->children as $child)
                @include('ams.partials.category-tree-items', ['category' => $child])
            @endforeach
        </ul>
    @else
        <h5>
            <a href="javascript:void(0)" onclick="fetchProducts('{{ $category->family_category_id }}', this)"
                class="category-link">
                {{ $category->family_category_name }}
            </a>
        </h5>
    @endif
</li>
