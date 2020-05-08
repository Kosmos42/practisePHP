<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-practice/includes/helpers.inc.php'; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title><?= html($pageTitle); ?></title>
</head>

<body>
    <h1><?= html($pageTitle); ?></h1>
    <form action="?<?= html($action); ?>" method="post">
        <div>
            <label for="name">Имя: <input type="text" name="name" id="name" value="<?= html($name); ?>"></label>
        </div>
        <div>
            <label for="email">Электронная почта: <input type="text" name="email" id="email" value="<?= html($email); ?>"></label>
        </div>
        <div>
            <input type="hidden" name="id" value="<?= html($id); ?>">
            <input type="submit" value="<?= html($button); ?>">
        </div>
    </form>
</body>

</html>