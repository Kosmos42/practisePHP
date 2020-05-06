<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Список шуток</title>
</head>

<body>
    <p> Вот все шутки которые есть в базе данных:</p>
    <?php foreach ($jokes as $joke) : ?>
    <form action="?deletejoke" method="POST">
        <blockquote>
            <p>
                <?= htmlspecialchars($joke['text'], ENT_QUOTES, "UTF-8"); ?>
                <input type="hidden" name="id"
                    value="<?= $joke['id']; ?>">
                <input type="submit" value="Удалить">
            </p>
        </blockquote>
    </form>
    <?php endforeach; ?>
</body>

</html>