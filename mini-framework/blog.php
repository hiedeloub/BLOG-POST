<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\Post;

session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$post = new Post();
$message = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Validate inputs
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author_id = $_SESSION['user']['id'];

    if (empty($title) || empty($content)) {
        $message = 'Title and content are required.';
    } else {
        // Attempt to add the post
        if ($post->addPost([
            'title' => $title,
            'content' => $content,
            'author_id' => $author_id
        ])) {
            header('Location: posts.php'); // Redirect to posts list after successful submission
            exit();
        } else {
            $message = 'Failed to add post. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Blog Post</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <form method="POST" action="blog.php">
        <p>Hello, <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></p>
        <h1>Add a Blog Post</h1>
        <?php if (!empty($message)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <input type="text" name="title" placeholder="Title" required>
        <input type="hidden" name="author_id" value="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>">
        <textarea name="content" id="" required></textarea>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>