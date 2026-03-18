<script>
document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.querySelector('.btn-login');

    loginBtn.addEventListener('click', () => {
        // Get input values
        const username = document.querySelector('input[name="username"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();

        // Simple client-side validation (just example)
        if(username === "" || password === "") {
            alert("Please enter both username and password.");
            return;
        }

        // For demo purposes: Replace with your real validation (PHP backend is recommended)
        // Example: allow username "admin" and password "12345"
        if(username === "admin" && password === "12345") {
            // Redirect to dashboard.php in admin-side folder
            window.location.href = '../admin-side/dashboard.php';
        } else {
            alert("Invalid username or password. Please try again.");
        }
    });
});
</script>