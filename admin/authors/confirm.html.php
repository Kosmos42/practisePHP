<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-practice/includes/helpers.inc.php'; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Подтверждение удаления</title>
</head>

<body>
    <p>Вы уверены что хотите удалить автора <?= html($author['name']); ?>
    </p>
    <form action="" method="post">
        <input type="hidden" name="id"
            value="<?= html($author['id']); ?>">
        <input type="hidden" name="action" value="Удалить">
        <input type="submit" name="confirm" value="Подтверждаю">
        <input type="submit" name="confirm" value="Отказываюсь">
    </form>
</body>

</html>