document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const subtotalElement = document.getElementById("subtotal");
    const checkoutButton = document.getElementById("checkout-button");
    const deleteModal = new bootstrap.Modal(
        document.getElementById("deleteConfirmModal"),
    );
    const clearCartModal = new bootstrap.Modal(
        document.getElementById("clearCartModal"),
    );
    let itemToDelete = null;

    // Update Cart Total Function
    const updateCartTotal = () => {
        let subtotal = 0;
        let cartHasItems = false;

        document.querySelectorAll("tbody tr").forEach((row) => {
            const pricePerItemText = row
                .querySelector(".price-per-item")
                ?.textContent.trim();
            const price = parseFloat(pricePerItemText?.replace("$", ""));
            const quantityInput = row.querySelector(".quantity-input");
            const quantity = parseInt(quantityInput?.value);

            if (!isNaN(price) && !isNaN(quantity)) {
                const totalPrice = price * quantity;
                row.querySelector(".total-price").textContent =
                    `$${totalPrice.toFixed(2)}`;
                subtotal += totalPrice;
                cartHasItems = true;
            }
        });

        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        checkoutButton.disabled = !cartHasItems;

        // Also update clear cart button if it exists
        const clearCartButton = document.getElementById("clear-cart");
        if (clearCartButton) {
            clearCartButton.disabled = !cartHasItems;
        }
    };

    // Toast Notification Function
    function showToast(message, className = "bg-success") {
        const toastElement = document.getElementById("cart-toast");
        const toastMessage = document.getElementById("cart-toast-message");

        if (toastElement && toastMessage) {
            toastMessage.textContent = message;
            toastElement.className = `toast align-items-center text-white ${className} border-0`;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    }

    // Quantity Handlers
    document.querySelectorAll(".quantity-increase").forEach((button) => {
        button.addEventListener("click", function () {
            const quantityInput = this.previousElementSibling;
            if (quantityInput) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateCartTotal();
            }
        });
    });

    document.querySelectorAll(".quantity-decrease").forEach((button) => {
        button.addEventListener("click", function () {
            const quantityInput = this.nextElementSibling;
            if (quantityInput && parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateCartTotal();
            }
        });
    });

    // Delete Item Handler
    document.querySelectorAll(".delete-btn").forEach((button) => {
        button.addEventListener("click", function () {
            itemToDelete = this.getAttribute("data-item");
            deleteModal.show();
        });
    });

    // Delete Confirmation Handler
    document
        .getElementById("confirmDelete")
        ?.addEventListener("click", function () {
            if (!itemToDelete) return;

            fetch("/cart/remove-item", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({
                    item_no: itemToDelete,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const itemRow = document
                            .querySelector(`[data-item="${itemToDelete}"]`)
                            ?.closest("tr");
                        if (itemRow) {
                            itemRow.remove();
                        }
                        updateCartTotal();

                        const cartCountElement =
                            document.getElementById("cart-count");
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cartCount;
                        }

                        showToast("Item removed from cart", "bg-danger");

                        // If cart is empty, add empty message
                        const tbody = document.querySelector("tbody");
                        if (tbody && tbody.children.length === 0) {
                            tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">Your cart is empty.</td>
                        </tr>
                    `;
                        }
                    }
                    deleteModal.hide();
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showToast("An error occurred", "bg-danger");
                    deleteModal.hide();
                });
        });

    // Clear Cart Handler
    document
        .getElementById("clear-cart")
        ?.addEventListener("click", function () {
            clearCartModal.show();
        });

    // Clear Cart Confirmation Handler
    document
        .getElementById("confirmClearCart")
        ?.addEventListener("click", function () {
            fetch("/cart/clear", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const tbody = document.querySelector("tbody");
                        if (tbody) {
                            tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center">Your cart is empty.</td>
                        </tr>
                    `;
                        }
                        updateCartTotal();

                        const cartCountElement =
                            document.getElementById("cart-count");
                        if (cartCountElement) {
                            cartCountElement.textContent = "0";
                        }

                        showToast("Cart has been cleared", "bg-danger");
                    }
                    clearCartModal.hide();
                })
                .catch((error) => {
                    console.error("Error:", error);
                    showToast("An error occurred", "bg-danger");
                    clearCartModal.hide();
                });
        });

    // Initialize total calculation
    updateCartTotal();
});
