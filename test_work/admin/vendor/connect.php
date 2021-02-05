<?php
$dsn = 'mysql:dbname=parce;host=localhost';
$user = 'root';
$password = 'password';

try {
    $pdo = new PDO($dsn, $user, $password);

} catch (PDOException $e) {
    echo 'Подключение не удалось: '. $e->getMessage();
}

