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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pokemon'])) {
    $pokemon_id = $_POST['pokemon_id'];
    $pokemon_name = htmlspecialchars(trim($_POST['pokemon_name']));
    $pokemon_image = htmlspecialchars(trim($_POST['pokemon_image']));
    $evolution_stage = htmlspecialchars(trim($_POST['evolution_stage']));
    $height = htmlspecialchars(trim($_POST['height']));
    $weight = htmlspecialchars(trim($_POST['weight']));
    $hp = htmlspecialchars(trim($_POST['hp']));
    $attack = htmlspecialchars(trim($_POST['attack']));
    $defense = htmlspecialchars(trim($_POST['defense']));
    $special_attack = htmlspecialchars(trim($_POST['special_attack']));
    $special_defense = htmlspecialchars(trim($_POST['special_defense']));
    $speed = htmlspecialchars(trim($_POST['speed']));
    $ability_1 = htmlspecialchars(trim($_POST['ability_1']));
    $ability_1_description = htmlspecialchars(trim($_POST['ability_1_description']));
    $ability_2 = htmlspecialchars(trim($_POST['ability_2']));
    $ability_2_description = htmlspecialchars(trim($_POST['ability_2_description']));
    $ability_3 = htmlspecialchars(trim($_POST['ability_3']));
    $ability_3_description = htmlspecialchars(trim($_POST['ability_3_description']));
    $primary_type = htmlspecialchars(trim($_POST['primary_type']));
    $secondary_type = htmlspecialchars(trim($_POST['secondary_type']));

    // Update query
    $stmt = $db->prepare("UPDATE pokémon SET 
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
        pokémon_speed = :speed,
        primary_type = :primary_type,
        secondary_type = :secondary_type 
        WHERE pokémon_id = :pokemon_id");

    $stmt->bindParam(':pokemon_id', $pokemon_id);
    $stmt->bindParam(':pokemon_name', $pokemon_name);
    $stmt->bindParam(':pokemon_image', $pokemon_image);
    $stmt->bindParam(':evolution_stage', $evolution_stage);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':hp', $hp);
    $stmt->bindParam(':attack', $attack);
    $stmt->bindParam(':defense', $defense);
    $stmt->bindParam(':special_attack', $special_attack);
    $stmt->bindParam(':special_defense', $special_defense);
    $stmt->bindParam(':speed', $speed);
    $stmt->bindParam(':primary_type', $primary_type);
    $stmt->bindParam(':secondary_type', $secondary_type);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Pokémon updated successfully!";
    } else {
        $_SESSION['message'] = "Failed to update Pokémon.";
    }
}

// Fetch Pokémon data
$pokemonList = $db->query("SELECT 
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
    ORDER BY pokémon_id ASC
    ")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pokémon</title>
    <link rel="stylesheet" href="css/edit_styles.css">
</head>

<body>
    <h1>Edit Pokémon</h1>

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
            <th>Image</th>
            <th>Evolution Stage</th>
            <th>Height</th>
            <th>Weight</th>
            <th>HP</th>
            <th>Attack</th>
            <th>Defense</th>
            <th>Special Attack</th>
            <th>Special Defense</th>
            <th>Speed</th>
            <th>Ability 1</th>
            <th>Ability 1 Description</th>
            <th>Ability 2</th>
            <th>Ability 2 Description</th>
            <th>Ability 3</th>
            <th>Ability 3 Description</th>
            <th>Primary Type</th>
            <th>Secondary Type</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pokemonList as $pokemon): ?>
            <tr>
                <td><?= htmlspecialchars($pokemon['pokémon_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><input type="text" name="pokemon_name" value="<?= htmlspecialchars($pokemon['pokémon_name'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="pokemon_image" value="<?= htmlspecialchars($pokemon['pokémon_image'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="evolution_stage" value="<?= htmlspecialchars($pokemon['evolution_stage'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="height" value="<?= htmlspecialchars($pokemon['pokémon_height'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="weight" value="<?= htmlspecialchars($pokemon['pokémon_weight'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="hp" value="<?= htmlspecialchars($pokemon['pokémon_hp'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="attack" value="<?= htmlspecialchars($pokemon['pokémon_attack'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="defense" value="<?= htmlspecialchars($pokemon['pokémon_defence'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="special_attack" value="<?= htmlspecialchars($pokemon['pokémon_special_attack'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="special_defense" value="<?= htmlspecialchars($pokemon['pokémon_special_defense'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="speed" value="<?= htmlspecialchars($pokemon['pokémon_speed'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_1" value="<?= htmlspecialchars($pokemon['ability_1'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_1_description" value="<?= htmlspecialchars($pokemon['ability_1_description'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_2" value="<?= htmlspecialchars($pokemon['ability_2'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_2_description" value="<?= htmlspecialchars($pokemon['ability_2_description'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_3" value="<?= htmlspecialchars($pokemon['ability_3'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="ability_3_description" value="<?= htmlspecialchars($pokemon['ability_3_description'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="primary_type" value="<?= htmlspecialchars($pokemon['primary_type'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td><input type="text" name="secondary_type" value="<?= htmlspecialchars($pokemon['secondary_type'], ENT_QUOTES, 'UTF-8'); ?>" required></td>
                <td>
                    <form method="post" action="update.php">
                        <input type="hidden" name="pokemon_id" value="<?= $pokemon['pokémon_id']; ?>">
                        <button type="submit" name="update_pokemon">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>