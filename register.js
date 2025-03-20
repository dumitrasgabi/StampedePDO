document.getElementById('registrationForm').onsubmit = function() {
    var valid = true;
    var username = document.getElementById('user_name').value;
    var password = document.getElementById('password').value;

    if (/[^a-zA-Z0-9]/.test(username)) {
        document.getElementById('usernameError').textContent = "Username can only contain letters and numbers.";
        valid = false;
    } else {
        document.getElementById('usernameError').textContent = "";
    }

    if (password.length < 8) {
        document.getElementById('passwordError').textContent = "Password must be at least 8 characters long.";
        valid = false;
    } else {
        document.getElementById('passwordError').textContent = "";
    }

    return valid;
};