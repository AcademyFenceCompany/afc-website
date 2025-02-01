document
    .getElementById("calculate-shipping")
    .addEventListener("click", async function () {
        const recipient_address =
            document.getElementById("recipient-address").value;
        const recipient_city = document.getElementById("recipient-city").value;
        const recipient_state =
            document.getElementById("recipient-state").value;
        const recipient_postal =
            document.getElementById("destination-zip").value;

        let packages = [];
        let totalWeight = 0;

        // Collect package details
        const products = document.querySelectorAll(".product-item");
        products.forEach((product) => {
            const quantity = parseInt(product.dataset.quantity);
            const weight = parseFloat(product.dataset.weight);
            const length = parseFloat(product.dataset.length);
            const width = parseFloat(product.dataset.width);
            const height = parseFloat(product.dataset.height);

            // Calculate total weight
            totalWeight += weight * quantity;

            // Add package details
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
        });

        const ratesContainer = document.getElementById("shipping-rates");
        ratesContainer.innerHTML = ""; // Clear previous rates

        // Add loading spinner
        const loadingSpinner = document.createElement("div");
        loadingSpinner.classList.add("loading-spinner");
        loadingSpinner.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p>Fetching shipping rates...</p>
        `;
        ratesContainer.appendChild(loadingSpinner);

        try {
            // Handle cases where totalWeight >= 150
            if (totalWeight >= 150) {
                // Only call TForce API
                const tforceResponse = await fetch("api/tforce-rates", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        recipient_address,
                        recipient_city,
                        recipient_state,
                        recipient_postal,
                        packages,
                    }),
                }).then((res) => res.json());

                ratesContainer.innerHTML = ""; // Clear the spinner

                // Handle TForce response
                if (tforceResponse.detail && tforceResponse.detail.length > 0) {
                    tforceResponse.detail.forEach((shipment) => {
                        if (shipment.service.code === "308") {
                            const totalCharges =
                                shipment.shipmentCharges.total.value;

                            const rateElement = document.createElement("div");
                            rateElement.classList.add("rate-option");
                            rateElement.innerHTML = `
                                <label class="d-block">
                                    <input type="radio" name="shipping_option" class="shipping-option"
                                        data-charge="${totalCharges}" value="tforce-ltl">
                                    TForce Freight LTL - $${totalCharges} 
                                    (Transit Time: ${shipment.timeInTransit.timeInTransit} Day(s))
                                </label>
                            `;
                            ratesContainer.appendChild(rateElement);
                        }
                    });
                } else {
                    ratesContainer.innerHTML = `
                        <div class="alert alert-info">
                            No TForce rates available for packages over 150 lbs.
                        </div>`;
                }
            } else {
                // Only call UPS API
                const upsResponse = await fetch("api/ups-rates", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        recipient_address,
                        recipient_city,
                        recipient_state,
                        recipient_postal,
                        packages,
                    }),
                }).then((res) => res.json());

                ratesContainer.innerHTML = ""; // Clear the spinner

                // Handle UPS response
                if (
                    upsResponse.RateResponse &&
                    upsResponse.RateResponse.RatedShipment.length > 0
                ) {
                    upsResponse.RateResponse.RatedShipment.forEach(
                        (shipment) => {
                            if (shipment.Service.Code === "03") {
                                const totalCharges =
                                    shipment.TotalCharges.MonetaryValue;

                                const rateElement =
                                    document.createElement("div");
                                rateElement.classList.add("rate-option");
                                rateElement.innerHTML = `
                                    <label class="d-block">
                                        <input type="radio" name="shipping_option" class="shipping-option"
                                            data-charge="${totalCharges}" value="ups-ground">
                                        UPS Ground - $${totalCharges}
                                    </label>
                                `;
                                ratesContainer.appendChild(rateElement);
                            }
                        },
                    );
                } else {
                    ratesContainer.innerHTML = `
                        <div class="alert alert-info">
                            No UPS Ground rates available for packages under 150 lbs.
                        </div>`;
                }
            }

            // Fallback: No rates available at all
            if (!ratesContainer.innerHTML.trim()) {
                ratesContainer.innerHTML = `
                    <div class="alert alert-warning">
                        No shipping options available for the entered details. Please try again or contact support.
                    </div>`;
            }

            // Update total price when a shipping option is selected
            document.querySelectorAll(".shipping-option").forEach((option) => {
                option.addEventListener("change", updateTotalPrice);
            });
        } catch (error) {
            console.error("Error fetching rates:", error);
            ratesContainer.innerHTML = `
                <div class="alert alert-danger">
                    Failed to fetch shipping rates. Please try again.
                </div>`;
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
