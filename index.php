<?php
include_once "includes/css_js.inc.php";
require('db.inc.php');

// print '<pre>';
// print_r(getPokémons());
// print '</pre>';

// filters
$selectedAlphabet = $_GET['alphabet'] ?? null;
$selectedType = $_GET['type'] ?? null;
$pokémons = getPokémons($selectedAlphabet, $selectedType);

// pagination
$page = isset($_GET['page-nr']) ? (int)$_GET['page-nr'] : 1;
$itemsPerPage = 20;
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
    <h1><a href="./">PokéHub</a></h1>
    <div class="filter-container">
        <h3>Filter by Alphabet:</h3>
        <div class="alphabets">
            <?php
            $alphabets = range('A', 'Z');
            foreach ($alphabets as $alphabet) {
                echo '<a href="?alphabet=' . $alphabet . '">' . $alphabet . '</a> | ';
            }
            ?>
        </div>
        <h3>Filter by Type:</h3>
        <div class="types">
            <select name="type" onchange="window.location.href=this.value">
                <option value="">Select a type</option>
                <?php
                $types = array('Normal', 'Fire', 'Water', 'Grass', 'Ice', 'Electric', 'Psychic', 'Fighting', 'Poison', 'Ground', 'Flying', 'Bug', 'Rock', 'Ghost', 'Steel', 'Dragon', 'Dark', 'Fairy');
                foreach ($types as $type) {
                    echo '<option value="?type=' . $type . '">' . $type . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
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