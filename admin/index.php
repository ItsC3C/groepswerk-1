<?php
$_SERVER["admin"] = true;
include_once "../includes/css_js.inc.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN HOMEPAGE</title>
    <link rel="stylesheet" href="<?= getCSS("index") ?>" />
    <script type="module" src="<?= getJS("index") ?>"></script>
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