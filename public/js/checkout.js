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

        let totalWeight = 0;
        let maxLength = 0;
        let maxWidth = 0;
        let totalHeight = 0;

        const products = document.querySelectorAll(".product-item");
        products.forEach((product) => {
            const weight =
                parseFloat(product.dataset.weight) *
                parseInt(product.dataset.quantity);
            const length = parseFloat(product.dataset.length);
            const width = parseFloat(product.dataset.width);
            const height = parseFloat(product.dataset.height);

            totalWeight += weight;
            maxLength = Math.max(maxLength, length);
            maxWidth = Math.max(maxWidth, width);
            totalHeight += height;
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
                    shipper_address,
                    shipper_city,
                    shipper_state,
                    shipper_postal,
                    recipient_address,
                    recipient_city,
                    recipient_state,
                    recipient_postal,
                    weight: totalWeight.toFixed(2),
                    dimensions: {
                        length: maxLength.toFixed(2),
                        width: maxWidth.toFixed(2),
                        height: totalHeight.toFixed(2),
                    },
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

                // 🔍 **Filter Only UPS Ground (Service Code: "03")**
                const groundShipment = data.RateResponse.RatedShipment.find(
                    (shipment) => shipment.Service.Code === "03",
                );

                if (groundShipment) {
                    const serviceCode = groundShipment.Service.Code;
                    const totalCharges =
                        groundShipment.TotalCharges.MonetaryValue;
                    const deliveryTime =
                        groundShipment.GuaranteedDelivery?.DeliveryByTime ||
                        "N/A";

                    const rateElement = document.createElement("div");
                    rateElement.classList.add("rate-option");
                    rateElement.innerHTML = `
                        <label class="d-block">
                            <input type="radio" name="shipping_option" class="shipping-option"
                                data-charge="${totalCharges}" value="${serviceCode}">
                            <strong>UPS Ground:</strong> $${totalCharges} (Delivery: ${deliveryTime})
                        </label>
                    `;
                    ratesContainer.appendChild(rateElement);

                    // Add event listener for updating total price when selected
                    document
                        .querySelectorAll(".shipping-option")
                        .forEach((option) => {
                            option.addEventListener("change", updateTotalPrice);
                        });
                } else {
                    ratesContainer.innerHTML =
                        "<p class='text-danger'>No UPS Ground rates available.</p>";
                }
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
