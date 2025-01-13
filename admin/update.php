<?php
session_start();
require('../db.inc.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$db = connectToDB();

// Fetch Pokémon data
$pokemonList = $db->query("SELECT pokémon_id, pokémon_name, pokémon_image FROM pokémon ORDER BY pokémon_id ASC LIMIT 149")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pokémon</title>
    <link rel="stylesheet" href="css/update_styles.css">
</head>

<body>
    <h1>Pokémon List</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image URL</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pokemonList as $pokemon): ?>
            <tr>
                <td><?= htmlspecialchars($pokemon['pokémon_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($pokemon['pokémon_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($pokemon['pokémon_image'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <a href="detail.php?id=<?= $pokemon['pokémon_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>