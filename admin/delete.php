<?php
// Ensure errors are displayed during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../error.php
    ");
    exit;
}
require_once '../db.inc.php';

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval(trim($_POST['id'])); // Sanitize input

    if (deletePokémonById($id)) {
        // Redirect to the landing page after successful deletion
        header("Location: index.php");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && empty(trim($_GET['id']))) {
    // Redirect to an error page if the ID is missing
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo isset($_GET["id"]) ? trim($_GET["id"]) : ''; ?>">
                            <p>Are you sure you want to delete this employee record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>