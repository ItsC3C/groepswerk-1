<?php
include_once "includes/css_js.inc.php";
require('db.inc.php');

session_start(); // Start session to check login state

$errors = [];

print '<pre>';
print_r($_POST['button']);
print '</pre>';

// Handle logout if logout is requested via GET
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'logout') {
        // Destroy session and log out
        session_destroy();
        header("Location: index.php?action=logged_out"); // Redirect to index.php with a logged out action
        exit;
    }

    if ($_GET['action'] === 'login' && isset($_POST['inputmail']) && isset($_POST['inputpass'])) {
        $email = $_POST['inputmail'];
        $pass = $_POST['inputpass'];
        $errors = []; // Initialize errors array

        // Validate email
        if (!strlen($email)) {
            $errors[] = "Please fill in your e-mail!";
        }

        // Validate password
        if (!strlen($pass)) {
            $errors[] = "Please fill in your password!";
        }

        if (empty($errors)) {
            $uid = isValidLogin($email, $pass);

            if ($uid) {
                // LOGIN SUCCESS
                setLogin($uid);
                $_SESSION['logged_in'] = true; // Mark as logged in
                $_SESSION['user_id'] = $uid;  // Store user ID
                header("Location: index.php"); // Reload the same page
                exit;
            } else {
                $errors[] = "E-mail and/or password is not correct!";
            }
        }
    }
}

$pokémons = getPokémons();

// Pagination setup
$page = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
$itemsPerPage = 21;
$totalPokémon = count($pokémons);
$pages = ceil($totalPokémon / $itemsPerPage);

if ($totalPokémon > 0) {
    $pokémons = array_slice($pokémons, ($page - 1) * $itemsPerPage, $itemsPerPage);
}

if (isset($_POST['sign-up'])) { // Form submitted?
    $errors = [];
    $username = $_POST['inputusername-register'];
    $email = $_POST['inputmail-register'];
    $password = $_POST['inputpass-register'];
    // // Validate Username
    // if (!isset($_POST['inputusername-register']) || strlen($_POST['inputusername-register']) < 1) {
    //     $errors['username'] = "Username is required!";
    // } else {
    //     $username = $_POST['inputusername-register'];
    // }

    // // Validate Email
    // if (!isset($_POST['inputmail-register']) || !filter_var($_POST['inputmail-register'], FILTER_VALIDATE_EMAIL)) {
    //     $errors['email'] = "Valid email is required!";
    // } else {
    //     $email = $_POST['inputmail-register'];
    //     // Check if email is unique
    //     if (!isMailUnique($email)) {
    //         $errors['email'] = "This email is already in use. Are you trying to <a href='login.php'>login</a> instead?";
    //     }
    // }

    // // Validate Password
    // if (!isset($_POST['inputpass-register']) || !preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $_POST['inputpass-register'])) {
    //     $errors['password'] = "Password needs at least 1 uppercase letter, 1 lowercase, 1 symbol, 1 number, and must be 8 characters long.";
    // } else {
    //     $password = $_POST['inputpass-register'];
    // }

    // // Validate Password Confirmation
    // if (!isset($_POST['inputpass-confirm-register']) || $_POST['inputpass-register'] !== $_POST['inputpass-confirm-register']) {
    //     $errors['password_confirm'] = "Passwords do not match!";
    // }

    // If no errors, insert into DB
    if (count($errors) === 0) {
        $newId = insertIntoDB($username, $email, $password);

        if (!$newId) {
            $errors[] = "An unknown error occurred, please contact support!";
        } else {
            setLogin($newId);
            $_SESSION['message'] = "Welcome $username!";
            header('Location: index.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Homepage</title>
    <link rel="stylesheet" href="<?= getCSS('index'); ?>" />
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
            <input type="search" id="search-bar" placeholder="Search Character..." />
        </div>

        <nav>
            <ul class="menu">
                <li><a href="#">Favorites</a></li>
                <li>
                    <a class="<?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'loginSucces' : 'login'; ?>"
                        id="login-link" href="?action=<?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'logout' : 'login'; ?>">
                        <?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'Logout' : 'Login'; ?>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Login Modal -->
    <div id="login-modal" class="modal" <?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true ? 'style="display:none;"' : ''; ?>>
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h2 id="login-button">Login</h2>

            <?php if (count($errors) > 0): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login">
                <div>
                    <input name="inputmail" id="inputmail-register" type="text" class="form-control" placeholder="Enter your email">
                </div>
                <div>
                    <input name="inputpass" id="inputpass-register" type="password" class="form-control" placeholder="Password">
                </div>
                <button>Login</button>
                <p>Need an account? <a href="#" id="sign-up-link">Sign Up</a></p>
        </div>
    </div>
    <!-- Registration Modal -->
    <div id="register-form" class="modal">
        <div class="modal-content">
            <span id="close-register-modal" class="close">&times;</span>
            <h2>Sign Up</h2>

            <form id="register-form" method="POST" action="index.php?action=register">
                <!-- Username Field -->
                <div>
                    <input name="inputusername-register" id="inputusername-register" type="text" class="form-control" placeholder="Enter your username" value="<?= isset($username) ? $username : '' ?>">
                    <?php if (isset($errors['username'])): ?>
                        <p class="error"><?= $errors['username']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Email Field -->
                <div>
                    <input name="inputmail-register" id="inputmail-register" type="text" class="form-control" placeholder="Enter your email" value="<?= isset($email) ? $email : '' ?>">
                    <?php if (isset($errors['email'])): ?>
                        <p class="error"><?= $errors['email']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div>
                    <input name="inputpass-register" id="inputpass-register" type="password" class="form-control" placeholder="Password">
                    <?php if (isset($errors['password'])): ?>
                        <p class="error"><?= $errors['password']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <input name="inputpass-confirm-register" id="inputpass-confirm-register" type="password" class="form-control" placeholder="Confirm Password">
                    <?php if (isset($errors['password_confirm'])): ?>
                        <p class="error"><?= $errors['password_confirm']; ?></p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button id="sign-up" name="sign-up">Sign Up</button>
            </form>

            <p id="already-have_account_link"><a href="#">Already have an account? Login</a></p>
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

</html>