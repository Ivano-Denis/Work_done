<?php
require_once '../components/settings_db.php';


if ($_GET['id']){
$sql = <<< SQL
DELETE FROM `links` WHERE `links`.`id` = '{$_GET['id']}'
SQL;
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
    $sql = <<< SQL
DELETE FROM `content` WHERE `content`.`id` = '{$_GET['id']}'
SQL;
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
} else {
$sql = <<< SQL
DELETE FROM `links`
SQL;
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
$sqli = <<< SQL
DELETE FROM `content`
SQL;
    $result = $pdo->query($sqli, PDO::FETCH_ASSOC);
}
header('Location: http://example.com/test_work/pars.php?page=1');
