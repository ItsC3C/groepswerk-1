<?php
require('../db.inc.php');
session_start();

// Establish PDO connection
try {
    $db = connectToDB();
    // echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['register_btn'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $password2 = htmlspecialchars(trim($_POST['password2']));

    // Check if the username already exists
    $stmt = $db->prepare("SELECT * FROM gebruikers WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<script>alert("Username already exists");</script>';
    } else {
        if ($password === $password2) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the new user into the database
            $insertStmt = $db->prepare("INSERT INTO gebruikers (username, email, password) VALUES (:username, :email, :password)");
            $insertStmt->bindParam(':username', $username);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->bindParam(':password', $hashedPassword);

            if ($insertStmt->execute()) {
                $_SESSION['message'] = "You are now registered and logged in";
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['message'] = "Error occurred while registering. Please try again.";
            }
        } else {
            $_SESSION['message'] = "The passwords do not match.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="css/register_styles.css">

</head>

<body>
    <div class="container">
        <h1>Admin Panel</h1>


        <?php
        if (isset($_SESSION['message'])) {
            echo "<div id='error_msg'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
            unset($_SESSION['message']);
        }
        ?>

        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2" required>

            <button type="submit" name="register_btn">Register</button>
        </form>
    </div>
</body>

</html>