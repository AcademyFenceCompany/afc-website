document.addEventListener("DOMContentLoaded", () => {
    const productOptionDropdown = document.getElementById("product-option");

    // Fetch product details based on selected option
    productOptionDropdown.addEventListener("change", function () {
        const productId = this.value;

        fetch(`/product/details/${productId}`)
            .then(response => response.json())
            .then(data => updateProductDetails(data))
            .catch(error => console.error("Error fetching product details:", error));
    });

    function updateProductDetails(data) {
        document.getElementById("product-name").innerHTML = `
            ${data.product_name}<br>${data.size1}<br>${data.size2} ${data.size3}
        `;
        document.getElementById("item-number").textContent = data.item_no;
        document.getElementById("weight").textContent = `${data.weight} lbs`;
        document.getElementById("product-price").textContent = `$${parseFloat(data.price_per_unit).toFixed(2)}`;
        document.getElementById("product-image").src = data.large_image;
    }
});
