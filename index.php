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
    <link rel="stylesheet" href="/css/style.css" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pokémons as $pokémon): ?>

                    <tr>
                        <td><?= $pokémon['pokémon_id']; ?></td>
                        <td><?= $pokémon['pokémon_name']; ?></td>
                        <td><img src="<?= $pokémon['pokémon_image']; ?>" alt=""></td>
                    </tr>

                <?php endforeach; ?>


            </tbody>
        </table>
    </div>
</body>

</html>