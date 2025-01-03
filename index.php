<?php
include_once "includes/css_js.inc.php";
require('db.inc.php');

// print '<pre>';
// print_r(getPokémons());
// print '</pre>';

$pokémons = getPokémons();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="style.css" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <div class="table">
        <?php foreach ($pokémons as $pokémon): ?>
            <div class="pokémon">
                <div class="pokémon_image"><img src="<?= $pokémon['pokémon_image']; ?>" alt=""></div>
                <div class="pokémon_ID_name"><?= $pokémon['pokémon_id']; ?> | <?= $pokémon['pokémon_name']; ?></div>
                <div class="pokémon_type1"><?= $pokémon['types.pokémon_id']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>