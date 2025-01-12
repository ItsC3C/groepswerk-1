<?php
require('db.inc.php');
require('includes/css_js.inc.php');

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
    <link rel="stylesheet" href="<?= getCSS("detail"); ?>" />
    <script type="module" src="<?= getJS("detail"); ?>"></script>
</head>

<header>
    <div class="name">
        <a href="index.php">
            <h1>PokéHub</h1>
        </a>
    </div>
    <div class="search">
        <input type="search" id="search-bar" placeholder="Search Character...">
    </div>
</header>

<body>
    <div class="container" <?php setBackgroundColor($details['primary_type']) ?>>
        <div class="pokémon_image">
            <a href="<?= $details['pokémon_image'] ?>" data-lightbox="image-1"><img src='<?= $details['pokémon_image'] ?>' alt=''></a>
        </div>
        <div class="pokémon_background">
            <img src="<?= setBackgroundImg($details['primary_type']) ?>" alt="landscape">
        </div>
        <div class="first_info">
            <h1 class="pokémon_name" <?php setColor($details['primary_type']) ?>><?= $details['pokémon_id'] ?> | <?= $details['pokémon_name'] ?></h1>
            <table class="pokémon_stats" <?php setColor($details['primary_type']) ?>>
                <tr>
                    <td>HP</td>
                    <td class="pokémon_results"><?= $details['pokémon_hp'] ?></td>
                </tr>
                <tr>
                    <td>Speed</td>
                    <td class="pokémon_results"><?= $details['pokémon_speed'] ?></td>
                </tr>
                <tr>
                    <td>Attack</td>
                    <td class="pokémon_results"><?= $details['pokémon_attack'] ?></td>
                </tr>
                <tr>
                    <td>Special Attack</td>
                    <td class="pokémon_results"><?= $details['pokémon_special_attack'] ?></td>
                </tr>
                <tr>
                    <td>Defense</td>
                    <td class="pokémon_results"><?= $details['pokémon_defence'] ?></td>
                </tr>
                <tr>
                    <td>Special Defense</td>
                    <td class="pokémon_results"><?= $details['pokémon_special_defense'] ?></td>
                </tr>
            </table>
        </div>
        <div class="pokémon_info" <?php setColor($details['primary_type']) ?>>
            <p>Type: <?php
                        $primaryTypeImage = getTypeImage($details['primary_type']);
                        echo '<img class="type type1" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
                        ?>
                <?php $primaryTypeImage = getTypeImage($details['secondary_type']);
                echo '<img class="type type2" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
                ?></p>
            <p>Evolution Stage: <?= $details['evolution_stage'] ? $details['evolution_stage'] : 'None' ?></p>
            <p>Height: <?= $details['pokémon_height'] ?> m. Weight: <?= $details['pokémon_weight'] ?> kg.</p>
        </div>
        <div class="pokémon_abilities" <?php setColor($details['primary_type']) ?>>
            <div class="pokémon_abilty_table">
                <div class="abillity">
                    <div class="ability_title">- Ability 1: <?= $details['ability_1'] ?>.</div>
                    <div class="ability_description"><?= $details['ability_1_description'] ?></div>
                </div>
                <div class="abillity">
                    <div class="ability_title">- Ability 2: <?= $details['ability_2'] ?>.</div>
                    <div class="ability_description"><?= $details['ability_2_description'] ?></div>
                </div>
                <div class="abillity" <?php if ($details['ability_3'] == "") {
                                            echo 'style="display:none;"';
                                        } ?>>
                    <div class="ability_title">- Ability 3: <?= $details['ability_3'] ?>.</div>
                    <div class="ability_description"><?= $details['ability_3_description'] ?>.</div>
                </div>
            </div>
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
    </div>
</body>

<footer>
    <p>&copy; 2025 PokeHub. All rights reserved.</p>
</footer>

</html>