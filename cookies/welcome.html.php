<?php include_once $_SERVER['DOCUMENT_ROOT'] .
'/php-practice/includes/helpers.inc.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Счетчик cookies</title>
</head>

<body>
    <p>
        <?php
    if ($visits > 1) {
        echo "Номер данного посещения: $visits.";
    } else {
        // Перво посещение
        echo 'Добро пожаловать на мой веб-сайт! Клинкните здесь, чтобы узнать больше!';
    }
    ?>
    </p>
</body>

</html>