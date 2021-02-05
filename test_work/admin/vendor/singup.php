<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("max_execution_time", 360);

    session_start();
    require_once 'connect.php';

    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];



    if ($password === $password_confirm){


        $path = 'upload/' . time() . $_FILES['avatar']['name'];
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], '..//' . $path)) {
            $_SESSION['message'] = 'Ошибка пи загрузке сообщения!!!';
            header('Location: http://example.com/test_work/admin/register.php');
        }

        $password = md5($password);
        $sql = "INSERT INTO `users` (`id`, `full_name`, `login`, `email`, `password`, `avatar`) 
VALUES (NULL, '$full_name', '$login', '$email', '$password', '$path')";

        $result = $pdo->query($sql, PDO::FETCH_ASSOC);

        $_SESSION['message'] = 'Регистрация прошла успешно!!!';
        header('Location: http://example.com/test_work/admin/autor.php');

    } else {
        $_SESSION['message'] = 'Пароли не совпадают!!!';
        header('Location: http://example.com/test_work/admin/register.php');
    }


