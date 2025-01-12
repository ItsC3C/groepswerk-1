<?php
include_once "includes/css_js.inc.php";
require_once('users.inc.php');

// print '<pre>';
// print_r(getGames());
// print '</pre>';

session_start(); // Start session to check login state


$errors = [];
$loginModalOpen = false;
$registerModalOpen = false;

// Handle logout if logout is requested via GET
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php?action=logged_out");
    exit;
}

// Handle login action
if (isset($_GET['action']) && $_GET['action'] === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['inputmail'] ?? '';
    $pass = $_POST['inputpass'] ?? '';

    // Validate login input
    if (!$email) {
        $errors['email'] = "Please fill in your e-mail!";
    }
    if (!$pass) {
        $errors['password'] = "Please fill in your password!";
    }

    if (empty($errors)) {
        $uid = isValidLogin($email, $pass, $admin);

        if ($uid) {
            setLogin($uid);
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $uid;
            $_SESSION['is_admin'] = isAdmin($email); // Check admin rights
            header("Location: index.php");
            exit;
        } else {
            $errors['login'] = "E-mail and/or password is not correct!";
        }
    }

    $loginModalOpen = true; // Keep login modal open if there's an error
}

// Handle registration action
if (isset($_POST['sign-up'])) {
    $username = $_POST['inputusername-register'] ?? '';
    $email = $_POST['inputmail-register'] ?? '';
    $pass = $_POST['inputpass-register'] ?? '';
    $passConfirm = $_POST['inputpass-confirm-register'] ?? '';

    // Validate registration input
    if (!$username) {
        $errors['username'] = "Username is required!";
    } elseif (!isUsernameUnique($username)) {
        $errors['username'] = "This username is already in use. Are you trying to <a href='login.php'>login</a> instead?";
    }

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Valid email is required!";
    } elseif (!isMailUnique($email)) {
        $errors['email'] = "This email is already in use. Are you trying to <a href='login.php'>login</a> instead?";
    }

    if (!$pass) {
        $errors['password'] = "Password is required!";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pass)) {
        $errors['password'] = "Password must have at least 1 uppercase letter, 1 lowercase letter, 1 symbol, 1 number, and be 8 characters long.";
    }

    if ($pass !== $passConfirm) {
        $errors['password_confirm'] = "Passwords do not match!";
    }

    if (empty($errors)) {
        $newId = insertIntoDB($username, $email, $pass);

        if ($newId) {
            setLogin($newId);
            $_SESSION['message'] = "Welcome $username!";
            header('Location: index.php');
            exit;
        } else {
            $errors['general'] = "An unknown error occurred. Please contact support!";
        }
    }

    $registerModalOpen = true; // Keep registration modal open if there's an error
}

$games = getGames(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéHub - Games</title>
    <link rel="stylesheet" href="<?= getCSS('index'); ?>">
    <script type="module" src="<?= getJS('index'); ?>"></script>
</head>

<body>
    <header>
        <div class="name">
            <a href="#">
                <h1>PokéHub</h1>
            </a>
        </div>
        <div class="search">
            <input type="search" id="search-bar" placeholder="Search Character...">
            <div id="search-results"></div>
        </div>
        <nav>
            <ul class="menu">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <li><a href="index.php">Pokémons</a></li>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <li><a href="/admin/index.php">Admin</a></li>
                    <?php endif; ?>
                    <li>
                        <a class="loginSucces" id="login-link" href="?action=logout">Logout</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="login" id="login-link" href="?action=login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="game_table">
        <?php foreach ($games as $game): ?>
            <div class="game_card">
                <div class="game">
                    <div class="game_name">
                        <?= $game['game_name']; ?>
                    </div>
                    <div class="game_image">
                        <img src="<?= $game['game_image']; ?>" alt="<?= $game['game_name']; ?>">
                    </div>
                    <div class="game_description">
                        <?= $game['game_description']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

<footer>
    <p>&copy; 2025 PokeHub. All rights reserved.</p>
</footer>

</html>