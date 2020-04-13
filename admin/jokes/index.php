<?php

// Выводим форму поиска.
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

if (isset($_GET['add'])) {
    $pageTitle = 'Новая шутка';
    $action = 'addform';
    $text = '';
    $authorid = '';
    $id = '';
    $button = 'Добавить шутку';

    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
    // Формируем список авторов.

    try {
        $result = $pdo->query('SELECT id, name FROM author');
    } catch (PDOException $e) {
        $error = 'Ошибка при извлечении списка авторов.';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row) {
        $authors[] = array(
            'id' => $row['id'],
            'name' => $row['name']);
    }

    // Формируем список категорий.
    try {
        $result = $pdo->query('SELECT id, name FROM category');
    } catch (PDOException $e) {
        $error = 'Ошибка при извелечении списка категории.';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row) {
        $categories[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'selected' => false);
    }

    include 'form.html.php';
    exit();
}

if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    if ($_POST['author'] == '') {
        $error = 'Вы должные выбрать автора для этой шутки.
            Вернитесь назад и попробуйте еще раз';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'INSERT INTO joke SET
            joketext = :joketext,
            jokedate = CURDATE(),
            authorid = :authorid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':joketext', $_POST['text'], PDO::PARAM_STR);
        $s->bindValue(':authorid', $_POST['author'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при добавлении шутки.';
        include 'error.html.php';
        exit();
    }

    $jokeid = $pdo->lastInsertId();

    if (isset($_POST['categories'])) {
        try {
            $sql = 'INSERT INTO jokecategory SET
                jokeid = :jokeid,
                category = :categoryid';
            $s = $pdo->prepare();

            foreach ($_POST['categories'] as $categoryid) {
                $s->bindValue(':jokeid', $jokeid, PDO::PARAM_INT);
                $s->bindValue(':categoryid', $categoryid, PDO::PARAM_INT);
                $s->execute();
            }
        } catch (PDOException $e) {
            $error = 'Ошибка при добавлении шутки в выбранные категории.';
            include 'error.html.php';
            exit();
        }
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Редактировать') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    try {
        $sql = 'SELECT id, joketext, authorid
                FROM joke
                WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошбка при извлечении информации о шутке.';
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();

    $pageTitle = 'Редактировать шутку';
    $action = 'editform';
    $text = $row['joketext'];
    $authorid = $row['authorid'];
    $id = $row['id'];
    $button = 'Обновить шутку';

    // Формируем список авторов.
    try {
        $result = $pdo->query('SELECT id, name FROM author');
    } catch (PDOException $e) {
        $error = 'Ошибка при извлечении списка авторов.';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row) {
        $authors[] = array(
            'id' => $row['id'],
            'name' => $row['name']);
    }

    // Получаем список категорий, к которым принадлежит шутка.
    try {
        $sql = 'SELECT categoryid
                FROM jokecategory
                WHERE jokeid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при извечении списка выбранных категорий.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $selectedCategories[] = $row['categoryid'];
    }

    //Формируем список всех категорий.
    try {
        $result = $pdo->query('SELECT id, name
                                FROM category');
    } catch (PDOException $e) {
        $error = 'Ошибка при извлечении списка категорий.';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row) {
        $categories[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'selected' => in_array($row['id'], $selectedCategories)
        );
    }

    include 'form.html.php';
    exit();
}

if (isset($_GET['editform'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    if ($_POST['author'] == '') {
        $error = 'Вы должные выбрать автора для этой шутки.
            Вернитесь назад и попробуйте еще раз';
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'UPDATE joke SET
                joketext = :joketext,
                authorid = :authorid
                WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->bindValue(':joketext', $_POST['text'], PDO::PARAM_STR);
        $s->bindValue(':authorid', $_POST['author'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при обновлении шутки' . $e;
        include 'error.html.php';
        exit();
    }

    try {
        $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении лишних записей относительно категорий шутки.';
        include 'error.html.php';
        exit();
    }

    if (isset($_POST['categories'])) {
        try {
            $sql = 'INSERT INTO jokecategory SET
                    jokeid = :jokeid,
                    categoryid = :categoryid';
            $s = $pdo->prepare($sql);

            foreach ($_POST['categories'] as $categoryid) {
                $s->bindValue(':jokeid', $_POST['id'], PDO::PARAM_INT);
                $s->bindValue(':categoryid', $categoryid, PDO::PARAM_INT);
                $s->execute();
            }
        } catch (PDOException $e) {
            $error = 'Ошибка при добавлении шутки в выбранные категории';
            include 'error.html.php';
            exit();
        }

        header('Location: .');
        exit();
    }
}

if (isset($_POST['action']) and $_POST['action'] == 'Удалить') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    //Удаляем записи о категориях для этой шутки.
    try {
        $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении шутки из категорий.' . $e;
        include 'error.html.php';
        exit();
    }

    //Удаляем шутку.
    try {
        $sql = 'DELETE FROM joke WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue('id', $_POST['id'], PDO::PARAM_INT);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при удалении шутки.';
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}


if (isset($_GET['action']) and $_GET['action'] == 'search') {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

    // Базовое выражение SELECT
    $select = 'SELECT id, joketext';
    $from = ' FROM joke';
    $where = ' WHERE TRUE';

    $placeholders = array();

    //Автор выбран
    if ($_GET['author'] != '') {
        $where .= " AND authorid = :authorid";
        $placeholders[":authorid"] = $_GET['author'];
    }

    //Категория выбрана
    if ($_GET['category'] != '') {
        $from .= " INNER JOIN jokecategory ON id = jokeid";
        $where .= " AND categoryid = :categoryid";
        $placeholders['categoryid'] = $_GET['category'];
    }

    // Была указана какая-то искомая строка
    if ($_GET['text'] != '') {
        $where .= " AND joketext LIKE :joketext";
        $placeholders[':joketext'] = '%' . $_GET['text'] . '%';
    }

    //Выполнение запроса
    try {
        $sql = $select . $from . $where;
        $s = $pdo->prepare($sql);
        $s->execute($placeholders);
    } catch (PDOException $e) {
        $error = 'Ошибка при извелечении шуток.';
        include 'error.html.php';
        exit();
    }

    foreach ($s as $row) {
        $jokes[] = array('id' => $row['id'],
                         'text' => $row['joketext']);
    }

    include 'jokes.html.php';
    exit();
}

try {
    $result = $pdo->query('SELECT id, name FROM author');
} catch (PDOException $e) {
    $error = 'Ошибка при извлечении записей об авторах!';
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $authors[] = array('id' => $row['id'], 'name' => $row['name']);
}

try {
    $result = $pdo->query('SELECT id, name FROM category');
} catch (PDOException $e) {
    $error = 'Ошибка при извлечении категорий из базы данных!';
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $categories[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'searchform.html.php';
