document.addEventListener("DOMContentLoaded", () => {
    console.log("Checkout script loaded.");

    const shippingOptionsDiv = document.getElementById("shipping-options");
    const zipInput = document.getElementById("zip");

    zipInput.addEventListener("change", async () => {
        const zip = zipInput.value;
        const city = document.getElementById("city").value;
        const state = document.getElementById("state").value;

        try {
            shippingOptionsDiv.innerHTML = "Fetching shipping rates...";
            const response = await fetch("/calculate-shipping-cost", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                },
                body: JSON.stringify({ zip, city, state }),
            });

            const data = await response.json();

            if (data.success) {
                shippingOptionsDiv.innerHTML = "";
                data.rates.forEach((rate) => {
                    const rateHTML = `<p>${rate.Service.Description}: $${rate.TotalCharges.MonetaryValue}</p>`;
                    shippingOptionsDiv.insertAdjacentHTML(
                        "beforeend",
                        rateHTML,
                    );
                });
            } else {
                shippingOptionsDiv.innerHTML = `<p>Error: ${data.message}</p>`;
            }
        } catch (error) {
            shippingOptionsDiv.innerHTML = `<p>Error fetching rates.</p>`;
        }
    });
});
