<?php
// Function to check if the user is logged in (based on session)
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to hash passwords securely
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to validate form inputs (can be expanded)
function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
