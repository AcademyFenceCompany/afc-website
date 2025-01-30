document
    .getElementById("calculate-shipping")
    .addEventListener("click", async function () {
        const originZip = document.getElementById("origin-zip").value;
        const destinationZip = document.getElementById("destination-zip").value;
        const weight = document.getElementById("weight").value;
        const length = document.getElementById("length").value;
        const width = document.getElementById("width").value;
        const height = document.getElementById("height").value;

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
                    shipper_address: "123 Main St.",
                    shipper_city: "New York",
                    shipper_state: "NY",
                    shipper_postal: "10001",
                    recipient_address: "401 edmund ave.",
                    recipient_city: "paterson",
                    recipient_state: "NJ",
                    recipient_postal: "07502",
                    weight: weight,
                    dimensions: { length, width, height },
                }),
            });

            const data = await response.json();
            if (data.error) {
                alert(data.error);
            } else {
                console.log("Shipping Rates:", data);
                // Display rates in the UI
            }
        } catch (error) {
            console.error("Error fetching rates:", error);
        }
    });
