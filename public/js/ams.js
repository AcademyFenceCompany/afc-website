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

const categoryContainer = document.getElementById("category-container");
const categoryData = JSON.parse(categoryContainer.dataset.categories || "[]");

function loadSubcategories(selectElement, level) {
    const selectedId = parseInt(selectElement.value);
    const container = document.getElementById("category-container");

    // Remove any existing dropdowns after this level
    const allSelects = container.getElementsByTagName("select");
    while (allSelects.length > level + 1) {
        container.removeChild(allSelects[allSelects.length - 1]);
    }

    if (selectedId) {
        // Find children of selected category
        const children = categoryData.filter(
            (cat) => cat.parent_category_id === selectedId,
        );

        if (children.length > 0) {
            // Create new dropdown for children
            const newSelect = document.createElement("select");
            newSelect.className = "form-select form-select-sm mb-2";
            newSelect.name = `category[${level + 1}]`;
            newSelect.onchange = () => {
                const form = document.getElementById("filterForm");
                if (form) {
                    loadSubcategories(newSelect, level + 1);
                    // Only submit if this is a leaf category or "All" is selected
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
            // If no children, submit the form
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

// Initialize dropdowns based on URL parameters
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const categories = urlParams.getAll("category[]").filter(Boolean); // Remove empty values

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
});
