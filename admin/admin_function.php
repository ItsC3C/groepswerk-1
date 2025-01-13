<?php
require_once '../db.inc.php';

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
