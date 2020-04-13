<?php
if (isset($_GET['addjoke'])) {
    include 'form.html.php';
    exit();
}
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname-ijdb',
        'ijdbuser',
        'uDo@#U!tSv2WE9'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $output = 'Невозможно подключится к серверу баз данных.' .
        $e->getMessage();
    include 'output.html.php';
    exit();
}
if (isset($_POST['joketext'])) {
    try {
        $sql = 'INSERT INTO ijdb.joke SET
            joketext = :joketext,
            jokedate = CURDATE()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':joketext', $_POST['joketext']);
        $s->execute();
    } catch (PDOException $e) {
        $output = "Ошибка при добавлении шутки: " .
            $e->getMessage();
        include 'output.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

try {
    $sql = 'SELECT joketext FROM ijdb.joke';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $output = 'Ошибка при извлечении шуток: ' . $e->getMessage();
    include 'output.html.php';
    exit();
}

foreach ($result as $row) {
    $jokes[] = $row['joketext'];
}
include 'jokes.html.php';
