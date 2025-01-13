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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_pokemon'])) {
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

    // Insert query
    $stmt = $db->prepare("INSERT INTO pokémon (
        pokémon_name, pokémon_image, pokémon_evolutiuon_stage, pokémon_height,
        pokémon_weight, pokémon_hp, pokémon_attack, pokémon_defence,
        pokémon_special_attack, pokémon_special_defense, pokémon_speed,
        primary_type, secondary_type
    ) VALUES (
        :pokemon_name, :pokemon_image, :evolution_stage, :height,
        :weight, :hp, :attack, :defense,
        :special_attack, :special_defense, :speed,
        :primary_type, :secondary_type
    )");

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
        $_SESSION['message'] = "New Pokémon created successfully!";
    } else {
        $_SESSION['message'] = "Failed to create Pokémon.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pokémon</title>
    <link rel="stylesheet" href="css/create_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css">

</head>

<body>
    <h1>Create New Pokémon</h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='message'>" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <form method="post" action="create.php">
        <label for="pokemon_name">Name:</label>
        <input type="text" name="pokemon_name" id="pokemon_name" required>

        <label for="pokemon_image">Image URL:</label>
        <input type="text" name="pokemon_image" id="pokemon_image" required>

        <label for="evolution_stage">Evolution Stage:</label>
        <input type="text" name="evolution_stage" id="evolution_stage" required>

        <label for="height">Height:</label>
        <input type="text" name="height" id="height" required>

        <label for="weight">Weight:</label>
        <input type="text" name="weight" id="weight" required>

        <label for="hp">HP:</label>
        <input type="text" name="hp" id="hp" required>

        <label for="attack">Attack:</label>
        <input type="text" name="attack" id="attack" required>

        <label for="defense">Defense:</label>
        <input type="text" name="defense" id="defense" required>

        <label for="special_attack">Special Attack:</label>
        <input type="text" name="special_attack" id="special_attack" required>

        <label for="special_defense">Special Defense:</label>
        <input type="text" name="special_defense" id="special_defense" required>

        <label for="speed">Speed:</label>
        <input type="text" name="speed" id="speed" required>

        <label for="ability_1">Ability 1:</label>
        <input type="text" name="ability_1" id="ability_1" required>

        <label for="ability_1_description">Ability 1 Description:</label>
        <input type="text" name="ability_1_description" id="ability_1_description" required>

        <label for="ability_2">Ability 2:</label>
        <input type="text" name="ability_2" id="ability_2" required>

        <label for="ability_2_description">Ability 2 Description:</label>
        <input type="text" name="ability_2_description" id="ability_2_description" required>

        <label for="ability_3">Ability 3:</label>
        <input type="text" name="ability_3" id="ability_3" required>

        <label for="ability_3_description">Ability 3 Description:</label>
        <input type="text" name="ability_3_description" id="ability_3_description" required>

        <label for="primary_type">Primary Type:</label>
        <input type="text" name="primary_type" id="primary_type" required>

        <label for="secondary_type">Secondary Type:</label>
        <input type="text" name="secondary_type" id="secondary_type" required>

        <button type="submit" name="create_pokemon">Create Pokémon</button>
    </form>
</body>

</html>