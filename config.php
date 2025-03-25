<?php
$host = "localhost"; // Change to your remote MySQL host when deploying
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$database = "favmovie"; // Change to your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
