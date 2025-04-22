$(document).ready(function() {
    // AJAX script to send dummy data to a URL
    const dummyData = {
        name: "John Doe",
        email: "johndoe@example.com",
        message: "This is a test message"
    };

    const url = "https://example.com/api/endpoint";

    $(".add-to-cart").on("click", function() {
        const price = $(this).data("price");
        const qty = $(this).data("qty");
        const data = {
            price: price,
            quantity: qty + 1
        };

        // Update all elements with the 'cart-count' class
        $(".cart-count").each(function() {
            const currentCount = parseInt($(this).text(), 10) || 0;
            const newCount = currentCount + 1;
            $(this).text(newCount);
        });

        console.log("Updated cart count for all elements.");
        console.log("Data object:", data);
    });

    $(".system-complete-card").hover(
        function() {
            $(this).find(".prod-detail").show();
        },
        function() {
            $(this).find(".prod-detail").hide();
        }
    );

    $(".form-check.filter").on("click", function() {
        const height = $(this).data("height");

        const productList = $("#product-list");
        // Display the loading message
        productList.html('<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

        setTimeout(function() {
            $.ajax({
                url: `http://localhost:8000/academytest/height/${height}`,
                type: "GET",
                data: JSON.stringify(dummyData),
                contentType: "application/json",
                success: function(response) {
                    // Handle success response here
                    console.log("Data sent successfully:", response);
                    // Populate the element with id 'product-list' with the returned data
                    productList.html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error sending data:", error);
                    // Optionally clear the loading message or show an error message
                    productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 1000); // Added missing closing brace for setTimeout
        //sendDataToServer(dummyData); // Call the function to send data to the server
        console.log("Height attribute value:", height);
    });

    // Function to send data to the server
    function sendDataToServer(url, method = "GET", data) {
        fetch(url, {
            method: method,
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(dummyData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("Data sent successfully:", data);
        })
        .catch(error => {
            console.error("Error sending data:", error);
        });
    }

});

