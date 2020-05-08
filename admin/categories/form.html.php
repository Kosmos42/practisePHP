<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-practice/includes/helpers.inc.php'; ?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title><?= html($pageTitle); ?>
    </title>
</head>

<body>
    <?php print_r($row); ?>
    <h1><?= html($pageTitle); ?>
    </h1>
    <h4><?= html($row); ?>
    </h4>
    <form action="?<?= html($action); ?>" method="post">
        <div>
            <label for="name">Название: <input type="text" name="name" id="name"
                    value="<?= html($name); ?>"></label>
        </div>
        <div>
            <input type="hidden" name="id"
                value="<?= html($id); ?>">
            <input type="submit" value="<?= html($button); ?>">
        </div>
    </form>
</body>

</html>