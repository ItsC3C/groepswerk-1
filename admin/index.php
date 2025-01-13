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

// Include necessary files
$_SERVER["admin"] = true;
include_once "../includes/css_js.inc.php";
include_once "../db.inc.php";

// Fetch Pokémon data
$pokémons = getpokémons();
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

<header>
    <div class="name">
        <a href="../index.php">
            <h1>PokéHub - Admin</h1>
        </a>
    </div>
</header>

<body class="admin-index">
    <table class="table">
        <tbody>
            <tr><button class="add">
                    <a href="add.php">Add Pokémon</a>
                </button>
            </tr>
            <?php foreach ($pokémons as $pokémon): ?>
                <tr class="pokémon-row">
                    <td scope="row"><?= $pokémon['pokémon_id']; ?></td>
                    <td><img src="<?= $pokémon['pokémon_image']; ?>" alt="<?= $pokémon['pokémon_name']; ?>" class="pokemon-img"></td>
                    <td clasé="name-row"><?= $pokémon['pokémon_name']; ?></td>
                    <td><?= $pokémon['primary_type_name']; ?></td>
                    <td><?= $pokémon['secondary_type_name'] ? $pokémon['secondary_type_name'] : 'N/A'; ?></td>
                    <td scope="col"><button class="view-btn"><a href="../detail.php?id=<?= $pokémon['pokémon_id']; ?>">View</button></td>
                    <td scope="col"><button class="edit-btn"><a href="edit.php?id=<?= $pokémon['pokémon_id']; ?>">Edit</button></td>
                    <td scope="col"><button class="delete-btn" type="submit"><a href="delete.php?id=<?= $pokémon['pokémon_id']; ?>">Delete</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>