document
    .getElementById("calculate-shipping")
    .addEventListener("click", async function () {
        // const shipper_address =
        //     document.getElementById("shipper-address").value;
        // const shipper_city = document.getElementById("shipper-city").value;
        // const shipper_state = document.getElementById("shipper-state").value;
        // const shipper_postal = document.getElementById("origin-zip").value;
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
            const quantity = parseInt(product.dataset.quantity);
            const weight = parseFloat(product.dataset.weight);
            const length = parseFloat(product.dataset.length);
            const width = parseFloat(product.dataset.width);
            const height = parseFloat(product.dataset.height);

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

        try {
            const [upsResponse, tforceResponse] = await Promise.all([
                fetch("api/ups-rates", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        // shipper_address,
                        // shipper_city,
                        // shipper_state,
                        // shipper_postal,
                        recipient_address,
                        recipient_city,
                        recipient_state,
                        recipient_postal,
                        packages,
                    }),
                }).then((res) => res.json()),
                fetch("api/tforce-rates", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        // shipper_address,
                        // shipper_city,
                        // shipper_state,
                        // shipper_postal,
                        recipient_address,
                        recipient_city,
                        recipient_state,
                        recipient_postal,
                        packages,
                    }),
                }).then((res) => res.json()),
            ]);

            const ratesContainer = document.getElementById("shipping-rates");
            ratesContainer.innerHTML = "";

            // Filter and show UPS Ground
            if (upsResponse.RateResponse) {
                upsResponse.RateResponse.RatedShipment.forEach((shipment) => {
                    if (shipment.Service.Code === "03") {
                        const totalCharges =
                            shipment.TotalCharges.MonetaryValue;

                        const rateElement = document.createElement("div");
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
                });
            }

            // Filter and show TForce LTL
            if (tforceResponse.detail) {
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
            }

            // Update total price on selection
            document.querySelectorAll(".shipping-option").forEach((option) => {
                option.addEventListener("change", updateTotalPrice);
            });
        } catch (error) {
            console.error("Error fetching rates:", error);
            document.getElementById("shipping-rates").innerHTML = `
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
