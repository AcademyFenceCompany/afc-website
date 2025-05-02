document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-image");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this image?")) {
                const productId = this.dataset.productId;
                const imageType = this.dataset.imageType;

                fetch(`/products/${productId}/delete-image/${imageType}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Remove the image container
                            this.closest(".position-relative").remove();
                        } else {
                            alert("Error deleting image");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Error deleting image");
                    });
            }
        });
    });
});
function loadProductsByCategory(categoryId, page = 1) {
    currentCategoryId = categoryId;

    // Update active state
    document.querySelectorAll(".category-link").forEach((link) => {
        link.classList.remove("active");
    });
    const activeLink = document.querySelector(
        `[data-category-id="${categoryId}"]`,
    );
    if (activeLink) {
        activeLink.classList.add("active");
    }

    // Show loading state
    const tbody = document.querySelector(".table tbody");
    tbody.innerHTML =
        '<tr><td colspan="7" class="text-center py-4"><i class="bi bi-hourglass-split"></i> Loading...</td></tr>';

    // Fetch products
    fetch(`/api/products/${categoryId}?page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.success && data.data) {
                if (data.data.length > 0) {
                    // Build table rows
                    const rows = data.data
                        .map((product) => {
                            const price = parseFloat(product.price_per_unit);
                            const formattedPrice = !isNaN(price)
                                ? `$${price.toFixed(2)}`
                                : "$0.00";

                            return `
                   <tr>
                        <td>${product.item_no || ""}</td>
                        <td>${product.product_name || ""}</td>
                        <td>${product.family_category?.family_category_name || "N/A"}</td>
                        <td>${formattedPrice}</td>
                        <td>${product.inventory?.in_stock_hq || 0}</td>
                        <td>${product.inventory?.in_stock_warehouse || 0}</td>
                        <td>
                            <div class="d-flex gap-2">
                                ${product.color ? `<small class="badge bg-light text-dark">Color: ${product.color}</small>` : ""}
                                ${product.style ? `<small class="badge bg-light text-dark">Style: ${product.style}</small>` : ""}
                                ${product.speciality ? `<small class="badge bg-light text-dark">speciality: ${product.speciality}</small>` : ""}
                                ${product.size1 ? `<small class="badge bg-light text-dark">Size 1: ${product.size1}</small>` : ""}
                                ${product.size2 ? `<small class="badge bg-light text-dark">Size 2: ${product.size2}</small>` : ""}
                                ${product.size3 ? `<small class="badge bg-light text-dark">Size 3: ${product.size3}</small>` : ""}
                            </div>
                            <a href="/products/${product.product_id}/edit" class="btn btn-sm btn-primary mt-1">Edit</a>
                        </td>
                    </tr>
                `;
                        })
                        .join("");

                    tbody.innerHTML = rows;

                    // Update count display
                    const countDisplay =
                        document.querySelector(".text-muted.small");
                    if (countDisplay) {
                        countDisplay.textContent = `Showing 1 to ${data.data.length} of ${data.total} results`;
                    }
                } else {
                    tbody.innerHTML =
                        '<tr><td colspan="7" class="text-center py-4">No products found for this category</td></tr>';
                }
            } else {
                throw new Error(data.message || "Failed to load products");
            }

            // Update URL
            const url = new URL(window.location);
            url.searchParams.set("category", categoryId);
            window.history.pushState({}, "", url);
        })
        .catch((error) => {
            console.error("Error:", error);
            tbody.innerHTML =
                '<tr><td colspan="7" class="text-center py-4 text-danger">Error loading products</td></tr>';
        });
}
document.addEventListener("DOMContentLoaded", function () {
    // Handle both category clicks and toggle button clicks
    const categoryTree = document.querySelector(".category-tree");
    
    if (categoryTree) {
        categoryTree.addEventListener("click", function (e) {
            // Handle toggle button clicks
            if (
                e.target.closest(".toggle-btn") ||
                e.target.closest(".bi-chevron-right")
            ) {
                const item = e.target.closest(".category-item");
                item.classList.toggle("expanded");
                return;
            }

            // Handle category clicks
            const categoryLink = e.target.closest(".category-link");
            if (categoryLink) {
                e.preventDefault();
                const categoryId = categoryLink.dataset.categoryId;
                loadProductsByCategory(categoryId);
            }
        });
    }
});

    // Auto-expand active category
    const activeLink = document.querySelector(".category-link.active");
    if (activeLink) {
        let parent = activeLink.closest(".nested");
        while (parent) {
            parent.classList.add("show");
            const toggleBtn = parent.parentElement.querySelector(".toggle-btn");
            if (toggleBtn) {
                toggleBtn.classList.add("active");
                const icon = toggleBtn.querySelector("i");
                if (icon) {
                    icon.style.transform = "rotate(90deg)";
                }
            }
            parent = parent.parentElement.closest(".nested");
        }
    }
});
