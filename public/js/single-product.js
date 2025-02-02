document.addEventListener("DOMContentLoaded", () => {
    const productOptionDropdown = document.getElementById("product-option");

    // Fetch product details based on selected option
    productOptionDropdown.addEventListener("change", function () {
        const productId = this.value;

        fetch(`/product/details/${productId}`)
            .then((response) => response.json())
            .then((data) => updateProductDetails(data))
            .catch((error) =>
                console.error("Error fetching product details:", error),
            );
    });

    function updateProductDetails(data) {
        // Update common fields
        document.getElementById("product-name").innerHTML = `
            ${data.product_name}<br>${data.size1 ?? ""}<br>${data.size2 ?? data.style} ${data.size3 ?? data.speciality} ${data.spacing ?? ""}
        `;
        document.getElementById("item-number").textContent =
            data.item_no ?? "N/A";

        if (data.weight) {
            document.getElementById("weight").textContent = data.weight;
        }

        if (data.price_per_unit) {
            document.getElementById("product-price").textContent =
                `$${parseFloat(data.price_per_unit).toFixed(2)}`;
        }

        if (data.general_image || data.small_image || data.large_image) {
            document.getElementById("product-image").src =
                data.general_image || data.small_image || data.large_image;
        }

        // Special handling for Wood Fence
        if (data.family_category_id === 16) {
            // Assuming 16 is the Wood Fence family_category_id
            // Hide size2 and size3-related fields as they are null for Wood Fence
            if (!data.size2 && !data.size3) {
                document.getElementById("product-name").innerHTML = `
                    ${data.product_name}<br>${data.size1 ?? ""}
                `;
            }

            // Handle Wood Fence-specific attributes
            if (data.style && data.speciality && data.spacing) {
                const woodFenceAttributes = `
                    <p><strong>Style:</strong> ${data.style}</p>
                    <p><strong>Speciality:</strong> ${data.speciality}</p>
                    <p><strong>Spacing:</strong> ${data.spacing}</p>
                `;
                document.getElementById("woodfence-attributes").innerHTML =
                    woodFenceAttributes;
                document.getElementById("woodfence-attributes").style.display =
                    "block";
            } else {
                document.getElementById("woodfence-attributes").style.display =
                    "none";
            }
        } else {
            // Hide Wood Fence attributes if not relevant
            // document.getElementById("woodfence-attributes").style.display =
            //     "none";
        }
    }
});
