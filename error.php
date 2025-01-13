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
        <h1><a href="/index.php" style="color: red;">Error 404</a></h1>
        <p>Page not found</p>
        <img src="https://cdn.svgator.com/images/2024/04/electrocuted-caveman-animation-404-error-page.gif" alt="Error GIF">
        <button><a href="https://youtu.be/2qBlE2-WL60?si=NunAPPlbImFmyVA6" target="_blank">CLICK HERE FOR FREE MONEY</a></button>
    </div>
</body>

</html>