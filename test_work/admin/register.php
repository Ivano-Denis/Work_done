<?php
    session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>



<!-- Форма авторизации -->

<form action="vendor/singup.php" method="post" enctype="multipart/form-data">
    <label>Фио</label>
    <input type="text" name="full_name" placeholder="Введите свое полное Имя">
    <label>Логин</label>
    <input type="text" name="login" placeholder="Введите свой логин">
    <label>Почта</label>
    <input type="email" name="email" placeholder="Введите адрес своей почты">
    <label>Загрузите изображение профиля</label>
    <input type="file" name="avatar">
    <label>Пароль</label>
    <input type="password" name="password" placeholder="Введите свой пароль">
    <label>Подтверждение пароля</label>
    <input type="password" name="password_confirm" placeholder="Подтверждение пароля">
    <button type="submit">Зарегистрировать</button>
    <p>
        У вас уже есть аккаунт? - <a href="autor.php">авторизируйтесь</a>
    </p>
    <?php
        if ($_SESSION['message']){
            echo '<p class="msg">'.$_SESSION['message'].' </p>';
        }
         unset ($_SESSION['message']);
    ?>
</form>

</body>
</html>