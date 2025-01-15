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
function toggleChildren(event) {
    const toggleBtn = event.target;
    const childrenList = toggleBtn.nextElementSibling;
    toggleBtn.classList.toggle("active");

    if (childrenList && childrenList.classList.contains("children")) {
        childrenList.style.display =
            childrenList.style.display === "none" ||
            childrenList.style.display === ""
                ? "block"
                : "none";
    }
}

function fetchProducts(categoryId, link) {
    console.log("Fetching products for category:", categoryId);

    const tbody = document.getElementById("productsTableBody");
    tbody.innerHTML =
        '<tr><td colspan="7" class="text-center">Loading...</td></tr>';

    fetch(`/categories/${categoryId}/products`)
        .then((response) => response.json())
        .then((data) => {
            console.log("Received data:", data);
            tbody.innerHTML = "";

            if (data.products && data.products.length > 0) {
                data.products.forEach((product) => {
                    // Convert price to number and handle null/undefined
                    const price = parseFloat(product.price_per_unit) || 0;

                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${product.item_no || ""}</td>
                        <td>${product.product_name || ""}</td>
                        <td>${product.family_category_name || "N/A"}</td>
                        <td>$${price.toFixed(2)}</td>
                        <td>${product.in_stock_hq || 0}</td>
                        <td>${product.in_stock_warehouse || 0}</td>
                        <td>
                            <a href="/products/${product.product_id}/edit" 
                               class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                tbody.innerHTML =
                    '<tr><td colspan="7" class="text-center py-4">No products found</td></tr>';
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-danger">
                        Error loading products: ${error.message}
                    </td>
                </tr>`;
        });
}
