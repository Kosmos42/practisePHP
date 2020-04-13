<?php include_once $_SERVER['DOCUMENT_ROOT'] .
    '/includes/helpers.inc.php'; ?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title><?php htmlout($pageTitle); ?></title>
</head>

<body>
    <?php print_r($row); ?>
    <h1><?php htmlout($pageTitle); ?></h1>
    <h4><?php htmlout($row); ?></h4>
    <form action="?<?php htmlout($action); ?>" method="post">
        <div>
            <label for="name">Название: <input type="text" name="name" id="name" value="<?php htmlout($name); ?>"></label>
        </div>
        <div>
            <input type="hidden" name="id" value="<?php htmlout($id); ?>">
            <input type="submit" value="<?php htmlout($button); ?>">
        </div>
    </form>
</body>

</html>