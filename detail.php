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
    <script src="/detail.js" defer></script>
</head>

<body>
    <div class="container" <?php setBackgroundColor($details['primary_type']) ?>>
        <div class="pokémon_image pokémon_self">
            <a href="<?= $details['pokémon_image'] ?>" data-lightbox="image-1"><img src='<?= $details['pokémon_image'] ?>' alt=''></a>
        </div>
        <div>
            <img class="pokémon_image pokémon_background" src="<?= setBackgroundImg($details['primary_type']) ?>" alt="grass-landscape">
        </div>
        <h1 class="pokémon_name" <?php setColor($details['primary_type']) ?>><?= $details['pokémon_id'] ?> | <?= $details['pokémon_name'] ?></h1>
        <div class="pokémon_info" <?php setColor($details['primary_type']) ?>>
            <p>Type: <?php
                        $primaryTypeImage = getTypeImage($details['primary_type']);
                        echo '<img class="type type1" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
                        ?>
                <?php $primaryTypeImage = getTypeImage($details['secondary_type']);
                echo '<img class="type type2" src="' . $primaryTypeImage . '" alt="' . $primaryTypeImage . '">';
                ?></p>
            <p>Evolution Stage: <?= $details['evolution_stage'] ? $details['evolution_stage'] : 'None' ?></p>
            <p>Height: <?= $details['pokémon_height'] ?> m.</p>
            <p>Weight: <?= $details['pokémon_weight'] ?> kg.</p>
        </div>
        <div class="pokémon_stats" <?php setColor($details['primary_type']) ?>>
            <table>
                <tr>
                    <td>HP</td>
                    <td class="pokémon_results"><?= $details['pokémon_hp'] ?></td>
                </tr>
                <tr>
                    <td>Attack</td>
                    <td class="pokémon_results"><?= $details['pokémon_attack'] ?></td>
                </tr>
                <tr>
                    <td>Defense</td>
                    <td class="pokémon_results"><?= $details['pokémon_defence'] ?></td>
                </tr>
                <tr>
                    <td>Special Attack</td>
                    <td class="pokémon_results"><?= $details['pokémon_special_attack'] ?></td>
                </tr>
                <tr>
                    <td>Special Defense</td>
                    <td class="pokémon_results"><?= $details['pokémon_special_defense'] ?></td>
                </tr>
                <tr>
                    <td>Speed</td>
                    <td class="pokémon_results"><?= $details['pokémon_speed'] ?></td>
                </tr>
            </table>
        </div>
        <div class="pokémon_abilities" <?php setColor($details['primary_type']) ?>>
            <table>
                <tr>
                    <td>Ability 1</td>
                    <td class="pokémon_ability_results" data-id="1"><?= $details['ability_1'] ?></td>
                </tr>
                <tr>
                    <td>Ability 2</td>
                    <td class="pokémon_ability_results" data-id="2"><?= $details['ability_2'] ?></td>
                </tr>
                <tr <?php if ($details['ability_3'] == "") {
                        echo "class='noThirdAbility'";
                    } ?>>
                    <td>Ability 3 :</td>
                    <td class="pokémon_ability_results" data-id="3"><?= $details['ability_3'] ?></td>
                </tr>
            </table>
        </div>
        <div class="pokémon_abilities_desc" <?php setColor($details['primary_type']) ?>>
            <table>
                <tr id="desc-1">
                    <td><?= $details['ability_1'] ?></td>
                    <td><?= $details['ability_1_description'] ?></td>
                </tr>
                <tr id="desc-2">
                    <td><?= $details['ability_2'] ?></td>
                    <td><?= $details['ability_2_description'] ?></td>
                </tr id="desc-3">
                <tr <?php if ($details['ability_3'] == "") {
                        echo "class='noThirdAbility'";
                    } ?>>
                    <td><?= $details['ability_2'] ?></td>
                    <td><?= $details['ability_3_description'] ?></td>
                </tr>
            </table>
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