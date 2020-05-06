<?php

include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

if (isset($_GET['add'])) {
    $pageTitle = 'Новый Автор';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Добавить автора';

    include 'form.html.php';
    exit();
}

if (isset($_GET['addform'])) {
    include $_SERVER['DOCUMENT_ROOT'] .
        '/php-practice/includes/db.inc.php';

    try {
        $sql = 'INSERT INTO author SET
                name = :name,
                email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при добавлении автора.';
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Редактировать') {
    include $_SERVER['DOCUMENT_ROOT'] .
        '/php-practice/includes/db.inc.php';
    try {
        $sql = 'SELECT id, name, email FROM author WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при извлечении информации об авторе.';
        include 'error.html.php';
        exit();
    }

    $row = $s->fetch();

    $pageTitle = 'Редактировать автора';
    $action = 'editform';
    $name = $row['name'];
    $email = $row['email'];
    $id = $row['id'];
    $button = 'Обновить информацию об авторе';
    include 'form.html.php';
    exit();
}

if (isset($_GET['editform'])) {
    include $_SERVER['DOCUMENT_ROOT'] .
        '/php-practice/includes/db.inc.php';
    try {
        $sql = 'UPDATE author SET
                name = :name,
                email = :email
                WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();
    } catch (PDOException $e) {
        $error = 'Ошибка при обновлении запис об авторе.';
        include 'error.html.php';
        exit();
    }

    header('Location: .');
    exit();
}

try {
    include $_SERVER['DOCUMENT_ROOT'] . '/incudes/db.inc.php';
    $result = $pdo->query('SELECT id, name FROM author');
} catch (PDOException $e) {
    $error = 'Ошибка при извлечении авторов из базы данных!' . $e;
    include 'error.html.php';
    exit();
}

foreach ($result as $row) {
    $authors[] = array('id' => $row['id'], 'name' => $row['name']);
}

if (isset($_POST['action']) and $_POST['action'] == 'Удалить') {
    if (isset($_POST['confirm']) and $_POST['confirm'] == 'Подтверждаю') {
        include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';
        //Получаем шутки, принадлежащие автору.
        $authorId = $_POST['id'];
        echo "authorID: " . $_POST['id'];
        try {
            $sql = 'SELECT id FROM joke WHERE authorid = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $authorId);
            $s->execute();
        } catch (PDOException $e) {
            $error = 'Ошибка при получении списка шуток, которые нужно удалить.' . $e;
            include 'error.html.php';
            exit();
        }

        $result = $s->fetchAll();
        // Удаляем записи о категориях шуток
        try {
            $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
            $s = $pdo->prepare($sql);
            // Для каждой шутки
            foreach ($result as $row) {
                $jokeid = $row['id'];
                $s->bindValue(':id', $jokeid);
                $s->execute();
            }
        } catch (PDOException $e) {
            $error = 'Ошибка при удалении записей о категориях шутки.';
            include "error.html.php";
            exit();
        }

        // Удаляем шутки, принадлежащие автору.
        try {
            $sql = 'DELETE FROM joke WHERE authorid = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $authorId);
            $s->execute();
        } catch (PDOException $e) {
            $error = "Ошибка при удалении шуток, принадлижащих автору." . $e;
            include 'error.html.php';
            exit();
        }

        // Удаляем имя автора.
        try {
            include 'deleteauthor.html.php';
            $sql = 'DELETE FROM author WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $authorId);
            $s->execute();
            print_r($s);
        } catch (PDOException $e) {
            $error = "Ошибка при удалении автора.";
            include 'error.html.php';
            exit();
        }
        header('Location: .');
        exit();
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/php-practice/includes/db.inc.php';

        try {
            $sql = 'SELECT id, name FROM author WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
            $row = $s->fetch();
        } catch (PDOException $e) {
            $error = 'Ошибка при получении автора ' . $e;
            include 'error.html.php';
            exit();
        }
        $author = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
        include "confirm.html.php";
        exit();
    }
}

include 'authors.html.php';
