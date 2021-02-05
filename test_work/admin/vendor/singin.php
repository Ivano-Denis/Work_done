<?php

    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = md5($_POST['password']);


    $sql = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'";

    $result = $pdo->query($sql, PDO::FETCH_ASSOC);




    if ($result->fetchColumn() > 0) {

        header('Location: http://example.com/test_work/pars.php?page=1');
    } else {
        $_SESSION['message'] = 'Неверный логин или пароль';
        header('Location: http://example.com/test_work/admin/autor.php');
    }