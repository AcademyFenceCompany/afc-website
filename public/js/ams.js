document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-image");

    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            if (confirm("Are you sure you want to delete this image?")) {
                const productId = this.dataset.productId;
                const imageType = this.dataset.imageType;

                fetch(`/products/${productId}/delete-image/${imageType}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            // Remove the image container
                            this.closest(".position-relative").remove();
                        } else {
                            alert("Error deleting image");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Error deleting image");
                    });
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Get the category container element
    const categoryContainer = document.getElementById("category-container");

    // Ensure the category container exists
    if (!categoryContainer) {
        console.error("Category container not found in the DOM.");
        return;
    }

    // Parse category data from the dataset
    let categoryData = [];
    try {
        categoryData = JSON.parse(categoryContainer.dataset.categories || "[]");
    } catch (error) {
        console.error("Error parsing category data:", error);
        return;
    }

    /**
     * Dynamically load subcategories
     */
    function loadSubcategories(selectElement, level) {
        const selectedId = parseInt(selectElement.value);
        const container = document.getElementById("category-container");

        // Remove any existing dropdowns after this level
        const allSelects = container.querySelectorAll("select");
        allSelects.forEach((select, index) => {
            if (index > level) {
                select.remove();
            }
        });

        if (selectedId) {
            // Find children of the selected category
            const children = categoryData.filter(
                (cat) => cat.parent_category_id === selectedId,
            );

            if (children.length > 0) {
                // Create a new dropdown for child categories
                const newSelect = document.createElement("select");
                newSelect.className = "form-select form-select-sm mb-2";
                newSelect.name = `category[${level + 1}]`;
                newSelect.onchange = () => {
                    const form = document.getElementById("filterForm");
                    if (form) {
                        loadSubcategories(newSelect, level + 1);

                        // Check if this is a leaf category
                        const childCategories = categoryData.filter(
                            (cat) =>
                                cat.parent_category_id ===
                                parseInt(newSelect.value),
                        );
                        if (
                            childCategories.length === 0 ||
                            newSelect.value === ""
                        ) {
                            form.submit();
                        }
                    }
                };

                // Add default option
                const defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = `All ${level === 0 ? "Subcategories" : "Sub-subcategories"}`;
                newSelect.appendChild(defaultOption);

                // Add child options
                children.forEach((child) => {
                    const option = document.createElement("option");
                    option.value = child.family_category_id;
                    option.textContent = child.family_category_name;
                    newSelect.appendChild(option);
                });

                container.appendChild(newSelect);
            } else {
                // No children, submit the form
                const form = document.getElementById("filterForm");
                if (form) {
                    form.submit();
                }
            }
        } else {
            // "All" was selected, submit the form
            const form = document.getElementById("filterForm");
            if (form) {
                form.submit();
            }
        }
    }

    /**
     * Initialize dropdowns based on URL parameters
     */
    const urlParams = new URLSearchParams(window.location.search);
    const categories = urlParams.getAll("category[]").filter(Boolean);

    if (categories.length > 0) {
        categories.forEach((catId, index) => {
            const prevSelect = document.querySelector(
                `select[name="category[${index}]"]`,
            );
            if (prevSelect) {
                prevSelect.value = catId;
                loadSubcategories(prevSelect, index);
            }
        });
    }

    /**
     * Toggle category tree expansion
     */
    document.querySelectorAll(".toggle-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            const categoryItem = this.closest(".category-item");
            const nestedList = categoryItem.querySelector(".nested");
            if (nestedList) {
                nestedList.classList.toggle("show");
                this.classList.toggle("active");
            }
        });
    });

    /**
     * Auto-expand active category
     */
    const activeLink = document.querySelector(".category-link.active");
    if (activeLink) {
        let parent = activeLink.closest(".nested");
        while (parent) {
            parent.classList.add("show");
            const toggleBtn = parent.parentElement.querySelector(".toggle-btn");
            if (toggleBtn) toggleBtn.classList.add("active");
            parent = parent.parentElement.closest(".nested");
        }
    }

    /**
     * Handle category link clicks
     */
    document.querySelectorAll(".category-link").forEach((link) => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            const url = new URL(this.href);
            const categoryId = url.searchParams.get("category");

            console.log("Selected Category ID:", categoryId);

            // Trigger form submission or navigate to the URL
            window.location.href = url.toString();
        });
    });
});
