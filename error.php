<?php
include_once "includes/css_js.inc.php";
require_once('users.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokéhub - Error</title>
    <link rel="stylesheet" href="<?= getCSS('index'); ?>">
    <script type="module" src="<?= getJS('index'); ?>"></script>
</head>

<body>
    <div class="error">
        <h1>Error 404</h1>
        <p>Page not found</p>
        <img src="https://media1.tenor.com/m/Zinv3gCVa58AAAAd/logobi-vitesse-logobi.gif" alt="Error GIF">
    </div>
</body>
<footer>
    <p>&copy; 2025 Pokéhub. All rights reserved.</p>
</footer>

</html>