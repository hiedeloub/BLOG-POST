<?php

require_once 'vendor/autoload.php';

use Aries\Dbmodel\Models\User;

session_start();

// Usage example
$user = new User();

// checks if the button is clicked and the form is submitted. If true, run the createUser() function from our User class
// Then pass in an array of data to the createUser class since createUser accepts an array of data
if(isset($_POST['submit'])) {
    $user_info = $user->login([
        'username' => $_POST['username'],
    ]);

    if($user_info && password_verify($_POST['password'], $user_info['password'])) {
        $_SESSION['user'] = $user_info;
        header('Location: index.php');
        exit;
    } else {
        $message = 'Invalid username or password';
    }
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <form method="POST" action="login.php">
        <h1>Login</h1>
        <?php echo isset($message) ? $message : ''; ?>
        <input type="username" name="username" id="" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>