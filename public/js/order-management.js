// Order Management JavaScript
$(document).ready(function () {
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // Initialize variables
    let orderItems = [];
    let currentItemId = 1;
    let selectedProducts = [];
    let addressType = ""; // 'shipping' or 'billing'
    let productModal = new bootstrap.Modal(
        document.getElementById("productModal"),
    );
    let addressModal = new bootstrap.Modal(
        document.getElementById("addressBookModal"),
    );
    let selectedCustomerId = ""; // Track selected customer

    // Function definitions
    // Load customer addresses
    function loadCustomerAddresses(customerId) {
        if (!customerId) {
            $("#shippingAddressList, #billingAddressList").empty();
            $("#shipping-address, #billing-address-select").empty()
                .append('<option value="">Select Address</option>');
            return;
        }

        console.log("Loading addresses for customer:", customerId);
        $("#shippingAddressList, #billingAddressList").html(
            '<div class="text-center">Loading addresses...</div>'
        );

        $.ajax({
            url: `/ams/customers/${customerId}/addresses`,
            method: "GET",
            success: function (response) {
                console.log("Loaded addresses:", response);
                if (response.success && response.addresses) {
                    const addresses = response.addresses;
                    
                    // Split addresses based on flags
                    const shippingAddresses = addresses.filter(addr => addr.shipping_flag === 1);
                    const billingAddresses = addresses.filter(addr => addr.billing_flag === 1);

                    console.log("Shipping addresses:", shippingAddresses);
                    console.log("Billing addresses:", billingAddresses);

                    // Update address book lists
                    renderAddressList(shippingAddresses, "shipping");
                    renderAddressList(billingAddresses, "billing");

                    // Update address selects
                    updateAddressSelects(addresses);

                    // Store addresses in modal data for later use
                    $("#addressBookModal").data("addresses", addresses);
                } else {
                    console.error('Invalid response format:', response);
                    clearAddressLists();
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                clearAddressLists();
            }
        });
    }

    // Clear address lists and selects
    function clearAddressLists() {
        $("#shippingAddressList, #billingAddressList").html(
            '<div class="alert alert-danger">No addresses found</div>'
        );
        $("#shipping-address, #billing-address-select").empty()
            .append('<option value="">Select Address</option>');
    }

    // Render address list
    function renderAddressList(addresses, type) {
        const container = type === "shipping" ? $("#shippingAddressList") : $("#billingAddressList");
        container.empty();

        if (!addresses || addresses.length === 0) {
            container.html(
                `<div class="alert alert-info">No ${type} addresses found.</div>`
            );
            return;
        }

        addresses.forEach((address) => {
            const addressHtml = `
                <div class="form-check mb-2">
                    <input class="form-check-input address-select" 
                           type="radio" 
                           name="${type}_address" 
                           value="${address.customer_address_id}"
                           data-address-type="${type}">
                    <label class="form-check-label">
                        ${address.address_1}<br>
                        ${address.address_2 ? address.address_2 + "<br>" : ""}
                        ${address.city}, ${address.state} ${address.zipcode}
                    </label>
                </div>
            `;
            container.append(addressHtml);
        });
    }

    // Update shipping and billing address selects
    function updateAddressSelects(addresses) {
        const shippingSelect = $("#shipping-address");
        const billingSelect = $("#billing-address-select");

        // Clear existing options
        shippingSelect.empty().append('<option value="">Select Shipping Address</option>');
        billingSelect.empty().append('<option value="">Select Billing Address</option>');

        if (!addresses || addresses.length === 0) {
            return;
        }

        // Add new options
        addresses.forEach((addr) => {
            const addressText = `${addr.address_1}${addr.address_2 ? ", " + addr.address_2 : ""}, ${addr.city || ""}, ${addr.state || ""} ${addr.zipcode || ""}`;

            if (addr.shipping_flag === 1) {
                shippingSelect.append(`
                    <option value="${addr.customer_address_id}">${addressText}</option>
                `);
            }
            if (addr.billing_flag === 1) {
                billingSelect.append(`
                    <option value="${addr.customer_address_id}">${addressText}</option>
                `);
            }
        });

        console.log("Updated address selects:", {
            shippingAddresses: shippingSelect.find("option").length - 1,
            billingAddresses: billingSelect.find("option").length - 1
        });
    }

    // Load addresses into table
    function loadAddressTable(addresses) {
        console.log("Loading addresses into table:", addresses);
        const tbody = $("#addressTable tbody");

        // Remove existing address rows
        tbody.find("tr:not(#addressTableLoading, #addressTableEmpty)").remove();

        // Hide loading state
        $("#addressTableLoading").hide();

        // Store addresses in modal data for later use
        $("#addressBookModal").data("addresses", addresses);

        if (!addresses || addresses.length === 0) {
            $("#addressTableEmpty").show();
            updateAddressSelects([]); // Clear address selects
            return;
        }

        $("#addressTableEmpty").hide();

        addresses.forEach((addr) => {
            const types = [];
            if (addr.shipping_flag === 1) types.push("Shipping");
            if (addr.billing_flag === 1) types.push("Billing");

            const addressLine =
                addr.address_1 +
                (addr.address_2 ? "<br>" + addr.address_2 : "");

            tbody.append(`
                <tr data-address-id="${addr.customer_address_id}">
                    <td>${addressLine || ""}</td>
                    <td>${addr.city || ""}</td>
                    <td>${addr.state || ""}</td>
                    <td>${addr.zipcode || ""}</td>
                    <td>${types.join(", ")}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-address" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-address" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        // Update address selects
        updateAddressSelects(addresses);
    }

    // Update shipping and billing address selects
    function updateAddressSelects(addresses) {
        const shippingSelect = $("#shipping-address");
        const billingSelect = $("#billing-address-select");

        // Clear existing options
        shippingSelect
            .empty()
            .append('<option value="">Select Shipping Address</option>');
        billingSelect
            .empty()
            .append('<option value="">Select Billing Address</option>');

        // Add new options
        addresses.forEach((addr) => {
            const addressText = `${addr.address_1}${addr.address_2 ? ", " + addr.address_2 : ""}, ${addr.city || ""}, ${addr.state || ""} ${addr.zipcode || ""}`;

            if (addr.shipping_flag === 1) {
                shippingSelect.append(`
                    <option value="${addr.customer_address_id}">${addressText}</option>
                `);
            }
            if (addr.billing_flag === 1) {
                billingSelect.append(`
                    <option value="${addr.customer_address_id}">${addressText}</option>
                `);
            }
        });

        // Log for debugging
        console.log("Updated address selects:", {
            shippingAddresses: shippingSelect.find("option").length - 1,
            billingAddresses: billingSelect.find("option").length - 1,
        });
    }

    // Add selected products to order
    $("#addSelectedProducts").click(function () {
        const selectedRows = $("#productsTable tbody tr").filter(function () {
            return $(this).find(".product-select").is(":checked");
        });

        if (selectedRows.length === 0) {
            alert("Please select at least one product to add to the order.");
            return;
        }

        selectedRows.each(function () {
            const $row = $(this);
            const productId = $row.data("product-id");
            const quantity = parseInt($row.find(".product-quantity").val());
            const price = parseFloat(
                $row.find("td:eq(5)").text().replace("$", ""),
            );

            // Get product details from the row
            const product = {
                quantity: quantity,
                id: productId,
                itemNo: $row.find("td:eq(0)").text(),
                description: $row.find("td:eq(1)").text(),
                color: $row.find("td:eq(2)").text(),
                size1: $row.find("td:eq(3)").text(),
                size2: $row.find("td:eq(4)").text(),
                style: $row.find("td:eq(5)").text(),
                price: price,
                quantity: quantity,
            };

            addProductToOrder(product);
        });

        // Close modal and clear selections
        productModal.hide();
        $(".product-select").prop("checked", false);
    });

    // Add product to order table
    function addProductToOrder(product) {
        const total = product.price * product.quantity;
        const rowHtml = `
            <tr data-item-id="${currentItemId}" data-product-id="${product.id}">
                <td><input type="text" class="form-control form-control-sm editable-field" data-field="itemNo" value="${product.itemNo}"></td>
                <td><input type="text" class="form-control form-control-sm editable-field" data-field="description" value="${product.description}"></td>
                <td><input type="text" class="form-control form-control-sm editable-field" data-field="color" value="${product.color}"></td>
                <td><input type="text" class="form-control form-control-sm editable-field" data-field="size1" value="${product.size1}"></td>
                <td><input type="text" class="form-control form-control-sm editable-field" data-field="size2" value="${product.size2}"></td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control form-control-sm editable-field" data-field="price" 
                            value="${product.price}" min="0" step="0.01">
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm editable-field" data-field="quantity" 
                        value="${product.quantity}" min="1">
                </td>
                <td>$<span class="item-total">${total.toFixed(2)}</span></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger delete-item">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        // Remove "No items" row if it exists
        const tbody = $("#orderItemsTable tbody");
        if (tbody.find("tr td").length === 1) {
            tbody.empty();
        }

        // Add new row
        tbody.append(rowHtml);

        // Store item data
        orderItems.push({
            id: currentItemId,
            productId: product.id,
            itemNo: product.itemNo,
            description: product.description,
            color: product.color,
            size1: product.size1,
            size2: product.size2,
            quantity: product.quantity,
            price: product.price,
        });

        currentItemId++;
        updateOrderTotals();
        saveFormState();
    }

    // Handle editable fields
    $(document).on("change", ".editable-field", function () {
        const row = $(this).closest("tr");
        const itemId = parseInt(row.data("item-id"));
        const field = $(this).data("field");
        const value = $(this).val();

        const item = orderItems.find((i) => i.id === itemId);
        if (item) {
            // Update the item data
            item[field] =
                field === "price" || field === "quantity"
                    ? parseFloat(value)
                    : value;

            // Update the total for this item
            if (field === "price" || field === "quantity") {
                const total = item.price * item.quantity;
                row.find(".item-total").text(total.toFixed(2));
                updateOrderTotals();
            }
        }
        saveFormState();
    });

    // Delete item from order
    $(document).on("click", ".delete-item", function () {
        const row = $(this).closest("tr");
        const itemId = row.data("item-id");

        // Remove from orderItems array
        orderItems = orderItems.filter((item) => item.id !== itemId);

        // Remove row
        row.remove();

        // Show "No items" message if no items left
        if ($("#orderItemsTable tbody tr").length === 0) {
            $("#orderItemsTable tbody").html(
                '<tr><td colspan="10" class="text-center">No items added yet</td></tr>',
            );
        }

        updateOrderTotals();
        saveFormState();
    });

    // Update quantity
    $(document).on("change", ".item-quantity", function () {
        const row = $(this).closest("tr");
        const itemId = parseInt(row.data("item-id"));
        const quantity = parseInt($(this).val());

        if (isNaN(quantity) || quantity < 1) {
            $(this).val(1);
            return;
        }

        const item = orderItems.find((i) => i.id === itemId);
        if (item) {
            item.quantity = quantity;
            const total = item.price * quantity;
            row.find("td:eq(7)").text("$" + total.toFixed(2));
            updateOrderTotals();
            saveFormState();
        }
    });

    // Initialize on document ready
    $(document).ready(function () {
        // Get initial customer selection
        selectedCustomerId = $("#customerSelect").val();

        // Handle customer selection change
        $("#customerSelect").on("change", function () {
            const customerId = $(this).val();
            console.log("Selected customer ID:", customerId);

            if (customerId) {
                loadCustomerAddresses(customerId);
            } else {
                console.log("Clearing address lists");
                $("#shippingAddressList, #billingAddressList").empty();
            }
        });

        // Trigger customer selection on page load if customer is pre-selected
        const customerSelect = $("#customer-select");
        if (customerSelect.val()) {
            customerSelect.trigger("change");
        }
    });

    // Debug: Log when document is ready
    console.log("Document ready, initializing order management...");

    // Initialize category tree when modal is shown
    $("#productModal").on("shown.bs.modal", function () {
        console.log("Product modal shown, initializing category tree...");
        initializeCategoryTree();
    });

    function initializeCategoryTree() {
        // Initially collapse all nested categories
        $(".nested").hide();

        // Set up toggle buttons
        $(".category-tree .toggle-btn")
            .off("click")
            .on("click", function () {
                const $btn = $(this);
                const $icon = $btn.find("i");
                const $nested = $btn.closest("li").find("> .nested");

                $nested.slideToggle();
                $icon.toggleClass("bi-chevron-right bi-chevron-down");
            });

        // Load first category's products by default
        const $firstCategory = $(".category-link").first();
        if ($firstCategory.length) {
            $firstCategory.addClass("active");
            loadProductsByCategory($firstCategory.data("category-id"));
        }
    }

    // Show product modal
    $("#addItemsBtn").click(function () {
        productModal.show();
    });

    // Load products when category is clicked
    $(document).on("click", ".category-link", function (e) {
        e.preventDefault();
        const categoryId = $(this).data("category-id");

        // Update active state
        $(".category-link").removeClass("active");
        $(this).addClass("active");

        // Load products for this category
        loadProductsByCategory(categoryId);
    });

    // Category search functionality
    $("#categorySearch").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        $(".category-item").each(function () {
            const text = $(this).find(".category-link").text().toLowerCase();
            $(this).toggle(text.includes(searchTerm));
        });
    });

    // Load products by category
    function loadProductsByCategory(categoryId) {
        console.log("Loading products for category:", categoryId);

        // Show loading state
        $("#productsTable tbody").html(
            '<tr><td colspan="9" class="text-center">Loading products...</td></tr>',
        );

        // Make AJAX request to get products
        $.ajax({
            url: `/categories/${categoryId}/products`,
            method: "GET",
            success: function (products) {
                console.log("Products loaded:", products);
                renderProductsTable(products.products); // Access the products array from the response

                // Update active category
                $(".category-link").removeClass("active");
                $(`[data-category-id="${categoryId}"]`).addClass("active");
            },
            error: function (xhr, status, error) {
                console.error("Error loading products:", {
                    status: status,
                    error: error,
                    response: xhr.responseText,
                });
                $("#productsTable tbody").html(
                    '<tr><td colspan="9" class="text-center text-danger">Error loading products. Please try again.</td></tr>',
                );
            },
        });
    }

    // Render products in modal table
    function renderProductsTable(products) {
        console.log("Rendering products table with:", products);
        const tbody = $("#productsTable tbody");
        tbody.empty();

        if (!Array.isArray(products) || products.length === 0) {
            tbody.html(
                '<tr><td colspan="9" class="text-center">No products found in this category</td></tr>',
            );
            return;
        }

        products.forEach((product) => {
            // Ensure price is a valid number
            const price = parseFloat(product.price_per_unit) || 0;
            const row = `
                <tr data-product-id="${product.product_id}">
                    <td>${product.item_no || ""}</td>
                    <td>${product.product_name || ""}</td>
                    <td>${product.color || ""}</td>
                    <td>${product.size1 || ""}</td>
                    <td>${product.size2 || ""}</td>
                    <td>$${price.toFixed(2)}</td>
                    <td>${product.inventory?.quantity || 0}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm product-quantity" 
                               value="1" min="1" max="${product.inventory?.quantity || 999999}">
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input product-select" type="checkbox">
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });

        // Add event handler for quantity input validation
        $(".product-quantity").on("input", function () {
            const max = parseInt($(this).attr("max"));
            let val = parseInt($(this).val());
            if (isNaN(val) || val < 1) {
                $(this).val(1);
            } else if (val > max) {
                $(this).val(max);
            }
        });
    }

    // Product search functionality
    $("#productSearch").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        if (searchTerm.length >= 2) {
            $.ajax({
                url: "/ams/orders/products",
                method: "GET",
                data: { search: searchTerm },
                success: function (products) {
                    renderProductsTable(products);
                },
            });
        }
    });

    // Handle customer selection
    $("#customer-select").change(function () {
        const customerId = $(this).val();
        console.log("Selected customer ID:", customerId);

        if (!customerId) {
            loadAddressTable([]);
            return;
        }

        // Show loading state
        const tbody = $("#addressTable tbody");
        tbody.find("tr:not(#addressTableLoading, #addressTableEmpty)").remove();
        $("#addressTableLoading").show();
        $("#addressTableEmpty").hide();

        // Load customer addresses
        $.ajax({
            url: `/ams/customers/${customerId}/addresses`,
            method: "GET",
            success: function (response) {
                console.log("Addresses loaded:", response);
                if (response.success && response.addresses) {
                    loadAddressTable(response.addresses);
                } else {
                    console.error("Invalid response format:", response);
                    loadAddressTable([]);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading addresses:", error);
                loadAddressTable([]);
            },
        });
        saveFormState(); // Save state after customer selection
    });

    // Save form data to localStorage
    function saveFormState() {
        const formState = {
            customerId: $("#customer-select").val(),
            shippingAddressId: $("#shipping-address").val(),
            billingAddressId: $("#billing-address-select").val(),
            nonResidential: $("#non-residential").prop("checked"),
            origin: $('input[name="origin"]:checked').val(),
            shippingMethod: $('input[name="shipping_method"]:checked').val(),
            orderItems: orderItems,
            lastUpdated: new Date().toISOString(),
        };
        localStorage.setItem("orderFormState", JSON.stringify(formState));
        console.log("Form state saved:", formState);
    }

    // Load form data from localStorage
    function loadFormState() {
        const savedState = localStorage.getItem("orderFormState");
        if (!savedState) return;

        try {
            const formState = JSON.parse(savedState);
            console.log("Loading saved form state:", formState);

            // Restore customer selection
            if (formState.customerId) {
                $("#customer-select")
                    .val(formState.customerId)
                    .trigger("change");
            }

            // Restore other form fields
            $("#non-residential").prop(
                "checked",
                formState.nonResidential || false,
            );
            if (formState.origin) {
                $(`input[name="origin"][value="${formState.origin}"]`).prop(
                    "checked",
                    true,
                );
            }
            if (formState.shippingMethod) {
                $(
                    `input[name="shipping_method"][value="${formState.shippingMethod}"]`,
                ).prop("checked", true);
            }

            // Restore order items
            if (formState.orderItems && Array.isArray(formState.orderItems)) {
                orderItems = formState.orderItems;
                updateOrderItemsTable();
            }
        } catch (error) {
            console.error("Error loading form state:", error);
            localStorage.removeItem("orderFormState");
        }
    }

    // Load customers into select
    function loadCustomers() {
        $.get("/ams/customers/list", function (customers) {
            const select = $("#customer-select");
            select.empty().append('<option value="">Select Customer</option>');

            customers.forEach(function (customer) {
                select.append(`<option value="${customer.id}" 
                    data-email="${customer.email || ""}"
                    data-company="${customer.company_name || ""}"
                    data-phone="${customer.phone || ""}"
                    data-alt-phone="${customer.alt_phone || ""}"
                    data-fax="${customer.fax || ""}"
                >${customer.name}</option>`);
            });

            // If there's a saved customer selection, restore it
            const savedState = localStorage.getItem("orderFormState");
            if (savedState) {
                const formState = JSON.parse(savedState);
                if (formState.customerId) {
                    select.val(formState.customerId).trigger("change");
                }
            }
        });
    }

    // Show address book modal
    $('[data-bs-target="#addressBookModal"]').click(function () {
        const addresses = $("#addressBookModal").data("addresses") || [];
        loadAddressTable(addresses);
    });

    // Handle new address button
    $("#addNewAddressBtn").click(function () {
        // Clear the form
        $("#address_id").val("");
        $("#address_line1").val("");
        $("#address_line2").val("");
        $("#city").val("");
        $("#state").val("");
        $("#zipcode").val("");
        $("#shipping_flag").prop("checked", false);
        $("#billing_flag").prop("checked", false);

        // Show the form modal
        $("#addressFormModal").modal("show");
    });

    // Edit address
    $(document).on("click", ".edit-address", function () {
        const addressId = $(this).closest("tr").data("address-id");
        const addresses = $("#addressBookModal").data("addresses") || [];
        console.log("Edit clicked:", { addressId, addresses });

        const address = addresses.find(
            (addr) => addr.customer_address_id == addressId,
        );
        console.log("Found address:", address);

        if (address) {
            // Clear previous data
            $("#address_id").val("");
            $("#address_line1").val("");
            $("#address_line2").val("");
            $("#city").val("");
            $("#state").val("");
            $("#zipcode").val("");
            $("#shipping_flag").prop("checked", false);
            $("#billing_flag").prop("checked", false);

            // Set new data
            $("#address_id").val(address.customer_address_id);
            $("#address_line1").val(address.address_1);
            $("#address_line2").val(address.address_2);
            $("#city").val(address.city);
            $("#state").val(address.state);
            $("#zipcode").val(address.zipcode);
            $("#shipping_flag").prop("checked", address.shipping_flag === 1);
            $("#billing_flag").prop("checked", address.billing_flag === 1);

            // Show the form modal
            $("#addressFormModal").modal("show");
        } else {
            console.error("Address not found:", { addressId, addresses });
        }
    });

    // Handle save address
    $("#saveAddressBtn").click(function () {
        const customerId = $("#customer-select").val();
        if (!customerId) {
            alert("Please select a customer first");
            return;
        }

        // Validate form
        const form = $("#addressForm")[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const addressData = {
            address_1: $("#address_line1").val().trim(),
            address_2: $("#address_line2").val().trim() || null,
            city: $("#city").val().trim(),
            state: $("#state").val().trim(),
            zipcode: $("#zipcode").val().trim(),
            shipping_flag: $("#shipping_flag").is(":checked") ? 1 : 0,
            billing_flag: $("#billing_flag").is(":checked") ? 1 : 0,
        };

        // Ensure at least one flag is set
        if (!addressData.shipping_flag && !addressData.billing_flag) {
            alert(
                "Please select at least one address type (Shipping or Billing)",
            );
            return;
        }

        const addressId = $("#address_id").val();
        const url = addressId
            ? `/ams/customers/${customerId}/addresses/${addressId}`
            : `/ams/customers/${customerId}/addresses`;
        const method = addressId ? "PUT" : "POST";

        console.log("Sending request:", {
            url,
            method,
            data: addressData,
        });

        // Disable save button and show loading state
        const $saveBtn = $("#saveAddressBtn");
        const originalText = $saveBtn.text();
        $saveBtn.prop("disabled", true).text("Saving...");

        $.ajax({
            url: url,
            method: method,
            data: addressData,
            success: function (response) {
                console.log("Success response:", response);
                if (response.success) {
                    // Refresh customer addresses
                    $("#customer-select").trigger("change");

                    // Close the form modal
                    $("#addressFormModal").modal("hide");

                    // Show success message
                    alert(response.message);
                } else {
                    alert("Error saving address: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error response:", {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    response: xhr.responseJSON,
                });

                let errorMessage = "Error saving address. ";

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // Handle validation errors
                    const errors = Object.values(
                        xhr.responseJSON.errors,
                    ).flat();
                    errorMessage += errors.join("\n");
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += xhr.responseJSON.message;
                } else {
                    errorMessage += "Please try again.";
                }

                alert(errorMessage);
            },
            complete: function () {
                // Re-enable save button
                $saveBtn.prop("disabled", false).text(originalText);
            },
        });
    });

    // Handle delete address
    $(document).on("click", ".delete-address", function () {
        if (!confirm("Are you sure you want to delete this address?")) {
            return;
        }

        const customerId = $("#customer-select").val();
        const addressId = $(this).closest("tr").data("address-id");

        $.ajax({
            url: `/ams/customers/${customerId}/addresses/${addressId}`,
            method: "DELETE",
            success: function (response) {
                // Refresh customer addresses
                $("#customer-select").trigger("change");
                alert("Address deleted successfully");
            },
            error: function (xhr, status, error) {
                console.error("Error deleting address:", error);
                alert("Error deleting address. Please try again.");
            },
        });
    });

    // Handle item duplication
    $(document).on("click", ".duplicate-item", function () {
        const row = $(this).closest("tr");
        const itemId = parseInt(row.data("item-id"));
        const originalItem = orderItems.find((i) => i.id === itemId);

        if (originalItem) {
            const product = {
                id: originalItem.productId,
                itemNo: row.find("td:eq(0)").text(),
                description: row.find("td:eq(1)").text(),
                color: row.find("td:eq(2)").text(),
                size1: row.find("td:eq(3)").text(),
                size2: row.find("td:eq(4)").text(),
                style: row.find("td:eq(5)").text(),
                price: originalItem.price,
                quantity: originalItem.quantity,
            };

            addProductToOrder(product);
        }
    });

    // Handle status updates
    $(".status-update").click(function () {
        const status = $(this).data("status");
        const orderId = $("#order-form").data("order-id");

        $.post(
            `/ams/orders/${orderId}/status`,
            {
                status: status,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (response) {
                if (response.success) {
                    // Update UI to show status change
                    $(this).addClass("disabled").prop("disabled", true);
                    // Add timestamp to the field
                    $(`#${status}-date`).val(
                        new Date().toISOString().split("T")[0],
                    );
                }
            },
        );
    });

    // Calculate shipping
    $("#calculate-shipping").click(function () {
        const data = {
            carrier: $('input[placeholder="Carrier"]').val(),
            weight: $('input[placeholder="Weight"]').val(),
            class: $('input[placeholder="Class"]').val(),
            zip: $('input[placeholder="Zip"]').val(),
            packages: $('input[placeholder="Packages"]').val(),
        };

        // Call shipping calculation endpoint
        $.post("/ams/orders/calculate-shipping", data, function (response) {
            if (response.success) {
                $('input[placeholder="Cost Price"]').val(response.cost);
                updateOrderTotals();
            }
        });
    });

    // Save order
    $("#save-order").click(function () {
        const formData = {
            customer_id: $("#customer-id").val(),
            billing_address_id: $("#billing-address-select").val(),
            shipping_address_id: $("#shipping-address").val(),
            origin: $('input[name="origin"]:checked').val(),
            items: orderItems,
            _token: $('meta[name="csrf-token"]').attr("content"),
        };

        $.post("/ams/orders", formData, function (response) {
            if (response.success) {
                window.location.href = `/ams/orders/${response.order.id}`;
            }
        });
    });

    // Save form data to localStorage
    function saveFormState() {
        const formState = {
            customerId: $("#customer-select").val(),
            shippingAddressId: $("#shipping-address").val(),
            billingAddressId: $("#billing-address-select").val(),
            nonResidential: $("#non-residential").prop("checked"),
            origin: $('input[name="origin"]:checked').val(),
            shippingMethod: $('input[name="shipping_method"]:checked').val(),
            orderItems: orderItems,
            lastUpdated: new Date().toISOString(),
        };
        localStorage.setItem("orderFormState", JSON.stringify(formState));
        console.log("Form state saved:", formState);
    }

    // Load form data from localStorage
    function loadFormState() {
        const savedState = localStorage.getItem("orderFormState");
        if (!savedState) return;

        try {
            const formState = JSON.parse(savedState);
            console.log("Loading saved form state:", formState);

            // Restore order items first
            if (formState.orderItems && Array.isArray(formState.orderItems)) {
                orderItems = formState.orderItems;
                currentItemId =
                    Math.max(...orderItems.map((item) => item.id), 0) + 1;

                // Rebuild order items table
                const tbody = $("#orderItemsTable tbody");
                tbody.empty();

                orderItems.forEach((item) => {
                    const total = item.price * item.quantity;
                    tbody.append(`
                        <tr data-item-id="${item.id}" data-product-id="${item.productId}">
                            <td><input type="text" class="form-control form-control-sm editable-field" data-field="itemNo" value="${item.itemNo}"></td>
                            <td><input type="text" class="form-control form-control-sm editable-field" data-field="description" value="${item.description}"></td>
                            <td><input type="text" class="form-control form-control-sm editable-field" data-field="color" value="${item.color}"></td>
                            <td><input type="text" class="form-control form-control-sm editable-field" data-field="size1" value="${item.size1}"></td>
                            <td><input type="text" class="form-control form-control-sm editable-field" data-field="size2" value="${item.size2}"></td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control form-control-sm editable-field" data-field="price" 
                                        value="${item.price}" min="0" step="0.01">
                                </div>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm editable-field" data-field="quantity" 
                                    value="${item.quantity}" min="1">
                            </td>
                            <td>$<span class="item-total">${total.toFixed(2)}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger delete-item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });

                updateOrderTotals();
            }

            // Restore customer selection
            if (formState.customerId) {
                $("#customer-select")
                    .val(formState.customerId)
                    .trigger("change");

                // Wait for addresses to load before setting address selections
                setTimeout(() => {
                    if (formState.shippingAddressId) {
                        $("#shipping-address").val(formState.shippingAddressId);
                    }
                    if (formState.billingAddressId) {
                        $("#billing-address-select").val(
                            formState.billingAddressId,
                        );
                    }
                }, 1000);
            }

            // Restore other form fields
            $("#non-residential").prop("checked", formState.nonResidential);
            if (formState.origin) {
                $(`input[name="origin"][value="${formState.origin}"]`).prop(
                    "checked",
                    true,
                );
            }
            if (formState.shippingMethod) {
                $(
                    `input[name="shipping_method"][value="${formState.shippingMethod}"]`,
                ).prop("checked", true);
            }
        } catch (error) {
            console.error("Error loading form state:", error);
            localStorage.removeItem("orderFormState");
        }
    }

    // Save form state when changes are made
    function setupFormStateTracking() {
        // Track all form inputs for changes
        const formElements = [
            // Customer and Address
            "#customer-select",
            "#shipping-address",
            "#billing-address-select",
            "#non-residential",

            // Call Info
            "#call-date",
            "#quote",
            "#sold",

            // Shipping
            'input[name="origin"]',
            'input[name="shipping_method"]',

            // Additional Info
            "#display-on-homepage",
            "#notes",
        ];

        // Add change event listeners
        formElements.forEach((selector) => {
            $(selector).on("change", saveFormState);
        });

        // Add input event listener for text areas
        $("#notes").on("input", saveFormState);

        // Save state when order items are modified
        $(document).on("orderItemsUpdated", saveFormState);
    }

    // Initialize form state tracking
    $(document).ready(function () {
        loadFormState();
        setupFormStateTracking();
    });

    // Trigger orderItemsUpdated event when items change
    function updateOrderItemsTable() {
        // Existing update code...

        // Trigger event for state saving
        $(document).trigger("orderItemsUpdated");
    }

    // Update order totals
    function updateOrderTotals() {
        let subtotal = 0;

        // Calculate subtotal from order items
        orderItems.forEach((item) => {
            subtotal += item.price * item.quantity;
        });

        // Get additional costs
        const shippingCost = parseFloat($("#shipping-cost").val()) || 0;
        const taxRate = parseFloat($("#tax-rate").val()) || 0;
        const discount = parseFloat($("#discount").val()) || 0;

        // Calculate tax amount
        const taxAmount = (subtotal * taxRate) / 100;

        // Calculate total
        const total = subtotal + shippingCost + taxAmount - discount;

        // Update displays
        $("#subtotal").text(subtotal.toFixed(2));
        $("#shipping-cost-display").text(shippingCost.toFixed(2));
        $("#tax-amount").text(taxAmount.toFixed(2));
        $("#discount-display").text(discount.toFixed(2));
        $("#total").text(total.toFixed(2));
    }

    // Handle changes to shipping, tax, and discount
    $("#shipping-cost, #tax-rate, #discount").on("input", function () {
        updateOrderTotals();
        saveFormState();
    });
});
