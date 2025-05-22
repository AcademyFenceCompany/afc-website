document.addEventListener("DOMContentLoaded", () => {
    console.log("Script Loaded");

    const updatePrice = (input) => {
        const pricePerUnit = parseFloat(input.dataset.price) || 0;
        let quantity = parseInt(input.value) || 1;

        if (quantity < 1) quantity = 1; // Ensure min quantity is 1
        input.value = quantity;

        const row = input.closest("tr") || input.closest(".col-md-6");
        const priceElement = row.querySelector(".dynamic-price");

        if (priceElement) {
            const totalPrice = (pricePerUnit * quantity).toFixed(2);
            priceElement.textContent = `$${totalPrice}`;
        }
    };

    // Handle increase/decrease quantity
    document.addEventListener("click", (event) => {
        if (
            event.target.classList.contains("quantity-increase") ||
            event.target.classList.contains("quantity-decrease")
        ) {
            const input = event.target
                .closest(".d-flex, .text-center")
                .querySelector(".quantity-input");

            if (input) {
                let quantity = parseInt(input.value) || 1;

                if (event.target.classList.contains("quantity-increase")) {
                    quantity++;
                } else if (
                    event.target.classList.contains("quantity-decrease") &&
                    quantity > 1
                ) {
                    quantity--;
                }

                input.value = quantity;
                updatePrice(input);
            }
        }
    });

    // Handle manual quantity input
    document.addEventListener("input", (event) => {
        if (event.target.classList.contains("quantity-input")) {
            updatePrice(event.target);
        }
    });

    // Handle Add to Cart
    document.addEventListener("click", (event) => {
        if (event.target.classList.contains("add-to-cart-btn")) {
            const button = event.target;
<<<<<<< HEAD
            const id = button.dataset.id || "";
            const itemNo = button.dataset.item_no;
            const productName = button.dataset.product_name;
            const price = button.dataset.price;
            const color = button.dataset.color || "";
            const size = button.dataset.size || "";
            const sizeIn = button.dataset.size_in || "";
            const sizeWt = button.dataset.size_wt || "";
            const sizeHt = button.dataset.size_ht || "";
=======
            const itemNo = button.dataset.item;
            const productName = button.dataset.name;
            const price = button.dataset.price;
            const color = button.dataset.color || "";
            const size1 = button.dataset.size1 || "";
>>>>>>> afc-webdev-c
            const size2 = button.dataset.size2 || "";
            const size3 = button.dataset.size3 || "";
            const speciality = button.dataset.speciality || "";
            const material = button.dataset.material || "";
            const spacing = button.dataset.spacing || "";
            const coating = button.dataset.coating || "";
<<<<<<< HEAD
            const weightLbs = button.dataset.weight_lbs || "";
            const catIdFk = button.dataset.cat_id_fk || "";
            const imgSmall = button.dataset.img_small || "";
            const imgLarge = button.dataset.img_large || "";
            const freeShipping = button.dataset.free_shipping || "0";
            const specialShipping = button.dataset.special_shipping || "0";
            const amountPerBox = button.dataset.amount_per_box || "1";
            const descShort = button.dataset.desc_short || "";
            const descLong = button.dataset.desc_long || "";
            const shipLength = button.dataset.ship_length || "";
            const shipWidth = button.dataset.ship_width || "";
            const shipHeight = button.dataset.ship_height || "";
            const categoriesId = button.dataset.categories_id || "";
            const shippingMethod = button.dataset.shipping_method || "";
=======
            const weight = button.dataset.weight || "";
            const familyCategory = button.dataset.family_category || "";
            const generalImage = button.dataset.general_image || "";
            const smallImage = button.dataset.small_image || "";
            const largeImage = button.dataset.large_image || "";
            const freeShipping = button.dataset.free_shipping || "0";
            const specialShipping = button.dataset.special_shipping || "0";
            const amountPerBox = button.dataset.amount_per_box || "1";
            const description = button.dataset.description || "";
            const subcategoryId = button.dataset.subcategory_id || "";
            const shippingLength = button.dataset.shipping_length || "";
            const shippingWidth = button.dataset.shipping_width || "";
            const shippingHeight = button.dataset.shipping_height || "";
            const shippingClass = button.dataset.shipping_class || "";
>>>>>>> afc-webdev-c
            const quantityInput =
                button.closest("tr")?.querySelector(".quantity-input") ||
                document.querySelector(".quantity-input");
            const quantity = parseInt(quantityInput?.value || 1);

            console.log("Add to Cart:", {
<<<<<<< HEAD
                id,
=======
>>>>>>> afc-webdev-c
                itemNo,
                productName,
                price,
                color,
<<<<<<< HEAD
                size,
                sizeIn,
                sizeWt, 
                sizeHt,
=======
                size1,
>>>>>>> afc-webdev-c
                size2,
                size3,
                speciality,
                material,
                spacing,
                coating,
<<<<<<< HEAD
                weightLbs,
                catIdFk,
                imgSmall,
                imgLarge,
                freeShipping,
                specialShipping,
                amountPerBox,
                descShort,
                descLong,
                shipLength,
                shipWidth,
                shipHeight,
                categoriesId,
                shippingMethod,
=======
                weight,
                familyCategory,
                generalImage,
                smallImage,
                largeImage,
                freeShipping,
                specialShipping,
                amountPerBox,
                description,
                subcategoryId,
                shippingLength,
                shippingWidth,
                shippingHeight,
                shippingClass,
>>>>>>> afc-webdev-c
                quantity,
            });

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({
<<<<<<< HEAD
                    id: id,
=======
>>>>>>> afc-webdev-c
                    item_no: itemNo,
                    product_name: productName,
                    price,
                    color,
<<<<<<< HEAD
                    size,
                    size_in: sizeIn,
                    size_wt: sizeWt,
                    size_ht: sizeHt,
=======
                    size1,
>>>>>>> afc-webdev-c
                    size2,
                    size3,
                    speciality,
                    material,
                    spacing,
                    coating,
<<<<<<< HEAD
                    weight_lbs: weightLbs,
                    cat_id_fk: catIdFk,
                    img_small: imgSmall,
                    img_large: imgLarge,
                    free_shipping: freeShipping,
                    special_shipping: specialShipping,
                    amount_per_box: amountPerBox,
                    desc_short: descShort,
                    desc_long: descLong,
                    ship_length: shipLength,
                    ship_width: shipWidth,
                    ship_height: shipHeight,
                    categories_id: categoriesId,
                    shipping_method: shippingMethod,
=======
                    weight,
                    family_category: familyCategory,
                    general_image: generalImage,
                    small_image: smallImage,
                    large_image: largeImage,
                    free_shipping: freeShipping,
                    special_shipping: specialShipping,
                    amount_per_box: amountPerBox,
                    description,
                    subcategory_id: subcategoryId,
                    shipping_length: shippingLength,
                    shipping_width: shippingWidth,
                    shipping_height: shippingHeight,
                    shipping_class: shippingClass,
>>>>>>> afc-webdev-c
                    quantity,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Show toast notification
                        const toastEl = document.getElementById("cartToast");
                        if (toastEl) {
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }

                        // Update cart count
                        const cartCountElement =
                            document.getElementById("cart-count");
                        if (cartCountElement)
                            cartCountElement.textContent = data.cartCount;

                        // Update mini cart
                        if (typeof updateMiniCart === "function") {
                            updateMiniCart(data.cart);
                        }
                    } else {
                        alert("Failed to add item to cart.");
                    }
                })
                .catch((error) => console.error("Error:", error));
        }
    });
});
