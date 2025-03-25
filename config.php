<?php
$host = "sql12.freesqldatabase.com"; // Change to your remote MySQL host when deploying
$username = "sql12769474"; // Change to your database username
$password = "2EX3WEL93F"; // Change to your database password
$database = "sql12769474"; // Change to your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
