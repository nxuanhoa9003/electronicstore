<?php
$servername = "localhost";
$username = "root";
$password = "";
$mydb = "electrostore";

// Create connection
$conn = new mysqli($servername, $username, $password, $mydb);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, 'utf8');
