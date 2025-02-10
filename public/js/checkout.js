document
    .getElementById("calculate-shipping")
    .addEventListener("click", async function () {
        const recipient_address =
            document.getElementById("recipient-address").value;
        const recipient_city = document.getElementById("recipient-city").value;
        const recipient_state =
            document.getElementById("recipient-state").value;
        let stateMarkup = 0;

        try {
            const markupResponse = await fetch(
                `/api/state-markup/${recipient_state}`,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                },
            );

            const markupData = await markupResponse.json();
            stateMarkup = parseFloat(markupData.markup) || 0; // Default to 0 if no markup found
        } catch (error) {
            console.error("Error fetching state markup:", error);
        }

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
            console.log(weight, length, width, height);

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
            if (totalWeight >= 150) {
                // Call **TForce API**
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

                let hasRates = false;

                // **Handle TForce Response**
                if (tforceResponse.detail && tforceResponse.detail.length > 0) {
                    hasRates = true;
                    tforceResponse.detail.forEach((shipment) => {
                        const serviceCode = shipment.service.code;

                        // Map TForce service codes to readable names
                        const serviceNames = {
                            308: "Standard LTL",
                            309: "Economy",
                            310: "Guaranteed LTL",
                            311: "Guaranteed AM",
                            312: "Guaranteed PM",
                        };

                        const serviceName =
                            serviceNames[serviceCode] ||
                            `Service ${serviceCode}`;

                        // Base price
                        const basePrice = parseFloat(
                            shipment.shipmentCharges.total.value,
                        );

                        // Apply 33% markup
                        const thirtyThreeMarkup = basePrice / (1 - 0.33);

                        // Add state markup
                        const totalCharges = thirtyThreeMarkup + stateMarkup;

                        const rateElement = document.createElement("div");
                        rateElement.classList.add("rate-option");
                        rateElement.innerHTML = `
                            <label class="d-block">
                                <input type="radio" name="shipping_option" class="shipping-option"
                                    data-charge="${totalCharges}" value="tforce-${serviceCode}">
                                TForce Freight (${serviceName}) - 
                                $${parseFloat(totalCharges).toFixed(2)}
                                (Transit Time: ${shipment.timeInTransit.timeInTransit} Day(s))
                            </label>
                        `;
                        ratesContainer.appendChild(rateElement);
                    });
                }

                try {
                    // Call **R&L Carriers API**
                    const rlCarriersResponse = await fetch(
                        "api/rl-carriers-rates",
                        {
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
                        },
                    ).then((res) => res.json());

                    // **Handle R&L Carriers Response**
                    if (rlCarriersResponse.d && rlCarriersResponse.d.Result) {
                        hasRates = true;
                        const rlResult = rlCarriersResponse.d.Result;

                        rlResult.ServiceLevels.forEach((service) => {
                            const serviceTitle = service.Title;
                            const netCharge = parseFloat(
                                service.NetCharge.replace(/[^0-9.]/g, ""),
                            );
                            // Apply same 33% markup as TForce
                            const thirtyThreeMarkup = netCharge / (1 - 0.33);
                            const totalCharge = thirtyThreeMarkup + stateMarkup;

                            const rateElement = document.createElement("div");
                            rateElement.classList.add("rate-option");
                            rateElement.innerHTML = `
                                <label class="d-block">
                                    <input type="radio" name="shipping_option" class="shipping-option"
                                        data-charge="${totalCharge}" value="rlcarriers-${service.Code}">
                                    R&L Carriers (${serviceTitle}) - 
                                    $${totalCharge.toFixed(2)}
                                    (Transit Time: ${service.ServiceDays} Days)
                                </label>
                            `;
                            ratesContainer.appendChild(rateElement);
                        });
                    }
                } catch (rlError) {
                    console.error(
                        "Error fetching R&L Carriers rates:",
                        rlError,
                    );
                    // Don't show error if we have TForce rates
                }

                // Only show error if we have no rates at all
                if (!hasRates) {
                    ratesContainer.innerHTML = `
                        <div class="alert alert-danger">
                            Failed to fetch shipping rates. Please try again.
                        </div>`;
                }
            } else {
                // Call **UPS API**
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

                // **Handle UPS Response**
                if (
                    upsResponse.RateResponse &&
                    upsResponse.RateResponse.RatedShipment.length > 0
                ) {
                    upsResponse.RateResponse.RatedShipment.forEach(
                        (shipment) => {
                            if (shipment.Service.Code === "03") {
                                const totalCharges =
                                    shipment.TotalCharges.MonetaryValue +
                                    stateMarkup;

                                const rateElement =
                                    document.createElement("div");
                                rateElement.classList.add("rate-option");
                                rateElement.innerHTML = `
                                <label class="d-block">
                                    <input type="radio" name="shipping_option" class="shipping-option"
                                        data-charge="${totalCharges}" value="ups-ground">
                                    UPS Ground - $${shipment.TotalCharges.MonetaryValue}
                                </label>
                            `;
                                ratesContainer.appendChild(rateElement);
                            }
                        },
                    );
                }
            }
        } catch (error) {
            console.error("Error fetching rates:", error);
            ratesContainer.innerHTML = `
                <div class="alert alert-danger">
                    Failed to fetch shipping rates. Please try again.
                </div>`;
        }
    });

// Calculate initial total without shipping
function calculateSubtotal() {
    let subtotal = 0;
    const products = document.querySelectorAll(".product-item");
    products.forEach((product) => {
        const price = parseFloat(
            product.parentElement
                .querySelector(".d-flex span:last-child")
                .textContent.replace("$", ""),
        );
        const quantity = parseInt(product.dataset.quantity);
        subtotal += price * quantity;
    });
    return subtotal;
}

// Update total when shipping option is selected
document
    .getElementById("shipping-rates")
    .addEventListener("change", function (e) {
        if (e.target.classList.contains("shipping-option")) {
            const shippingCost = parseFloat(e.target.dataset.charge);

            // Show shipping cost section and update value
            const shippingCostSection =
                document.getElementById("shipping-cost");
            shippingCostSection.classList.remove("d-none");
            const shippingCostValue = document.getElementById(
                "shipping-cost-value",
            );
            if (shippingCostValue) {
                shippingCostValue.textContent = `$${shippingCost.toFixed(2)}`;
            }

            // Update total
            const subtotalElement = document.querySelector(
                ".d-flex:nth-child(6) span:last-child",
            );
            const taxElement = document.querySelector(
                ".d-flex:nth-child(7) span:last-child",
            );

            const subtotal = parseFloat(
                subtotalElement.textContent.replace("$", ""),
            );
            const tax = parseFloat(taxElement.textContent.replace("$", ""));

            const total = subtotal + tax + shippingCost;

            // Update total display
            const totalElement = document.getElementById("total-cost");
            if (totalElement) {
                totalElement.textContent = `$${total.toFixed(2)}`;
            }

            // Store selected shipping cost
            const selectedShippingInput = document.createElement("input");
            selectedShippingInput.type = "hidden";
            selectedShippingInput.name = "selected_shipping_cost";
            selectedShippingInput.value = shippingCost.toFixed(2);

            // Remove any existing shipping cost input
            const existingInput = document.querySelector(
                'input[name="selected_shipping_cost"]',
            );
            if (existingInput) {
                existingInput.remove();
            }

            // Add the new input to the form
            document
                .getElementById("checkout-form")
                .appendChild(selectedShippingInput);
        }
    });
