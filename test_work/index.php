<?php
require_once 'class/parsing.php';
require_once 'components/settings_db.php';


$parsObj = new parsing();

$parsObj->setUrl('https://dailyillini.com/news/');

$arrNewsLink = $parsObj->getNewsLink();

$sql = "SELECT link FROM links";
$result = $pdo->query($sql);
$links = [];
foreach ($result as $item){

    if ($item['link'] != NULL) {
        $links[] = $item['link'];
    } else {
        return;
    }
}

$result = array_diff($arrNewsLink, $links);


if (count($result) >= 1) {
    $sql = "INSERT INTO links (link, status_pars) VALUES (?,?)";


    foreach ($result as $link) {
        $pdo->prepare($sql)->execute([$link, '0']);
    }

    $stm = $pdo->query("SELECT * FROM links WHERE status_pars = 0");
    $links = $stm->fetchAll();


    foreach ($links as $link) {
        $content = $parsObj->getNewsContent($link['link']);


        $sql = "INSERT INTO content (link_id, header, img_link, date, text) VALUES (?,?,?,?,?)";
        $pdo->prepare($sql)->execute([
            $link['id'],
            $content['header'] ? $content['header'] : '',
            $content['img_link'] ? $content['img_link'] : '',
            $content['date'] ? $content['date'] : '',
            $content['text'] ? $content['text'] : '',
        ]);

        $sqlUpdate = "UPDATE links
        SET status_pars='1'
    WHERE id={$link['id']}";
        $q = $pdo->prepare($sqlUpdate);
        $q->execute();
        header('Location: http://example.com/test_work/pars.php?page=1');
    }
} else{
    header('Location: http://example.com/test_work/pars.php?page=1');
}