<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-practice/includes/helpers.inc.php'; ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title><?= html($pageTitle); ?>
    </title>
    <style>
        textarea {
            display: block;
            width: 100%;
        }
    </style>
</head>

<body>
    <h1><?= html($pageTitle); ?>
    </h1>

    <form action="?<?= html($action); ?>" method="post">

        <div>
            <label for="text">Введите сюда свою шутку:</label>
            <textarea name="text" id="text" cols="40" rows="3">
                <?= html($text); ?>
            </textarea>
        </div>

        <div>
            <label for="author">Автор:</label>
            <select name="author" id="author">
                <option value="Не выбран">Выбрать</option>
                <?php foreach ($authors as $author) : ?>
                <option value="<?= html($author['id']); ?>" <?php
                if ($author['id'] == $authorid) {
                    echo ' selected';
                }
                ?>><?= html($author['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <fieldset>
            <legend>Категории:</legend>
            <?php foreach ($categories as $category) : ?>
            <div>
                <label
                    for="category<?= html($category['id']); ?>">
                    <input type="checkbox" name="categories[]"
                        id="category<?= html($category['id']); ?>"
                        value="<?= html($category['id']); ?>"
                        <?php
                        if ($category['selected']) {
                            echo ' checked';
                        }?>>
                    <?= html($category['name']); ?>
                </label>
            </div>
            <?php endforeach; ?>
        </fieldset>

        <div>
            <input type="hidden" name="id"
                value="<?= html($id); ?>">
            <input type="submit" value="<?= html($button); ?>">
        </div>

    </form>

</body>

</html>
