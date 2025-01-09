document.addEventListener("DOMContentLoaded", function () {
    // Create User Form Handler
    const createUserForm = document.getElementById("createUserForm");
    if (createUserForm) {
        createUserForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const data = {
                username: this.querySelector('[name="username"]').value,
                firstname: this.querySelector('[name="firstname"]').value,
                lastname: this.querySelector('[name="lastname"]').value,
                password: this.querySelector('[name="password"]').value,
                level: this.querySelector('[name="level"]').value,
            };

            fetch("/user", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(
                            document.getElementById("createUserModal"),
                        );
                        modal.hide();
                        window.location.reload();
                    } else {
                        alert(data.message || "Error creating user");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("Error creating user");
                });
        });
    }

    // Delete User Handler
    document.querySelectorAll(".delete-user").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.id;

            if (confirm("Are you sure you want to delete this user?")) {
                fetch(`/user/${userId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || "Error deleting user");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Error deleting user");
                    });
            }
        });
    });

    // Toggle Status Handler
    document.querySelectorAll(".toggle-status").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.id;
            const currentStatus = this.dataset.status;
            const newStatus = currentStatus === "1" ? "disable" : "enable";

            if (confirm(`Are you sure you want to ${newStatus} this user?`)) {
                fetch(`/user/${userId}/toggle-status`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || "Error updating user status");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        alert("Error updating user status");
                    });
            }
        });
    });

    //edit user
    const editUserForm = document.getElementById("editUserForm");
    if (editUserForm) {
        editUserForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Get user ID from the form's action attribute
            const userId = this.getAttribute("action").split("/").pop();

            // Create data object manually
            const data = {
                username: this.querySelector('[name="username"]').value,
                firstname: this.querySelector('[name="firstname"]').value,
                lastname: this.querySelector('[name="lastname"]').value,
                level: this.querySelector('[name="level"]').value,
            };

            // If password is provided, add it
            const password = this.querySelector('[name="password"]').value;
            if (password) {
                data.password = password;
            }

            // Debug: Log the data being sent
            console.log("Data being sent:", data);

            fetch(`/user/${userId}`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            })
                .then(async (response) => {
                    // Debug: Log the raw response
                    const rawResponse = await response.text();
                    console.log("Raw response:", rawResponse);

                    try {
                        const jsonResponse = JSON.parse(rawResponse);
                        if (!response.ok) {
                            throw new Error(
                                jsonResponse.message || "Update failed",
                            );
                        }
                        return jsonResponse;
                    } catch (e) {
                        throw new Error("Invalid JSON response from server");
                    }
                })
                .then((data) => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(
                            document.getElementById("editUserModal"),
                        );
                        modal.hide();
                        window.location.reload();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert(error.message);
                });
        });
    }

    // Populate form
    document.querySelectorAll(".edit-user").forEach((button) => {
        button.addEventListener("click", function () {
            // Debug: Log the data attributes
            console.log("Button data:", this.dataset);

            const form = document.getElementById("editUserForm");
            form.setAttribute("action", `/user/${this.dataset.id}`);

            form.querySelector('[name="username"]').value =
                this.dataset.username;
            form.querySelector('[name="firstname"]').value =
                this.dataset.firstname;
            form.querySelector('[name="lastname"]').value =
                this.dataset.lastname;
            form.querySelector('[name="level"]').value = this.dataset.level;
            form.querySelector('[name="password"]').value = "";
        });
    });
});
