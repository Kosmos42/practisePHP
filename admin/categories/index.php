<?php
include_once $_SERVER['DOCUMENT_ROOT'] .
    '/php-practice/includes/magicquotes.inc.php';

if (isset($_GET['add'])) {
    $pageTitle = 'Новая категория';
    $action = 'addform';
    $name = '';
    $id = '';
    $button = 'Добавить категорию';

    include 'form.html.php';
    exit();
}

if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO category SET
            name = :name';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при добавлении категории.';
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Редактировать') {
    include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

    try {
        $sql = 'SELECT id, name FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        print_r($_POST['id']);
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->execute();
        print_r($s);
    } catch (PDOException $e) {
        $error = 'Ошибка при извлечении информации о категории.';
        include  'error.html.php';
        exit();
    }

    $row = $s->fetch();

    $pageTitle = 'Редактировать категорию.';
    $action = 'editform';
    $name = $row['name'];
    $id = $row['id'];
    $button = 'Обновить категорию';

    include 'form.html.php';
    exit();
}

if (isset($_GET['editform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

    try {
        $sql = 'UPDATE category SET
            name = :name
            WHERE id = :id';
        $s = $pdo->prepare($sql);
        print_r($_POST['id'] . '\n');
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        print_r($_POST['name']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при обновлении категории.';
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Удалить') {
    include $_SERVER['DOCUMENT_ROOT'] .
        '/php-practice/includes/db.inc.php';

    $categoryId = $_POST['id'];

    //Удаляем все записи, связывающие шутки с этой категорией.
    try {
        $sql = 'DELETE FROM jokecategory WHERE categoryid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении шуток из категории.' . $e;
        include 'error.html.php';
        exit();
    }

    include $_SERVER['DOCUMENT_ROOT'] .
        '/php-practice/includes/db.inc.php';

    // Удаляем категорию.
    try {
        $sql = 'DELETE FROM category WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $s->execute();
        print_r($s);
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении категории.' . $e;
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

//Выводим список категорий
include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

try {
    $result = $pdo->query('SELECT id, name FROM category');
} catch (PDOException $e) {
    $error = 'Ошибка при извлечении категорий из базы данных!';
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $categories[] = array('id' => $row['id'],
                            'name' => $row['name']);
}
include 'categories.html.php';
