<?php
require('db.inc.php');

$id = $_GET['id'];
// $pokéId = getPokémonById($id);
$details = getDetailsPokémonById($id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="style_detail.css" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <div class="container">
        <a href="<?= $details['pokémon_image'] ?>" data-lightbox="image-1"><img src='<?= $details['pokémon_image'] ?>' alt=''></a>
        <h1><?= $details['pokémon_name'] ?></h1>
        <p>ID: <?= $details['pokémon_id'] ?></p>
        <p>Type: <?= $details['primary_type'] ?><?= $details['secondary_type'] ? ' / ' . $details['secondary_type'] : '' ?></p>
        <p>Evolution Stage: <?= $details['evolution_stage'] ? $details['evolution_stage'] : 'None' ?></p>
        <p>Height: <?= $details['pokémon_height'] ?></p>
        <p>Weight: <?= $details['pokémon_weight'] ?></p>
        <div class="stats">
            <h2>Stats</h2>
            <div>
                <p>HP: <?= $details['pokémon_hp'] ?></p>
                <p>Attack: <?= $details['pokémon_attack'] ?></p>
                <p>Defense: <?= $details['pokémon_defence'] ?></p>
                <p>Special Attack: <?= $details['pokémon_special_attack'] ?></p>
                <p>Special Defense: <?= $details['pokémon_special_defense'] ?></p>
                <p>Speed: <?= $details['pokémon_speed'] ?></p>
            </div>
        </div>
        <p>Ability 1: <?= $details['ability_1'] ? '(' . $details['ability_1'] . ') ' . $details['ability_1_description'] : 'None' ?></p>
        <p>Ability 2: <?= $details['ability_2'] ? '(' . $details['ability_2'] . ') ' . $details['ability_2_description'] : 'None' ?></p>
        <p>Ability 3: <?= $details['ability_3'] ? '(' . $details['ability_3'] . ') ' . $details['ability_3_description'] : 'None' ?></p>
        <div class="button-container">
            <?php if ($details['pokémon_id'] > 1): ?>
                <button class="button"><a href="detail.php?id=<?= $details['pokémon_id'] - 1 ?>">Previous</a></button>
            <?php endif; ?>
            <?php if ($details['pokémon_id'] < 151): ?>
                <button class="button"><a href="detail.php?id=<?= $details['pokémon_id'] + 1 ?>">Next</a></button>
            <?php endif; ?>
        </div>
    </div>

</body>



</html>