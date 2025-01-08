document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-user").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.id;
            const username = this.dataset.username;
            const firstname = this.dataset.firstname;
            const lastname = this.dataset.lastname;
            const level = this.dataset.level;

            // Populate form fields
            document
                .getElementById("editUserForm")
                .setAttribute("action", `/user/${userId}`);
            document.querySelector('input[name="username"]').value = username;
            document.querySelector('input[name="firstname"]').value = firstname;
            document.querySelector('input[name="lastname"]').value = lastname;
            document.querySelector('select[name="level"]').value = level;
        });
    });

    document
        .getElementById("editUserForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);

            fetch(form.getAttribute("action"), {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'input[name="_token"]',
                    ).value,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(Object.fromEntries(formData.entries())),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        document
                            .getElementById("editUserModal")
                            .classList.remove("show");
                        document.querySelector(".modal-backdrop").remove();
                        document.body.classList.remove("modal-open");
                        document.body.style = "";
                        location.reload();
                    } else {
                        console.error("Error updating user:", data);
                    }
                })
                .catch((error) => {
                    console.error("Error updating user:", error);
                });
        });
});
