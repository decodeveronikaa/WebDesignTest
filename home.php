<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #navbar {
            background-color: #333;
            overflow: hidden;
            color: white;
        }

        #navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        #navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        #navbar .logout {
            float: right;
        }
    </style>
    <link rel="stylesheet" href="./style.css">
    <script>
        function fetchUserDetails() {
            var username = document.getElementById('username').value;
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            // Define the request
            xhr.open("GET", "fetchdetails.php?username=" + username, true);
            // Set up the callback function to handle the response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parse the JSON response
                    var userDetails = JSON.parse(xhr.responseText);

                    // Display user details in the userDetailsContainer
                    document.getElementById('userDetailsContainer').innerHTML = "<p>User Details:</p>" +
                        "<p>First Name: " + userDetails.firstname + "</p>" +
                        "<p>Last Name: " + userDetails.lastname + "</p>" +
                        "<p>Email: " + userDetails.email + "</p>";
                }
            };

            // Send the request
            xhr.send();
        }
    </script>
</head>

<body>

    <div id="navbar">
        <a href="#" id="homeLink">Home</a>
        <a href="#" id="aboutLink">About</a>
        <a href="#" id="serviceLink">Services</a>
        <a href="#" id="contactLink">Contact</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="homediv">
        <h1>Welcome to the Home Page</h1>


        <input type="text" placeholder="User Name" name="username" id="username" />

        <button class="opacity" onclick="fetchUserDetails()">Fetch Details</button>

        <div id="userDetailsContainer">
            <!-- User details will be displayed here -->
        </div>

        <h1>Hide Show Menu Items</h1>
        <button class="opacity" onclick="toggleMenu()">Menu</button>
        <button class="opacity" onclick="toggleHome()">Home</button>
        <button class="opacity" onclick="toggleAbout()">About</button>
        <button class="opacity" onclick="toggleService()">Service</button>
        <button class="opacity" onclick="toggleContact()">Contact</button>
        <!-- Your page content goes here -->
        <div class="theme-btn-container">

        </div>
    </div>
</body>
<script src="./script.js"></script>
<script>
     function toggleMenu() {
            var menu = document.getElementById('navbar');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }

        // Optionally, you can provide individual toggle functions for each menu item
        function toggleHome() {
            var homeLink = document.getElementById('homeLink');
            homeLink.style.display = (homeLink.style.display === 'none' || homeLink.style.display === '') ? 'block' : 'none';
        }
        function toggleAbout() {
            var homeLink = document.getElementById('aboutLink');
            homeLink.style.display = (homeLink.style.display === 'none' || homeLink.style.display === '') ? 'block' : 'none';
        }
        function toggleService() {
            var homeLink = document.getElementById('serviceLink');
            homeLink.style.display = (homeLink.style.display === 'none' || homeLink.style.display === '') ? 'block' : 'none';
        }
        function toggleContact() {
            var homeLink = document.getElementById('contactLink');
            homeLink.style.display = (homeLink.style.display === 'none' || homeLink.style.display === '') ? 'block' : 'none';
        }

</script>
</html>