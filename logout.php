<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Unset or destroy the session variables
    unset($_SESSION['username']);
    // or use session_destroy() to destroy the entire session
    // session_destroy();

    // Redirect to the login page or any other page after logout
    header("Location: login.php");
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>