<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'ijdbuser', 'uDo@#U!tSv2WE9');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $error = 'Unable to connect to the database server.' .
        $e;
    include 'error.html.php';
    exit();
}
