const App = {
    appName: "MyApp",
    url: 'http://localhost:8000',//window.APP_URL,
    init: function() {
        console.log("App initialized... ", this.url);
        // Add any initialization logic here
    },
    getFilter: function(triggerElement) {
        const result = $("#product-report-table");
        // Display the loading message
        result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        const formElement = $(triggerElement); // Find the closest form element
        if (formElement.length === 0) {
            console.error("Form with ID 'product-report-form-filter' not found.");
            return;
        }
        const formData = formElement.serialize(); // Serialize the form data
        if (!formData) {
            console.warn("Form data is empty. Ensure the form has valid input fields with values.");
        }
        console.log("Serialized form data:", formData);

            $.ajax({
                url: `${this.url}/ams/products-report/filter`,
                type: "POST",
                data: formData,
                contentType: "application/x-www-form-urlencoded",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    result.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    result.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
    },
    // This function opens a bootstrap modal with the given ID
    openModal: function(id,modalId) {
        const result = $("#modal-html");
        // Display the loading message
        result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        const modal = new bootstrap.Modal(document.getElementById(modalId), {
            keyboard: false // Disable closing the modal with the keyboard
        });
        $.ajax({
            url: `${this.url}/products-report/${id}`,
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            dataType: "html",
            success: function(data) {
                // Populate the element with id 'product-list' with the received data
                result.html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching products:", error);
                // Optionally clear the loading message or show an error message
                result.html('<p class="text-danger">An error occurred. Please try again.</p>');
            }
        });
        console.log("Product ID:", id);
        modal.show();
    },
    // This function is used to submit the form in the modal
    submitForm: function(triggerElement) {
        const formElement = $(triggerElement);
        // formElement.on("submit", function(event) {
        //     event.preventDefault(); // Prevent the default form submission
        // });
        //const formElement = $(triggerElement);
        const formData = formElement.serialize(); // Serialize the form data
        console.log("Serialized form data:", formData);
        if (!formData) {
            console.warn("Form data is empty. Ensure the form has valid input fields with values.");
        }
        $.ajax({
            url: `${this.url}/ams/products-report/edit/`,
            type: "POST",
            data: formData,
            contentType: "application/x-www-form-urlencoded",
            dataType: "JSON",
            success: function(data) {
                // Populate the element with id 'product-list' with the received data
                $("#alert-container").html('<div class="alert alert-success" role="alert">' + data.message + '</div>');
                $("#alert-container").fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error, data) {
                console.error("Error fetching products:", xhr, status, error);
                // Optionally clear the loading message or show an error message
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                $("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });

    },
    // This function renders a list group for the cart items
    renderCartListGroup: function(cart2) {
        let html = '<ul class="list-group list-group-flush">';
        for (const key in cart2.items) {
            if (cart2.items.hasOwnProperty(key)) {
                const item = cart2.items[key];
                html += `
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">${item.name}</h6>
                            <small class="text-body-secondary">Quantity: ${item.quantity}</small>
                        </div>
                        <span class="text-body-secondary">$${parseFloat(item.price).toFixed(2)}</span>
                    </li>
                `;
            }
        }
        html += '</ul>';
        return html;
    }
};

// Attach event listener to trigger App.getFilter on input change
// $(document).on("change", ".input-filter", function() {
//     App.getFilter();
// });

// // Attach event listener to trigger App.getFilter on click
// $(document).on("click", ".input-filter", function() {
//     App.getFilter();
// });

App.init();
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dropdown-menu').on("click", function (e) {
        $(this).parent().is(".open") && e.stopPropagation();
    });

    // Initialize tooltip for .ams-cart-item inputs, including dynamically loaded ones
    $('.ams-cart-item').each(function () {
        console.log("Initializing tooltip for input:", this);
        const input = $(this);
        // Set initial tooltip content
        input.attr('data-bs-title', input.val());
        const tooltip = new bootstrap.Tooltip(this, {
            trigger: 'manual'
        });

        function showAndUpdateTooltip() {
            const value = input.val();
            tooltip.setContent({ '.tooltip-inner': value });
            tooltip.show();
        }

        input.on('focus input', function () {
            showAndUpdateTooltip();
        });

        input.on('blur', function () {
            tooltip.hide();
        });
    });

    // This method is is used to submit the filter form, send an AJAX request, and update the product report table
    $("#ams-store-form-filter").on("change", "input, select, textarea", function(event) {
        $("#ams-store-form-filter").submit();
    });

    $("#ams-store-form-filter").on("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission
        const result = $("#product-report-table");
        // Display the loading message
        result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        setTimeout(() => {
            const formData = $(this).serialize(); // Serialize the form data
            console.log("Serialized form data:", formData);
            if (!formData) {
                console.warn("Form data is empty. Ensure the form has valid input fields with values.");
            }
            $.ajax({
                url: `${App.url}/ams/ams-storefront`,
                type: "POST",
                data: formData,
                contentType: "application/x-www-form-urlencoded",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    result.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    result.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 100); // Added missing closing brace for setTimeout
    });

    $('.selectall').click(function() {
        if ($(this).is(':checked')) {
            $('.option').prop('checked', true);
            var total = $('input[name="options[]"]:checked').length;
            $(".dropdown-text").html('(' + total + ') Selected');
            $(".select-text").html(' Deselect');
        } else {
            $('.option').prop('checked', false);
            $(".dropdown-text").html('(0) Selected');
            $(".select-text").html(' Select');
        }
    });
    $("#same-as-ship").on("change", function() {
        if ($(this).is(":checked")) {
            $(".card-billing").fadeOut();
        } else {
            $(".card-billing").fadeIn();
        }
    });
    $("input[type='checkbox'].justone").change(function(){
        var a = $("input[type='checkbox'].justone");
        if(a.length == a.filter(":checked").length){
            $('.selectall').prop('checked', true);
            $(".select-text").html(' Deselect');
        }
        else {
            $('.selectall').prop('checked', false);
            $(".select-text").html(' Select');
        }
    var total = $('input[name="options[]"]:checked').length;
    $(".dropdown-text").html('(' + total + ') Selected');
    });
    $("#zip").on("keyup", function() {
        const zipValue = $(this).val();
        const uType = $(this).data("type");
        console.log("User type:", uType);
        console.log("Zip code entered:", zipValue);
        // Check if zipValue is a valid US ZIP code (5 digits or 5+4 format)
        if (!zipValue) {
            console.warn("Zip code is empty.");
            return;
        }
        const zipRegex = /^\d{5}(-\d{4})?$/;
        if (!zipRegex.test(zipValue)) {
            console.warn("Invalid zip code format.");
            return;
        }
        const shippingOptions = $("#shipping-options");
        // Show loading spinner
        shippingOptions.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $.ajax({
            url: `${App.url}/shipping2/${uType}/${zipValue}`,
            type: "GET",
            //data: { zip: zipValue },
            dataType: "html",
            success: function(data) {
                shippingOptions.html(data);
            },
            error: function(xhr, status, error) {
                shippingOptions.html('<p class="text-danger">An error occurred. Please try again.</p>');
                console.error("Error fetching shipping options:", error);
            }
        });
    });

    $(document).on("click", "input[name='shipmethod']", function() {
        const selectedValue = $(this).val();
        console.log("Selected shipping method:", selectedValue);
        $.ajax({
            url: `${App.url}/cart2/update-shipmethod/${selectedValue}`,
            type: "GET",
            //data: { shipmethod: selectedValue },
            success: function(response) {
                console.log("Shipping method updated:", response);
                // Optionally update UI or show a message
                const cartHtml = App.renderCartListGroup(response.cart2);
                $('#mini-shopping-cart').html(cartHtml); // Make sure you have a <div id="cart-container"></div> in your HTML
                $('.cart-count').text(response.cartCount); // Update cart count
                $('.cart-total').text(`$${parseFloat(response.cart2.total).toFixed(2)}`); // Update total price
                $('.shipping-cost').text(`$${parseFloat(response.cart2.shipping_cost).toFixed(2)}`); // Update total price
                $('.cart-tax').text(`$${parseFloat(response.cart2.tax).toFixed(2)}`); // Update tax
                $('.mini-cart-subtotal').text(`$${parseFloat(response.cart2.subtotal).toFixed(2)}`); // Update total price
            },
            error: function(xhr, status, error) {
                console.error("Error updating shipping method:", error);
            }
        });
    });
    ///////////////////////////////////
    // AJAX script to send dummy data to a URL
    const dummyData = {
        name: "John Doe",
        email: "johndoe@example.com",
        message: "This is a test message"
    };
    // application parameters
    const appParams = {
        appName: "MyApp",
        url: App.url,
    }
        // Function to update the quantity of a product in the cart
    $(document).on("click", ".incre-qty", function() {

        const productId = $(this).data("product-id");
        const quantity = $(this).val();
        //console.log("Product ID:", productId, "Quantity:", quantity);
        //return;
        if (!productId || quantity < 1) {
            console.warn("Invalid product ID or quantity.");
            return;
        }
        console.log(App.url);
        console.log("Updating quantity for product ID:", productId, "to", quantity);
        $.ajax({
            url: `${App.url}/cart2/update-qty/p/${productId}/q/${quantity}`,
            type: "GET",
            // data: {
            //     id: productId
            // },
            dataType: "json",
            success: function(response) {
                // Optionally update cart UI or show a message
                console.log("Quantity updated successfully:", response);
                const cartHtml = App.renderCartListGroup(response.cart2);
                $('#mini-shopping-cart').html(cartHtml); // Make sure you have a <div id="cart-container"></div> in your HTML
                $('.cart-count').text(response.cartCount); // Update cart count
                $('.mini-cart-subtotal').text(`$${parseFloat(response.cart2.subtotal).toFixed(2)}`); // Update total price
                $('.cart-tax').text(`$${parseFloat(response.cart2.tax).toFixed(2)}`); // Update tax
                $('.cart-total').text(`$${parseFloat(response.cart2.total).toFixed(2)}`); // Update total price
                $('.cart-weight').text(`${parseFloat(response.cart2.weight).toFixed(2)} lbs`); // Update total weight
                console.log("Quantity updated successfully:", response);

                //$("#alert-container").html('<div class="alert alert-success" role="alert">Quantity updated!</div>').fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                //$("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });
    });
    // Function to add a product to the cart
    $(document).on("click", ".add-to-cart", function() {
        const productId = $(this).data("product-id");
        if (!productId) {
            console.warn("Invalid product ID or quantity.");
            return;
        }
        console.log(App.url, window.APP_URL);
        console.log("Updating quantity for product ID:", productId);
        $.ajax({
            url: `${App.url}/cart2/add-to-cart/p/${productId}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Optionally update cart UI or show a message
                console.log("Quantity updated successfully:", response);
                const cartHtml = App.renderCartListGroup(response.cart2);
                $('#mini-shopping-cart').html(cartHtml); // Make sure you have a <div id="cart-container"></div> in your HTML
                $('.cart-count').text(response.cartCount).removeClass('d-none'); // Update cart count and add Bootstrap show class
                $('.mini-cart-subtotal').text(`$${parseFloat(response.cart2.subtotal).toFixed(2)}`); // Update total price
                //$("#alert-container").html('<div class="alert alert-success" role="alert">Quantity updated!</div>').fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                //$("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });

        console.log("Updated cart count for all elements.");
    });

    // Function to remove a product from the cart
    $(".remove-from-cart").on("click", function() {
        const productId = $(this).data("product-id");
        if (!productId) {
            console.warn("Invalid product ID.");
            return;
        }
        $(this).closest('.cart-item').remove();

        console.log("Removing product ID:", productId);
        $.ajax({
            url: `${App.url}/cart2/remove-item/p/${productId}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                $(this).closest('.cart-item').remove();
                // Optionally update cart UI or show a message
                console.log("Product removed successfully:", response);
                const cartHtml = App.renderCartListGroup(response.cart2);
                $('#mini-shopping-cart').html(cartHtml); // Make sure you have a <div id="cart-container"></div> in your HTML
                $('.cart-count').text(response.cartCount); // Update cart count
                $('.mini-cart-subtotal').text(`$${parseFloat(response.cart2.subtotal).toFixed(2)}`); // Update total price
                $('.cart-tax').text(`$${parseFloat(response.cart2.tax).toFixed(2)}`); // Update tax
                $('.cart-total').text(`$${parseFloat(response.cart2.total).toFixed(2)}`); // Update total price
                $('.cart-weight').text(`${parseFloat(response.cart2.weight).toFixed(2)} lbs`); // Update total weight
                //$("#alert-container").html('<div class="alert alert-success" role="alert">Product removed!</div>').fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                //$("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });
        console.log("Updated cart count for all elements.");
    });
    $(".system-complete-card").hover(
        function() {
            $(this).find(".prod-detail").show();
        },
        function() {
            $(this).find(".prod-detail").hide();
        }
    );
    // Event handler to load subcategories on major category selection change
    $("#majcat_id").on("click", function() {
        const selectedCategory = $(this).val();
        const subcategorySelect = $("#subcat_id");
        console.log("Selected category:", selectedCategory);
        // Clear previous options
        subcategorySelect.empty().append('<option>Loading...</option>');

        if (selectedCategory) {
            $.ajax({
            url: `${App.url}/subcatlist/${selectedCategory}`,
            type: "GET",
            dataType: "html",
            success: function(data) {
                // Populate the subcategory select element with the received data
                subcategorySelect.empty().html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching subcategories:", error);
                subcategorySelect.empty().append('<option class="text-danger">Error loading subcategories</option>');
            }
            });
        } else {
            subcategorySelect.empty().append('<option>Select a category first</option>');
        }
    });
    // Print products report result table when the button is clicked
    $("#print-prod-report").on("click", function() {
        // Hide the form and other elements you don't want to print
        const formElement = $("#product-report-form-filter, d-print-none");
        formElement.hide();

        const printContent = document.getElementById("product-report-table").innerHTML;
        const printWindow = window.open("", "_blank");
        printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
        printWindow.document.write("<html><head><title>Print Report</title></head><body>");
        printWindow.document.write(printContent);
        printWindow.document.write("</body></html>");

        printWindow.document.close();
        printWindow.print();

        // Show the form again after printing
        formElement.show();
    });
    // Reset the subcategory select element when the page loads
    $("#subcat_id").empty().append('<option>-- Sub-Category --</option>');
    // Even handler to get products list on subcategory selection change
    $("#subcat_id").on("change", function() {
        const selectedSubcategory = $(this).val();
        const result = $("#product-report-table");
        console.log("Selected subcategory:", selectedSubcategory);
        // Display the loading message
        result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        setTimeout(function() {
            $.ajax({
                url: `${appParams.url}/products-report/cat/${selectedSubcategory}`,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    result.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    result.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 500); // Added missing closing brace for setTimeout
    });
    // Set Order Status Date
    $(document).on("click", ".add-date", function() {
        const input = $(this).siblings('input[type="date"], input.order-date').first();
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${yyyy}-${mm}-${dd}`;
        input.val(formattedDate);
    });
    // Global search functionality
    $(".global-search").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        const result = $("#global-search");
        console.log("Search term:", searchTerm);

        if (searchTerm.length < 1) return;
        $.ajax({
            url: `${App.url}/global-search`,
            type: "POST",
            data: { search: searchTerm },
            dataType: "html",
            success: function(data) {
                // Populate the element with id 'product-list' with the received data
                result.html(data);
                result.addClass('show');
                // result.fadeOut(150, function() {
                //     result.html(data);
                //     result.addClass('show');
                //     result.fadeIn(150);
                // });

            },
            error: function(xhr, status, error) {
                console.error("Error fetching products:", error);
                // Optionally clear the loading message or show an error message
                result.html('<p class="text-danger">An error occurred. Please try again.</p>');
            }
        });

    });
    // Delay to allow click on result
    $('.global-search').on('blur', function() {
        $("#global-search").removeClass('show');
    });
    // Search functionality for products
    // This will search products based on the input in the search field with id 'search-products'
    // and update the results in the element with id 'product-report-table'
    $("#search-products").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        const result = $("#product-report-table");

        if (searchTerm.length < 1) return;
        // Display the loading message
        result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        setTimeout(function() {
            $.ajax({
                url: `${appParams.url}/products-report/search/${searchTerm}`,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    result.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    result.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 100); // Added missing closing brace for setTimeout
    });
    //Search Customers
    $("#customer-search, .customer-search").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        const result = $(".search-results");
        console.log("Search term:", searchTerm);

        if (searchTerm.length < 1) return;
        $.ajax({
            url: `${App.url}/search-customer`,
            type: "POST",
            data: { search: searchTerm },
            dataType: "html",
            success: function(data) {
                // Populate the element with id 'product-list' with the received data
                result.html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching products:", error);
                // Optionally clear the loading message or show an error message
                result.html('<p class="text-danger">An error occurred. Please try again.</p>');
            }
        });
    });
    // Filter functionality
    // $(".input-filter").on("change", function() {
    //     if ($(this).is(":checked")) {
    //         $("#product-report-form-filter").submit();
    //     }
    // });


    // $("#product-report-form-filter").on("submit", function(event) {
    //     event.preventDefault(); // Prevent the default form submission
    //     const result = $("#product-report-table");
    //     // Display the loading message
    //     result.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

    //     setTimeout(() => {
    //         const formData = $(this).serialize(); // Serialize the form data

    //         $.ajax({
    //             url: `${appParams.url}/ams/products-report/filter/`,
    //             type: "POST",
    //             data: formData,
    //             contentType: "application/x-www-form-urlencoded",
    //             dataType: "html",
    //             success: function(data) {
    //                 // Populate the element with id 'product-list' with the received data
    //                 result.html(data);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Error fetching products:", error);
    //                 // Optionally clear the loading message or show an error message
    //                 result.html('<p class="text-danger">An error occurred. Please try again.</p>');
    //             }
    //         });
    //     }, 100);
    // });
    // Event handler for the filter checkboxes
    $(".form-check.filter").on("click", function() {
        const height = $(this).data("height");

        const result = $("#product-list");
        // Display the loading message
        result.html('<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

        setTimeout(function() {
            $.ajax({
                url: `${App.url}/academytest/height/${height}`,
                type: "GET",
                data: JSON.stringify(dummyData),
                contentType: "application/json",
                success: function(response) {
                    // Handle success response here
                    console.log("Data sent successfully:", response);
                    // Populate the element with id 'product-list' with the returned data
                    result.html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error sending data:", error);
                    // Optionally clear the loading message or show an error message
                    result.html('<p class="text-danger">An error occurred. Please try again.</p>');
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


// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()



