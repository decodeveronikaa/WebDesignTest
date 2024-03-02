<?php
// Start session
session_start();
$errmsg = "";
require_once "dbconfig.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and password are provided
    if(isset($_POST['username']) && isset($_POST['password'])) {
        // Retrieve username and password from the form
        $un = $_POST['username'];
        $pwd = $_POST['password'];

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $pwd = md5($pwd);
        // Prepare SQL query to check for matching username and password
        $stmt = $conn->prepare("SELECT * FROM userdetails WHERE username = ? AND pwd = ?");
        // Check if the statement was prepared successfully
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $un, $pwd);
        $stmt->execute();
        $result = $stmt->get_result();
        // Check if any row is returned
        if ($result->num_rows > 0) {
            // Matching username and password found
            // Start session and store username
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username'];
            // Redirect to home page
            header("Location: home.php");
            exit(); // Make sure that code execution stops after redirection
        } else {
            // No matching username and password found
            $errmsg = "Invalid username or password";
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        // Username or password not provided
        echo "Please provide both username and password";
    }
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">LOGIN</h1>
                <form action="login.php" method="post">
                    <input type="text" placeholder="USERNAME" name="username"/>
                    <input type="password" placeholder="PASSWORD" name="password" />
                    <span class="errormessage"><?php if($errmsg!="") echo $errmsg; ?></span>
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="register.php">REGISTER</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container">

        </div>
    </section>
</body>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
