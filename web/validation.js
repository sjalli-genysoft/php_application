function validateCreateUserForm() {
    const name = document.getElementById("fullname").value.trim();
    const email = document.getElementById("new_email").value.trim();
    const password = document.getElementById("new_password").value.trim();

    if (!name || !email || !password) {
        alert("All fields are required.");
        return false;
    }

    if (!/^[a-zA-Z\s]+$/.test(name)) {
        alert("Full name should only contain letters and spaces.");
        return false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Email format should be like string@string.com");
        return false;
    }

    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(password)) {
        alert("Password must be at least 6 characters and include uppercase, lowercase, and a number.");
        return false;
    }

    return true;
}

function toggleCreatePassword() {
    const passwordField = document.getElementById("new_password");
    const toggleIcon = document.getElementById("toggleCreatePassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
