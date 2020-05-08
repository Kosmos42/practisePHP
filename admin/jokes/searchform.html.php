<?php include_once $_SERVER['DOCUMENT_ROOT'] .
'/php-practice/includes/helpers.inc.php'; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Управление шутками</title>
</head>

<body>
    <h1>Управление шутками</h1>
    <p><a href="?add">Добавить новую шутку</a></p>
    <form action="" method="get">
        <p>Вывести шутки, которые удовлетворяют следующим критериям:</p>

        <div>
            <label for="author">По автору:</label>
            <select name="author" id="author">
                <option value="">Любой автор</option>
                <?php foreach ($authors as $author) : ?>
                <option
                    value="<?= html($author['id']); ?>">
                    <?= html($author['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="cateogry">По категории:</label>
            <select name="category" id="category">
                <option value="">Любая категория</option>
                <?php foreach ($categories as $category) : ?>
                <option
                    value="<?= html($category['id']); ?>">
                    <?= html($category['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="text">Содержит текст:</label>
            <input type="text" name="text" id="text">
        </div>
        <div>
            <input type="hidden" name="action" value="search">
            <input type="submit" value="Искать">
        </div>
    </form>
    <p><a href="..">Вернуться на главную страницу</a></p>
</body>

</html>