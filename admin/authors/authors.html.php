<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-pratice/includes/helpers.inc.php'; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Управление авторами</title>
</head>


<body>
    <h1>Управление авторами</h1>
    <p><a href="?add">Добавить нового автора</a></p>
    <p><a href="../categories">Управление списком категорий</a></p>
    <ul>
        <?php foreach ($authors as $author) : ?>
        <li>
            <form action="" method="POST">
                <div>
                    <?php htmlout($author['name']); ?>
                    <input type="hidden" name="id"
                        value="<?= $author['id']; ?>">
                    <input type="submit" value="Редактировать" name="action">
                    <input type="submit" name="action" value="Удалить">
                </div>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <p><a href="..">Вернутся на главную страницу</a></p>
</body>


</html>