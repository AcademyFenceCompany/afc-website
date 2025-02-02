// Function to Update Mini Cart
// Function to Update Mini Cart
function updateMiniCart(cart) {
    const miniCartItems = document.getElementById("mini-cart-items");
    const emptyCartMessage = document.getElementById("empty-cart-message");
    const cartCountElement = document.getElementById("cart-count");

    // Clear existing mini cart content
    miniCartItems.innerHTML = "";

    // Update cart badge count
    cartCountElement.textContent = Object.keys(cart).length;

    if (Object.keys(cart).length > 0) {
        emptyCartMessage.classList.add("d-none");

        // Populate mini cart dynamically
        Object.values(cart).forEach((item) => {
            miniCartItems.innerHTML += `
                <li class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-0">${item.product_name}</h6>
                        <small class="text-muted">Qty: ${item.quantity}</small>
                    </div>
                    <span class="fw-bold">$${parseFloat(item.total).toFixed(2)}</span>
                </li>
                <hr>
            `;
        });
    } else {
        emptyCartMessage.classList.remove("d-none");
    }
}

document.querySelectorAll(".add-to-cart-btn").forEach((button) => {
    button.addEventListener("click", function () {
        const itemData = {
            item_no: this.getAttribute("data-item"),
            product_name: this.getAttribute("data-name"),
            price: this.getAttribute("data-price"),
            color: this.getAttribute("data-color"),
            size: this.getAttribute("data-size"),
            mesh: this.getAttribute("data-mesh"),
            quantity: this.closest("tr").querySelector(".quantity-input").value,
        };

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify(itemData),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Update the mini cart dynamically
                    updateMiniCart(data.cart);

                    // Show success notification
                    showToast("Item added to cart", "bg-success");
                } else {
                    showToast("Failed to add item", "bg-danger");
                }
            })
            .catch((error) => console.error("Error adding item:", error));
    });
});
