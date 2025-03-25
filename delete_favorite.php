<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['movie_id'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = $_POST['movie_id'];

    $stmt = $conn->prepare("DELETE FROM favorite_movies WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $movie_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Redirect to refresh the dashboard
        exit();
    } else {
        echo "Error deleting movie.";
    }
}
?>
