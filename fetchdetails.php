<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start session
session_start();

require_once "dbconfig.php";
// Check if the session variable containing the username is not set
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: login.php");
    exit(); // Stop execution after redirection
}
// Assuming you have a database connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the GET request
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Prepare and execute the query
    $query = "SELECT * FROM userdetails WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch the user details as an associative array
        $userDetails = $result->fetch_assoc();

        // Return user details as JSON
        header('Content-Type: application/json');
        echo json_encode($userDetails);
    } else {
        // Return an empty JSON object if no user is found
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    // Close the database connection and statement
    $stmt->close();
    $conn->close();
}
?>