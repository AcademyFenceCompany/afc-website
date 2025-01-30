document
    .getElementById("calculate-shipping")
    .addEventListener("click", async function () {
        const shipper_address =
            document.getElementById("shipper-address").value;
        const shipper_city = document.getElementById("shipper-city").value;
        const shipper_state = document.getElementById("shipper-state").value;
        const shipper_postal = document.getElementById("origin-zip").value;
        const recipient_address =
            document.getElementById("recipient-address").value;
        const recipient_city = document.getElementById("recipient-city").value;
        const recipient_state =
            document.getElementById("recipient-state").value;
        const recipient_postal =
            document.getElementById("destination-zip").value;

        let packages = [];

        const products = document.querySelectorAll(".product-item");
        products.forEach((product) => {
            const familyCategory = product.dataset.family_category; // Identify family category
            const quantity = parseInt(product.dataset.quantity);
            const weight = parseFloat(product.dataset.weight);
            const length = parseFloat(product.dataset.length);
            const width = parseFloat(product.dataset.width);
            const height = parseFloat(product.dataset.height);

            // Check if it's a welded wire product based on family category
            if (familyCategory === "5") {
                for (let i = 0; i < quantity; i++) {
                    if (weight > 150) {
                        alert(
                            `Each product of welded wire must weigh under 150 lbs for UPS Ground. Product weight: ${weight} lbs`,
                        );
                        return;
                    }
                    packages.push({
                        weight: weight.toFixed(2),
                        dimensions: {
                            length: length.toFixed(2),
                            width: width.toFixed(2),
                            height: height.toFixed(2),
                        },
                    });
                }
            } else {
                // Handle other product types, treating each quantity as a separate package
                for (let i = 0; i < quantity; i++) {
                    packages.push({
                        weight: weight.toFixed(2),
                        dimensions: {
                            length: length.toFixed(2),
                            width: width.toFixed(2),
                            height: height.toFixed(2),
                        },
                    });
                }
            }
        });

        try {
            const response = await fetch("/shipping-rates", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({
                    shipper_address: shipper_address,
                    shipper_city: shipper_city,
                    shipper_state: shipper_state,
                    shipper_postal: shipper_postal,
                    recipient_address: recipient_address,
                    recipient_city: recipient_city,
                    recipient_state: recipient_state,
                    recipient_postal: recipient_postal,
                    packages: packages, // Send packages array
                }),
            });

            const data = await response.json();
            if (data.error) {
                alert(data.error);
            } else {
                console.log("Shipping Rates:", data);
                const ratesContainer =
                    document.getElementById("shipping-rates");
                ratesContainer.innerHTML = ""; // Clear previous rates

                data.RateResponse.RatedShipment.forEach((shipment) => {
                    const serviceCode = shipment.Service.Code;
                    const totalCharges = shipment.TotalCharges.MonetaryValue;

                    // Only display UPS Ground (Service Code: 03)
                    if (serviceCode === "03") {
                        const rateElement = document.createElement("div");
                        rateElement.classList.add("rate-option");
                        rateElement.innerHTML = `
                            <label class="d-block">
                                <input type="radio" name="shipping_option" class="shipping-option"
                                    data-charge="${totalCharges}" value="${serviceCode}">
                                UPS Ground - $${totalCharges}
                            </label>
                        `;
                        ratesContainer.appendChild(rateElement);
                    }
                });

                // Add event listeners for updating total price
                document
                    .querySelectorAll(".shipping-option")
                    .forEach((option) => {
                        option.addEventListener("change", updateTotalPrice);
                    });
            }
        } catch (error) {
            console.error("Error fetching rates:", error);
        }
    });

function updateTotalPrice() {
    const selectedOption = document.querySelector(
        'input[name="shipping_option"]:checked',
    );
    if (!selectedOption) return;

    const shippingCost = parseFloat(selectedOption.dataset.charge);
    const totalAmountElement = document.getElementById("total-amount");
    const initialTotal = parseFloat(totalAmountElement.dataset.total);
    const newTotal = initialTotal + shippingCost;

    document.getElementById("shipping-cost").classList.remove("d-none");
    document.getElementById("shipping-cost-value").textContent =
        `$${shippingCost.toFixed(2)}`;
    totalAmountElement.textContent = `$${newTotal.toFixed(2)}`;
}
