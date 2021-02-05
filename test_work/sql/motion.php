<?php
session_start();
require_once '../components/settings_db.php';
include '../pars.php';

var_dump($_GET);
var_dump($_POST);

$sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id";
$result = $pdo->query($sql);

$page = $_GET['page']; // текущая страница
$kol = 10;  //количество записей для вывода
$art = ($page * $kol) - $kol; // определяем, с какой записи нам выводить

$sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id LIMIT " . "$art" . "," . "$kol";
$result = $pdo->query($sql);


if (isset($_GET['page'])){
    $page = $_GET['page'];
}else $page = 1;

$res = "SELECT COUNT(*) FROM `links`";
$row = $pdo->query($res);
foreach ($row as $item){
    $total = $item['0']; // всего записей
}


$str_pag = ceil($total / $kol);

//var_dump($_GET);
//var_dump($_POST);
if ($_POST['start'] && $_POST['end']) {
    $start = strtotime($_POST['start']);
    $end = strtotime($_POST['end']);
    $sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id WHERE date Between '$start' AND '$end'";
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);

} elseif($_POST['start']) {
    $start = strtotime($_POST['start']);
    $date = date('d-m-Y');
    $end = strtotime($date);
    $sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id WHERE date Between '$start' AND '$end'";
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);

}elseif($_POST['end']) {
    $end = strtotime($_POST['end']);
    $sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id WHERE date <= '$end'";
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
}

if ($_POST['sort_by']){
    $sort = $_POST['sort_by'] ;
    $sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id ORDER BY date " . "$sort";
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
}


if ($_POST['del']){
    $result = array_keys($_POST, 'on', true);
    foreach ($result as $item){
        $sql = "DELETE FROM `links` WHERE `links`.`id` = '$item'";
        $result = $pdo->query($sql, PDO::FETCH_ASSOC);
        $sql = "DELETE FROM `content` WHERE `links`.`id` = '$item'";
        $result = $pdo->query($sql, PDO::FETCH_ASSOC);

        header('Location: http://example.com/test_work/pars.php?page=1 ');
    }
}
//header('Location: http://example.com/test_work/pars.php?page=1 ');
