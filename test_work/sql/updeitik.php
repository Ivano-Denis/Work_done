<?php

require_once '../components/settings_db.php';


foreach ($_POST as $key => $index){

    if (is_int($key)){
        $id = $key;
    }
}
$header = $_POST['header'];
$text = $_POST['text'];

$date = strtotime($_POST['date']);

$sql = <<< SQL
UPDATE `links` 
SET `link` = '{$_POST['link']}' 
WHERE `links`.`id` = '$id'
SQL;

$sql1 = <<< SQL
UPDATE `content`
SET `header` = '$header', `text` = '$text', `date` = '$date'
WHERE `content`.`id` = '$id'
SQL;

$result = $pdo->query($sql, PDO::FETCH_ASSOC);
$result = $pdo->query($sql1, PDO::FETCH_ASSOC);

header("Location: http://example.com/test_work/news.php?id=$id");
?>