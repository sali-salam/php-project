<?php
require 'config.php';
session_start(); // Start session to get user_id

if (!isset($_GET['title'])) {
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID
$title = urlencode($_GET['title']);
$api_url = "http://www.omdbapi.com/?apikey=9207fbff&s=$title";
$response = file_get_contents($api_url);
$movies = json_decode($response, true);

if (!empty($movies['Search'])) {
    echo "<div class='movie-grid'>";

    foreach ($movies['Search'] as $movie) {
        $movie_id = $movie['imdbID'];
        $movie_title = $movie['Title'];
        $movie_poster = $movie['Poster'];

        // Check if the movie is already in the favorites list
        $stmt = $conn->prepare("SELECT id FROM favorite_movies WHERE user_id = ? AND movie_id = ?");
        $stmt->bind_param("is", $user_id, $movie_id);
        $stmt->execute();
        $stmt->store_result();
        $is_favorite = $stmt->num_rows > 0; // True if movie exists

        echo "<div class='movie-card'>
                <img src='$movie_poster' width='100'>
                <p>$movie_title</p>";

        if ($is_favorite) {
            echo "<span class='already-added'>✔ Already Added</span>";
        } else {
            echo "<a href='add_favorite.php?movie_id=$movie_id&title=" . urlencode($movie_title) . "&poster=" . urlencode($movie_poster) . "'>Add to Favorites</a>";
        }

        echo "</div>";
    }

    echo "</div>";
} else {
    echo "<p>No movies found.</p>";
}
?>
