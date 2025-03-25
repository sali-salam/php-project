<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$movie_id = $_GET['movie_id'];
$title = $_GET['title'];
$poster = $_GET['poster'];

// Check if the movie already exists in favorites
$check_stmt = $conn->prepare("SELECT id FROM favorite_movies WHERE user_id = ? AND movie_id = ?");
$check_stmt->bind_param("is", $user_id, $movie_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows === 0) {
    // Movie doesn't exist, so insert it
    $stmt = $conn->prepare("INSERT INTO favorite_movies (user_id, movie_id, movie_title, poster_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $movie_id, $title, $poster);
    $stmt->execute();
}

header("Location: index.php");
exit();
?>
