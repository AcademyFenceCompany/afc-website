    // document.addEventListener("DOMContentLoaded", function() {
    //     // Handle quantity and price updates
    //     document.querySelectorAll("tbody").forEach((tbody) => {
    //         tbody.addEventListener("click", function(e) {
    //             const target = e.target;

    //             if (target.classList.contains("increase-qty") || target.classList.contains(
    //                     "decrease-qty")) {
    //                 const quantityInput = target.closest("td").querySelector(".quantity-input");

    //                 // Get current quantity and price per unit
    //                 let quantity = parseInt(quantityInput.value);
    //                 const pricePerUnit = parseFloat(quantityInput.dataset.price);

    //                 // Increment or decrement quantity
    //                 if (target.classList.contains("increase-qty")) {
    //                     quantity++;
    //                 } else if (target.classList.contains("decrease-qty") && quantity > 1) {
    //                     quantity--;
    //                 }

    //                 // Update input value and total price
    //                 quantityInput.value = quantity;

    //                 // Update the total price cell in the same row
    //                 const totalPriceCell = target.closest("tr").querySelector(".d-flex span");
    //                 if (totalPriceCell) {
    //                     totalPriceCell.innerText = `$${(quantity * pricePerUnit).toFixed(2)}`;
    //                 }
    //             }
    //         });

    //         // Handle manual input change
    //         tbody.addEventListener("input", function(e) {
    //             const target = e.target;

    //             if (target.classList.contains("quantity-input")) {
    //                 let quantity = parseInt(target.value) ||
    //                     1; // Default to 1 if input is invalid
    //                 const pricePerUnit = parseFloat(target.dataset.price);

    //                 // Update the total price cell in the same row
    //                 const totalPriceCell = target.closest("tr").querySelector(".d-flex span");
    //                 if (totalPriceCell) {
    //                     totalPriceCell.innerText = `$${(quantity * pricePerUnit).toFixed(2)}`;
    //                 }
    //             }
    //         });
    //     });
    // });

    // document.addEventListener("DOMContentLoaded", () => {
    //     document.querySelectorAll(".add-to-cart-btn").forEach(button => {
    //         button.addEventListener("click", function() {
    //             const itemNo = this.getAttribute("data-item");
    //             const productName = this.getAttribute("data-name");
    //             const price = this.getAttribute("data-price");
    //             const color = this.getAttribute("data-color");
    //             const size = this.getAttribute("data-size");
    //             const mesh = this.getAttribute("data-mesh");
    //             const quantityInput = this.closest("tr").querySelector(".quantity-input");
    //             const quantity = quantityInput.value;

    //             // Send AJAX request to add to cart
    //             fetch("{{ route('cart.add') }}", {
    //                     method: "POST",
    //                     headers: {
    //                         "Content-Type": "application/json",
    //                         "X-CSRF-TOKEN": "{{ csrf_token() }}"
    //                     },
    //                     body: JSON.stringify({
    //                         item_no: itemNo,
    //                         product_name: productName,
    //                         price: price,
    //                         color: color,
    //                         size: size,
    //                         mesh: mesh,
    //                         quantity: quantity,
    //                     }),
    //                 })
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         // Show Bootstrap toast
    //                         const toastEl = document.getElementById('cartToast');
    //                         const toast = new bootstrap.Toast(toastEl);
    //                         toast.show();
    //                         // Update the cart count in the navbar
    //                         const cartCountElement = document.getElementById('cart-count');
    //                         cartCountElement.textContent = data.cartCount;
    //                     } else {
    //                         alert("Failed to add item to cart.");
    //                     }
    //                 })
    //                 .catch(error => {
    //                     console.error("Error:", error);
    //                 });
    //         });
    //     });
    // });
