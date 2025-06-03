const App = {
    appName: "MyApp",
    url: "http://localhost:8000", //window.APP_URL,
    init: function() {
        console.log("App initialized");
        // Add any initialization logic here
    },
    getFilter: function(triggerElement) {
        const productList = $("#product-report-table");
        // Display the loading message
        productList.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
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
                url: `${this.url}/ams/products-report/filter/`,
                type: "POST",
                data: formData,
                contentType: "application/x-www-form-urlencoded",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    productList.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
    },
    // This function opens a bootstrap modal with the given ID
    openModal: function(id,modalId) {
        const productList = $("#modal-html");
        // Display the loading message
        productList.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-light" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
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
                productList.html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching products:", error);
                // Optionally clear the loading message or show an error message
                productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
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
    // Function to add a product to the cart
    $(".add-to-cart").on("click", function() {
        const productId = $(this).data("product-id");
        if (!productId) {
            console.warn("Invalid product ID or quantity.");
            return;
        }
        console.log(App.url);
        console.log("Updating quantity for product ID:", productId, "to", quantity);
        $.ajax({
            url: `${App.url}/cart2/add-to-cart/p/${productId}`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                // Optionally update cart UI or show a message
                console.log("Quantity updated successfully:", response);
                $('.cart-count').text(response.cartCount); // Update cart count
                //$("#alert-container").html('<div class="alert alert-success" role="alert">Quantity updated!</div>').fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                //$("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });

        console.log("Updated cart count for all elements.");
    });
    // Function to update the quantity of a product in the cart
    $(".incre-qty").on("change", function() {
        const productId = $(this).data("product-id");
        const quantity = $(this).val();
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
                $('.cart-count').text(response.cartCount); // Update cart count
                console.log("Quantity updated successfully:", response);
                //$("#alert-container").html('<div class="alert alert-success" role="alert">Quantity updated!</div>').fadeIn().delay(1000).fadeOut();
            },
            error: function(xhr, status, error) {
                const errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                //$("#alert-container").html('<div class="alert alert-danger" role="alert">' + errorMessage + '</div>');
            }
        });
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
        const productList = $("#product-report-table");
        console.log("Selected subcategory:", selectedSubcategory);
        // Display the loading message
        productList.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        setTimeout(function() {
            $.ajax({
                url: `${appParams.url}/products-report/cat/${selectedSubcategory}`,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    productList.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 500); // Added missing closing brace for setTimeout
    });
    // Search functionality
    $("#search-products").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        const productList = $("#product-report-table");
        
        if (searchTerm.length < 1) return;
        // Display the loading message
        productList.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

        setTimeout(function() {
            $.ajax({
                url: `${appParams.url}/products-report/search/${searchTerm}`,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    productList.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 100); // Added missing closing brace for setTimeout
    });
    //Search Customers
    $("#customer-search").on("click", function() {
        const searchTerm = $(this).val().toLowerCase();
        const productList = $(".customer-results");
        console.log("Search term:", searchTerm);
        return;
        if (searchTerm.length < 1) return;
        setTimeout(function() {
            $.ajax({
                url: `${appParams.url}/search-customer/${searchTerm}`,
                type: "GET",
                dataType: "html",
                success: function(data) {
                    // Populate the element with id 'product-list' with the received data
                    productList.html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching products:", error);
                    // Optionally clear the loading message or show an error message
                    productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        }, 100); // Added missing closing brace for setTimeout
    });
    // Filter functionality
    // $(".input-filter").on("change", function() {
    //     if ($(this).is(":checked")) {
    //         $("#product-report-form-filter").submit();
    //     }
    // });


    // $("#product-report-form-filter").on("submit", function(event) {
    //     event.preventDefault(); // Prevent the default form submission
    //     const productList = $("#product-report-table");
    //     // Display the loading message
    //     productList.html('<div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

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
    //                 productList.html(data);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Error fetching products:", error);
    //                 // Optionally clear the loading message or show an error message
    //                 productList.html('<p class="text-danger">An error occurred. Please try again.</p>');
    //             }
    //         });
    //     }, 100);
    // });
    // Event handler for the filter checkboxes
    $(".form-check.filter").on("click", function() {
        const height = $(this).data("height");

        const productList = $("#product-list");
        // Display the loading message
        productList.html('<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

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



