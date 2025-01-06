<?php
include_once "includes/css_js.inc.php";
require('db.inc.php');

// print '<pre>';
// print_r(getPokémons());
// print '</pre>';

$pokémons = getPokémons();

// pagination
$page = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
$itemsPerPage = 21;
$totalPokémon = count($pokémons);
$pages = ceil($totalPokémon / $itemsPerPage);
$pokémons = array_slice($pokémons, ($page - 1) * $itemsPerPage, $itemsPerPage);
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
            <a class="pokémon_ID_name" href="detail.php?id=<?= $pokémon['pokémon_id'] ?>">
                <div class="pokémon" <?php setBackgroundColor($pokémon['primary_type_name']) ?>>
                    <div class="pokémon_image"><img src="<?= $pokémon['pokémon_image']; ?>" alt="<?= $pokémon['pokémon_name']; ?>">
                    </div>
                    <div class="pokémon_ID_name" <?php setColor($pokémon['primary_type_name']) ?>> <?= $pokémon['pokémon_id']; ?> | <?= $pokémon['pokémon_name']; ?>
                    </div>
                    <div class="pokémon_type1">
                        <?php
                        $primaryTypeImage = getTypeImage($pokémon['primary_type_name']);
                        if ($primaryTypeImage) {
                            echo '<img class="type" src="' . $primaryTypeImage . '" alt="' . $pokémon['primary_type_name'] . '">';
                        }
                        ?>
                    </div>

                    <div class="pokémon_type2">
                        <?php
                        $secondaryTypeImage = getTypeImage($pokémon['secondary_type_name']);
                        if ($secondaryTypeImage) {
                            echo '<img class="type" src="' . $secondaryTypeImage . '" alt="' . $pokémon['secondary_type_name'] . '">';
                        }
                        ?>
                    </div>

                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <ul class="pagination">
        <?php if ($pages > 1): ?>
            <li class="page-link">
                <?php if ($page > 1): ?>
                    <a href="?page-nr=<?= $page - 1 ?>">PREVIOUS</a>
                <?php else: ?>
                    <span class="disabled"></span>
                <?php endif; ?>
            </li>

            <li class="page-link">
                <?php if ($page < $pages): ?>
                    <a href="?page-nr=<?= $page + 1 ?>">NEXT</a>
                <?php else: ?>
                    <span class="disabled"></span>
                <?php endif; ?>
            </li>
        <?php endif; ?>
    </ul>
</body>

</html>