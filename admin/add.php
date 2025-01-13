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
include_once './admin_function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN CREATE NEW POKEMON</title>
    <link rel="stylesheet" href="../admin/css/style.css" />
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