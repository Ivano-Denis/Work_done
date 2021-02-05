<?php
require_once 'components/settings_db.php';

var_dump($_GET);
$id = $_GET['id'];
$sql = <<< SQL
SELECT DISTINCT *
  FROM links
  JOIN content
  ON links.id=content.link_id
WHERE links.id = '$id'
SQL;

//SELECT DISTINCT * FROM content, links ORDER BY date DESC ;
$result = $pdo->query($sql, PDO::FETCH_ASSOC);

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
<h1 class="display-1" >News</h1>

<form action="sql/UPDATE.php" method="POST" >

    <table border = "2" class="table table-dark table-striped" >
        <tr>
            <th>id</th>
            <th>link</th>
            <th>header</th>
            <th>img_link</th>
            <th>date</th>
            <th>text</th>
            <th>motion</th>
        </tr>
        <?php foreach ($result as $key => $experience): ?>
            <tr>

                <td><?= $experience['id'] ?> </td>
                <td><?= $experience['link'] ?></td>
                <td><?= $experience['header'] ?></td>
                <td><?= $experience['img_link'] ?></td>
                <td><?= date('d.m.Y', $experience['date']) ?></td>
                <td><?= $experience['text'] ?></td>

                <td>
                    <p><a href="sql/UPDATE.php?id=<?= $experience['id'] ?>">Modify</a> </p>
                    <p><a href="pars.php?page=<?= 1 ?>">Done</a> </p>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</form>
</body>
</html>