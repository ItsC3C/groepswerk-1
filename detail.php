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
        <div class="pokémon_image">
            <a href="<?= $details['pokémon_image'] ?>" data-lightbox="image-1"><img src='<?= $details['pokémon_image'] ?>' alt=''></a>
        </div>
        <h1 class="pokémon_name"><?= $details['pokémon_id'] ?> | <?= $details['pokémon_name'] ?></h1>
        <div class="pokémon_info">
            <p>Type: <?= $details['primary_type'] ?><?= $details['secondary_type'] ? ' / ' . $details['secondary_type'] : '' ?></p>
            <p>Evolution Stage: <?= $details['evolution_stage'] ? $details['evolution_stage'] : 'None' ?></p>
            <p>Height: <?= $details['pokémon_height'] ?></p>
            <p>Weight: <?= $details['pokémon_weight'] ?></p>
        </div>
        <div class="pokémon_type1">
            <?php
            $primaryTypeImage = getTypeImage($details['primary_type']);
            echo '<img class="type" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
            ?>
        </div>

        <div class="pokémon_type2">
            <?php
            $primaryTypeImage = getTypeImage($details['secondary_type']);
            echo '<img class="type" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
            ?>
        </div>
        <div class="pokémon_stats">
            <h2>Stats</h2>
            <table>
                <tr>
                    <td>HP</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_hp'] ?></td>
                </tr>
                <tr>
                    <td>Attack</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_attack'] ?></td>
                </tr>
                <tr>
                    <td>Defense</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_defence'] ?></td>
                </tr>
                <tr>
                    <td>Special Attack</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_special_attack'] ?></td>
                </tr>
                <tr>
                    <td>Special Defense</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_special_defense'] ?></td>
                </tr>
                <tr>
                    <td>Speed</td>
                    <td class="pokémon_stats_results"><?= $details['pokémon_speed'] ?></td>
                </tr>
            </table>
        </div>
        <div class="pokémon_abilities">
            <p>Ability 1: <?= $details['ability_1'] ? '(' . $details['ability_1'] . ') ' . $details['ability_1_description'] : 'None' ?></p>
            <p>Ability 2: <?= $details['ability_2'] ? '(' . $details['ability_2'] . ') ' . $details['ability_2_description'] : 'None' ?></p>
            <p>Ability 3: <?= $details['ability_3'] ? '(' . $details['ability_3'] . ') ' . $details['ability_3_description'] : 'None' ?></p>
        </div>
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