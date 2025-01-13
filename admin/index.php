<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require('../db.inc.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css">
    <link rel="stylesheet" href="css/index_styles.css">
    <script type="module" src="js/index.js"></script>
</head>

<body>
    <div>
        <h1>Admin Terminal</h1>
    </div>
    <div>
        <h4>
            Welcome <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') : 'Guest'; ?>
        </h4>
    </div>

    <div>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Log Out</a>
            <a href="update.php">Update Pokémon</a>
        <?php else: ?>
            <a href="login.php">Log In</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </div>

    <div>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
            unset($_SESSION['message']);
        }
        ?>
    </div>
</body>

</html>