<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;

session_start();

// Usage example
$post = new Post();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1></h1>
    <?php if (isset($_SESSION['user'])): ?>
        <div class="welcome">
            <h2>Welcome <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></h2>
            <h3>Your Blog Posts:</h3>
            <ul>
                <?php
                    // Get the logged-in user's posts
                    $userId = $_SESSION['user']['id'];
                    $userPosts = $post->getPostsByLoggedInUser ($userId);
                    if (!empty($userPosts)) {
                        foreach ($userPosts as $postItem) {
                            echo '<li>' . htmlspecialchars($postItem['title']) . '</li>';
                        }
                    } else {
                        echo '<li class="no-posts">No blog posts found.</li>'; 
                    }
                ?>
            </ul>
        </div>
    <?php else: ?>
        <h2>Recent Blog Posts from All Users:</h2>
        <ul>
            <?php
                // Get all recent posts from all users
                $recentPosts = $post->getPosts(); // Method to get all posts
                if (!empty($recentPosts)) {
                    foreach ($recentPosts as $postItem) {
                        echo '<li>' . htmlspecialchars($postItem['title']) . '</li>';
                    }
                } else {
                    echo '<li class="no-posts">No recent blog posts found.</li>';
                }
            ?>
        </ul>
    <?php endif; ?>
</body>
</html>