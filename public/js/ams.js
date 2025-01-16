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
