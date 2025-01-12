<?php
require('../db.inc.php');
session_start();

$db = connectToDB();

// Redirect to home if already logged in
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['message'] = "Username and password are required.";
    } else {
        $stmt = $db->prepare("SELECT * FROM gebruikers WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['admin'] = $user['is_admin'] ?? false;

                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'] = "Invalid password.";
            }
        } else {
            $_SESSION['message'] = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login_styles.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>

        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
            unset($_SESSION['message']);
        }
        ?>

        <form method="post" action="login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <button type="submit">Log In</button>
        </form>
    </div>
</body>

</html>