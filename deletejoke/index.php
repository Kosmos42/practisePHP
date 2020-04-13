<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'ijdbuser', 'uDo@#U!tSv2WE9');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $error = 'Невозможно подключится к серверу баз данных.';
    include 'error.html.php';
    exit();
}
if (isset($_GET['deletejoke'])) {
    try {
        $sql = 'DELETE FROM joke WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении шутки: ' . $e->getMessage();
    }

    header('Location: .');
    exit();
}

try {
    $sql = 'SELECT id, joketext FROM joke';
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    $error = "Ошибка при извелечении шуток: " . $e->getMessage();
    include 'error.html.php';
    exit();
}
foreach ($result as $row) {
    $jokes[] = array('id' => $row['id'], 'text' => $row['joketext']);
}

include 'jokes.html.php';
