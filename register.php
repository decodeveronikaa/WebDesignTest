<?php
session_start();
require_once "dbconfig.php";
$errmsg = "";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password for security

    // Validate the form data (additional validation can be added here)

    // Check for unique username (assuming you have a database connection)
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $checkUsernameQuery = "SELECT * FROM userdetails WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists, handle accordingly (display an error message, redirect, etc.)
        $errmsg = "Username already exists";
    } else {
        // Username is unique, insert into the database
        $insertQuery = "INSERT INTO userdetails (firstname, lastname, username, email, pwd) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $password);
        $stmt->execute();

        // Set session and redirect to home page
        $_SESSION['username'] = $username;
        $stmt->close();
        $conn->close();
        header("Location: home.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="./style.css">
    <style>
        .login-container form input {
            margin-top: -1rem !important;
        }
    </style>
     <script>
        function validateForm() {
            // JavaScript validation logic goes here
            // You can use document.getElementById or other methods to access form elements and perform validation

            // Example: Checking if the username is not empty
            var email = document.getElementById('email').value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert('Invalid email address');
                return false;
            }
            // You can add more validation logic as needed

            return true;
        }
    </script>
</head>
<body>
<!-- partial:index.partial.html -->
<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">Register</h1>
                <form action="register.php" method="post" onsubmit="return validateForm()">
                    <input type="text" placeholder="First Name" name="firstname" id="firstname" value="<?php if(isset($firstname)) echo $firstname;?>" required/>
                    <input type="text" placeholder="Last Name" name="lastname" id="lastname" value="<?php if(isset($lastname)) echo $lastname;?>"  required/>
                    <input type="text" placeholder="USERNAME" name="username" id="username" value="<?php if(isset($username)) echo $username;?>"  required/>
                    <input type="text" placeholder="Email" name="email" id="email" value="<?php if(isset($email)) echo $email;?>" required/>
                    <input type="password" placeholder="PASSWORD" name="password" id="password" value="<?php if(isset($password)) echo $password;?>" required/>
                    
                    <span class="errormessage"><?php if($errmsg!="") echo $errmsg; ?></span>
                    <button class="opacity">SUBMIT</button>
                </form>
                <div class="register-forget opacity">
                    <a href="login.php">LOGIN</a>
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
