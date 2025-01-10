<li class="category">
    <span class="toggle-btn" onclick="toggleChildren(event)">{{ $category->family_category_name }}</span>

    @if (count($category->children) > 0)
        <ul class="children" style="display: none;">
            @foreach ($category->children as $child)
                @include('ams.tree', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
