function updateMiniCart(cart) {
    const miniCartItems = document.getElementById("mini-cart-items");
    const emptyCartMessage = document.getElementById("empty-cart-message");
    const cartCountElement = document.getElementById("cart-count");

    if (!cart || typeof cart !== 'object') return; // 🚫 guard clause for bad input

    // Clear mini cart content
    if (miniCartItems) {
        miniCartItems.innerHTML = "";
    }

    // Update badge count
    if (cartCountElement) {
        cartCountElement.textContent = Object.keys(cart).length;
    }

    const hasItems = Object.keys(cart).length > 0;

    if (hasItems && miniCartItems && emptyCartMessage) {
        emptyCartMessage.classList.add("d-none");

        Object.values(cart).forEach(item => {
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
    } else if (emptyCartMessage) {
        emptyCartMessage.classList.remove("d-none");
    }
}
