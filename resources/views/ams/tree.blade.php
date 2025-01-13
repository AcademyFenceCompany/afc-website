<li class="category">
    @if (count($category->children) > 0)
        <h5 class="toggle-btn" onclick="toggleChildren(event)">{{ $category->family_category_name }}</h5>

        <ul class="children" style="display: none;">
            @foreach ($category->children as $child)
                @include('ams.tree', ['category' => $child])
            @endforeach
        </ul>
    @else
        <h5>
            <a href="javascript:void(0)" onclick="fetchProducts('{{ $category->family_category_id }}', this)">
                {{ $category->family_category_name }}
            </a>
        </h5>

        <!-- Hidden table to display products -->
        <div class="product-table" style="display: none;">
            <table class="table table-bordered table-striped mt-2">
                {{-- Make sure th is in the same order as tr in fetchProducts --}}
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Item No.</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Color</th>
                        <th>Style</th>
                        <th>Specialty</th>
                        <th>Size 1</th>
                        <th>Size 2</th>
                        <th>Size 3</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    @endif
</li>

<script>
    function fetchProducts(categoryId, link) {
        console.log(categoryId)
        // Find the sibling div containing the product table
        const productTable = link.closest('h5').nextElementSibling;

        // Toggle table visibility
        if (productTable.style.display === 'block') {
            productTable.style.display = 'none'; // Hide table if already visible
            return;
        }

        // Make an AJAX request to fetch product data
        fetch(`/categories/${categoryId}/products`)
            .then(response => {
                if (!response.ok) {
                    // Handle HTTP errors (e.g., 404, 500)
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // Parse JSON response
            })
            .then(data => {
                const tbody = productTable.querySelector('tbody');
                tbody.innerHTML = ''; // Clear any existing product rows

                if (data.products && data.products.length > 0) {
                    // Populate table with product data
                    data.products.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${product.product_id}</td>
                        <td>${product.item_no}</td>
                        <td>${product.product_name}</td>
                        <td>${product.price_per_unit}</td>
                        ${product.color !== null ? `<td>${product.color}</td>` : '<td></td>'}
                        ${product.style !== null ? `<td>${product.style}</td>` : '<td></td>'}
                        ${product.specialty !== null ? `<td>${product.specialty}</td>` : '<td></td>'}
                        ${product.size1 !== null ? `<td>${product.size1}</td>` : '<td></td>'}
                        ${product.size2 !== null ? `<td>${product.size2}</td>` : '<td></td>'}
                        ${product.size3 !== null ? `<td>${product.size3}</td>` : '<td></td>'}
                    `;
                        tbody.appendChild(row);
                    });
                } else {
                    // Display message if no products are found
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td colspan="5" style="text-align: center;">No products found</td>
                `;
                    tbody.appendChild(row);
                }
                console.log(data);
                // Show the table
                productTable.style.display = 'block';
            })
            .catch(error => {
                // Log and display errors
                console.error('Error fetching products:', error);
                alert('Failed to load products. Please try again.');
            });
    }
</script>
