<?php
include_once "includes/css_js.inc.php";
require_once('users.inc.php');

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

$pokémons = getpokémons();

if (isset($_POST['searchterm']) && !empty($_POST['searchterm'])) {
    $id = nameToId($_POST['searchterm']);

    if ($id) {
        header("Location: detail.php?id=$id");
        exit;
    } else {
        header("Location: error.php");
        exit;
    }
}



$page = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
$itemsPerPage = 21;
$totalpokémon = count($pokémons);
$pages = ceil($totalpokémon / $itemsPerPage);
if ($page < 1 || $page > $pages) {
    header("Location: error.php");
    exit;
}

$pokémons = array_slice($pokémons, ($page - 1) * $itemsPerPage, $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéHub</title>
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
        <form method="POST" action="index.php">
            <div class="search">
                <input type="text" name="searchterm" placeholder="Search Battles" value="">
            </div>
        </form>
        <nav>
            <ul class="menu">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <li><a href="games.php">Pokémon Games</a></li>
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

    <!-- Login Modal -->
    <div id="login-modal" class="modal" style="display: <?= $loginModalOpen ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h2>Login</h2>

            <?php if (!empty($errors) && $loginModalOpen): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login">
                <input name="inputmail" id="inputmail" type="text" placeholder="Enter your email" value="<?= htmlspecialchars($_POST['inputmail'] ?? ''); ?>">
                <input name="inputpass" id="inputpass" type="password" placeholder="Password">
                <button type="submit">Login</button>
            </form>
            <p>Need an account? <a href="#" id="sign-up-link">Sign Up</a></p>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="register-form" class="modal" style="display: <?= $registerModalOpen ? 'block' : 'none'; ?>;">
        <div class="modal-content">
            <span id="close-register-modal" class="close">&times;</span>
            <h2>Sign Up</h2>

            <form method="POST" action="index.php">
                <input name="inputusername-register" id="inputusername-register" type="text" placeholder="Enter your username" value="<?= htmlspecialchars($_POST['inputusername-register'] ?? ''); ?>">
                <?php if (isset($errors['username'])): ?><p class="error"><?= $errors['username']; ?></p><?php endif; ?>

                <input name="inputmail-register" id="inputmail-register" type="email" placeholder="Enter your email" value="<?= htmlspecialchars($_POST['inputmail-register'] ?? ''); ?>">
                <?php if (isset($errors['email'])): ?><p class="error"><?= $errors['email']; ?></p><?php endif; ?>

                <input name="inputpass-register" id="inputpass-register" type="password" placeholder="Password">
                <?php if (isset($errors['password'])): ?><p class="error"><?= $errors['password']; ?></p><?php endif; ?>

                <input name="inputpass-confirm-register" id="inputpass-confirm-register" type="password" placeholder="Confirm Password">
                <?php if (isset($errors['password_confirm'])): ?><p class="error"><?= $errors['password_confirm']; ?></p><?php endif; ?>

                <button type="submit" name="sign-up">Sign Up</button>
            </form>

        </div>
    </div>

    <div class="table">
        <?php foreach ($pokémons as $pokémon): ?>
            <a class="pokémon_card" href="detail.php?id=<?= $pokémon['pokémon_id'] ?>">
                <div class="pokémon" <?php setBackgroundColor($pokémon['primary_type_name']); ?>>
                    <div class="pokémon_image">
                        <img src="<?= $pokémon['pokémon_image']; ?>" alt="<?= $pokémon['pokémon_name']; ?>">
                    </div>
                    <div class="pokémon_ID_name" <?php setColor($pokémon['primary_type_name']); ?>>
                        <?= $pokémon['pokémon_id']; ?> | <?= $pokémon['pokémon_name']; ?>
                    </div>
                    <div class="pokémon_type1">
                        <?php if ($primaryTypeImage = getTypeImage($pokémon['primary_type_name'])): ?>
                            <img class="type" src="<?= $primaryTypeImage; ?>" alt="<?= $pokémon['primary_type_name']; ?>">
                        <?php endif; ?>
                    </div>
                    <div class="pokémon_type2">
                        <?php if ($secondaryTypeImage = getTypeImage($pokémon['secondary_type_name'])): ?>
                            <img class="type" src="<?= $secondaryTypeImage; ?>" alt="<?= $pokémon['secondary_type_name']; ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <ul class="pagination">
        <?php if ($pages > 1): ?>
            <li class="page-link">
                <?php if ($page > 1): ?>
                    <a href="?page-nr=<?= $page - 1 ?>">Previous</a>
                <?php else: ?>
                    <span class="disabled">Previous</span>
                <?php endif; ?>
            </li>
            <li class="page-link">
                <?php if ($page < $pages): ?>
                    <a href="?page-nr=<?= $page + 1 ?>">Next</a>
                <?php else: ?>
                    <span class="disabled">Next</span>
                <?php endif; ?>
            </li>
        <?php endif; ?>
    </ul>
</body>

<footer>
    <p>&copy; 2025 PokeHub. All rights reserved.</p>
</footer>

</html>