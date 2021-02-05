<?php
session_start();
require_once 'components/settings_db.php';



$page = $_GET['page']; // текущая страница
$kol = 10;  //количество записей для вывода
$art = ($page * $kol) - $kol; // определяем, с какой записи нам выводить

$sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id ORDER BY date DESC LIMIT " . "$art" . "," . "$kol";
$result = $pdo->query($sql);


if (isset($_GET['page'])){
    $page = $_GET['page'];
}else
    $page = 1;

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

        $sql = "DELETE FROM `content` WHERE `content`.`id` = '$item'";
        $result = $pdo->query($sql, PDO::FETCH_ASSOC);

        header('Location: http://example.com/test_work/pars.php?page=1 ');
    }
}

if ($_POST['search']){
    $search = $_POST['search'];
    $sql = "SELECT DISTINCT * FROM links JOIN content ON links.id=content.link_id WHERE `header` LIKE '%$search%'";
    $result = $pdo->query($sql, PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="class/main.css">
</head>
<body>
<h1 class="display-1" >News content</h1>

<form action="pars.php?page=<?= 1 ?>" method="POST" >

    <table border = "2" class="table table-dark table-striped" >
        <td>
            <p><a href="gmail-email/index.php?>"><input type="button" class="btn btn-success" value="Reload"></a> </p>
        </td>

        <td>
            <input type="date" name="start" value="<?=$_POST['start'] ?>" placeholder="Поиск">
            <input type="date" name="end" value="<?=$_POST['end'] ?>" placeholder="Поиск">
            <input type="submit" class="btn btn-success" name="find" value="Найти">
        </td>

        <td> <p><a href="pars.php?page=<?= 1 ?>"><input type="button" class="btn btn-success" value="All news"></a> </p></td>
        <td>
            <p><a href="admin/autor.php?>"> <input type="button" class="btn btn-success" value="Exit"></a> </p>
        </td>

        <tr>
            <th>id</th>
            <th>header</th>
            <th><p>
                    <label for="sort_by">date</label>
                    <select name="sort_by"  id="sort_by" size="1" onchange="this.form.submit()" title="Sort" >
                        <option value="0">...Выберите тип сортировки...</option>
                        <option value="DESC">Убывание</option>
                        <option value="ASC">Возростание</option>
                    </select>
                </p></th>
            <th>
                <p><a href="sql/DELETE.php" id="delete"><input type="button" class="btn btn-success" id="tip" name="delete" value="Delete all news"></a> </p>
                <p><a href="pars.php" id="del"> <input type="submit" class="btn btn-success" id="del" name="del" value="Delete news"></a></p>
            </th>
        </tr>
        <?php foreach ($result as $key => $experience): ?>
            <tr>

                <td><?= $experience['id'] ?></td>
                <td><a href="news.php?id=<?= $experience['id'] ?>"><?= $experience['header'] ?></a></td>
                <td><?= date('d.m.Y', $experience['date']) ?></td>

                <td>
                    <p><a href="sql/DELETE.php?id=<?= $experience['id'] ?>">Delete</a> </p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"  name="<?= $experience['id'] ?>" id="<?= $experience['id'] ?>">
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (!$_POST['start'] && !$_POST['end'] && !$_POST['search'] ):?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="pars.php?page=<?=1?>">First</a></li>
                <?php for ($i = 1; $i <= $str_pag; $i++): ?>

                    <li class="page-item"><a class="page-link" href="pars.php?page=<?=$i?>"><?=$i?></a></li>

                <?php endfor; ?>
                <li class="page-item"><a class="page-link" href="pars.php?page=<?=$str_pag?>">last</a></li>
            </ul>
        </nav>
        <?php endif; ?>

            <input type="search" minlength="2" name="search" placeholder="Поиск">
            <button type="submit"  class="btn btn-success">Найти</button>
    </table>

</form>
</body>
</html>