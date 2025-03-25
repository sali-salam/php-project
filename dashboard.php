<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, movie_title, poster_url FROM favorite_movies WHERE user_id = ? ORDER BY added_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - OMDB Movie App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Menu -->
    <nav class="navbar">
        <a href="dashboard.php">🏠 Home</a>
        <a href="logout.php" class="logout-btn">🚪 Logout</a>
    </nav>

    <div class="container">
        <h1>🎬 Movie Dashboard</h1>

        <!-- Search Box -->
        <div class="search-container">
            <input type="text" id="movieSearch" placeholder="Search for a movie...">
            <button onclick="searchMovie()">🔍</button>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="movie-grid"></div>

        <h2>Your Favorite Movies ❤</h2>
        <div class="movie-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="movie-card">
                    <img src="<?php echo $row['poster_url']; ?>" alt="Movie Poster">
                    <p><?php echo $row['movie_title']; ?></p>
                    <form action="delete_favorite.php" method="POST">
                    <input type="hidden" name="movie_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="delete-btn">🗑️</button>
                </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
