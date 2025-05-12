<<<<<<< HEAD
=======
// Function to Update Mini Cart
>>>>>>> origin/ready-push-main
function updateMiniCart(cart) {
    const miniCartItems = document.getElementById("mini-cart-items");
    const emptyCartMessage = document.getElementById("empty-cart-message");
    const cartCountElement = document.getElementById("cart-count");

<<<<<<< HEAD
    if (!cart || typeof cart !== 'object') return; // 🚫 guard clause for bad input

    // Clear mini cart content
=======
    // Clear existing mini cart content
>>>>>>> origin/ready-push-main
    if (miniCartItems) {
        miniCartItems.innerHTML = "";
    }

<<<<<<< HEAD
    // Update badge count
=======
    // Update cart badge count
>>>>>>> origin/ready-push-main
    if (cartCountElement) {
        cartCountElement.textContent = Object.keys(cart).length;
    }

<<<<<<< HEAD
    const hasItems = Object.keys(cart).length > 0;

    if (hasItems && miniCartItems && emptyCartMessage) {
        emptyCartMessage.classList.add("d-none");

=======
    if (Object.keys(cart).length > 0 && miniCartItems && emptyCartMessage) {
        emptyCartMessage.classList.add("d-none");

        // Populate mini cart dynamically
>>>>>>> origin/ready-push-main
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
<<<<<<< HEAD
}
=======
}
>>>>>>> origin/ready-push-main
