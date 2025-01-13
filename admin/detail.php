<?php
session_start();
require('../db.inc.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the Pokémon ID from the URL
if (!isset($_GET['id'])) {
    echo "Invalid Pokémon ID.";
    exit();
}
$pokemon_id = intval($_GET['id']);

// Connect to the database
$db = connectToDB();

// Fetch Pokémon details
$stmt = $db->prepare("SELECT 
    p.pokémon_id,
    p.pokémon_name,
    p.pokémon_image,
    p.pokémon_evolutiuon_stage AS evolution_stage,
    p.pokémon_height,
    p.pokémon_weight,
    p.pokémon_hp,
    p.pokémon_attack,
    p.pokémon_defence,
    p.pokémon_special_attack,
    p.pokémon_special_defense,
    p.pokémon_speed,
    a1.abilitie_name AS ability_1,
    a1.abilitie_description AS ability_1_description,
    a2.abilitie_name AS ability_2,
    a2.abilitie_description AS ability_2_description,
    a3.abilitie_name AS ability_3,
    a3.abilitie_description AS ability_3_description,
    t1.type_name AS primary_type,
    t2.type_name AS secondary_type
FROM 
    pokémon p
LEFT JOIN 
    pokémon_has_abilities pha ON p.pokémon_id = pha.pokémon_id
LEFT JOIN 
    abilities a1 ON pha.abilitie_id = a1.abilitie_id
LEFT JOIN 
    abilities a2 ON pha.abilitie2_id = a2.abilitie_id
LEFT JOIN 
    abilities a3 ON pha.abilitie3_id = a3.abilitie_id
LEFT JOIN 
    pokémon_is_type pit ON p.pokémon_id = pit.pokémon_id
LEFT JOIN 
    types t1 ON pit.type_id = t1.type_id
LEFT JOIN 
    types t2 ON pit.type2_id = t2.type_id
WHERE 
    p.pokémon_id = :pokemon_id");

$stmt->bindParam(':pokemon_id', $pokemon_id);
$stmt->execute();
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pokemon) {
    echo "Pokémon not found.";
    exit();
}

// Handle form submission to update Pokémon details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pokemon'])) {
    $updateStmt = $db->prepare("UPDATE pokémon SET 
        pokémon_name = :pokemon_name,
        pokémon_image = :pokemon_image,
        pokémon_evolutiuon_stage = :evolution_stage,
        pokémon_height = :height,
        pokémon_weight = :weight,
        pokémon_hp = :hp,
        pokémon_attack = :attack,
        pokémon_defence = :defense,
        pokémon_special_attack = :special_attack,
        pokémon_special_defense = :special_defense,
        pokémon_speed = :speed
    WHERE pokémon_id = :pokemon_id");

    $updateStmt->bindParam(':pokemon_id', $pokemon_id);
    $updateStmt->bindParam(':pokemon_name', $_POST['pokemon_name']);
    $updateStmt->bindParam(':pokemon_image', $_POST['pokemon_image']);
    $updateStmt->bindParam(':evolution_stage', $_POST['evolution_stage']);
    $updateStmt->bindParam(':height', $_POST['height']);
    $updateStmt->bindParam(':weight', $_POST['weight']);
    $updateStmt->bindParam(':hp', $_POST['hp']);
    $updateStmt->bindParam(':attack', $_POST['attack']);
    $updateStmt->bindParam(':defense', $_POST['defense']);
    $updateStmt->bindParam(':special_attack', $_POST['special_attack']);
    $updateStmt->bindParam(':special_defense', $_POST['special_defense']);
    $updateStmt->bindParam(':speed', $_POST['speed']);

    if ($updateStmt->execute()) {
        $_SESSION['message'] = "Pokémon updated successfully!";
        header("Location: detail.php?id=$pokemon_id");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update Pokémon.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pokémon Details</title>
    <link rel="stylesheet" href="css/detail_styles.css">
</head>

<body>
    <h1>Edit Pokémon Details</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <form method="post" action="">
        <label for="pokemon_name">Name:</label>
        <input type="text" name="pokemon_name" id="pokemon_name" value="<?= htmlspecialchars($pokemon['pokémon_name'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="pokemon_image">Image URL:</label>
        <input type="text" name="pokemon_image" id="pokemon_image" value="<?= htmlspecialchars($pokemon['pokémon_image'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="evolution_stage">Evolution Stage:</label>
        <input type="text" name="evolution_stage" id="evolution_stage" value="<?= htmlspecialchars($pokemon['evolution_stage'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="height">Height:</label>
        <input type="text" name="height" id="height" value="<?= htmlspecialchars($pokemon['pokémon_height'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="weight">Weight:</label>
        <input type="text" name="weight" id="weight" value="<?= htmlspecialchars($pokemon['pokémon_weight'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="hp">HP:</label>
        <input type="text" name="hp" id="hp" value="<?= htmlspecialchars($pokemon['pokémon_hp'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="attack">Attack:</label>
        <input type="text" name="attack" id="attack" value="<?= htmlspecialchars($pokemon['pokémon_attack'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="defense">Defense:</label>
        <input type="text" name="defense" id="defense" value="<?= htmlspecialchars($pokemon['pokémon_defence'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="special_attack">Special Attack:</label>
        <input type="text" name="special_attack" id="special_attack" value="<?= htmlspecialchars($pokemon['pokémon_special_attack'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="special_defense">Special Defense:</label>
        <input type="text" name="special_defense" id="special_defense" value="<?= htmlspecialchars($pokemon['pokémon_special_defense'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="speed">Speed:</label>
        <input type="text" name="speed" id="speed" value="<?= htmlspecialchars($pokemon['pokémon_speed'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <button type="submit" name="update_pokemon">Update Pokémon</button>
    </form>
</body>

</html>