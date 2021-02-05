<?php
require_once '../components/settings_db.php';

$sql = <<< SQL
SELECT DISTINCT *
  FROM links
  JOIN content
  ON links.id=content.link_id
WHERE links.id = '{$_GET['id']}';
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
    <link rel="stylesheet" href="../class/main.css">
</head>
<body>
<h1>News content</h1>

<form action="updeitik.php" method="POST" >
    <table >

        <?php foreach ($result as $key => $experience): ?>
            <tr>

                <p><input type="image"  src="<?= $experience['img_link'] ?>" ></p>
                <p><input type="url" class="input-group-text" name="link" value="<?= $experience['link'] ?>"></p>
                <p><input type="text"  name="header" value="<?= $experience['header'] ?>"></p>
                <p><input type="date" name="date" value="<?= date('Y-m-d', $experience['date']) ?>"></p>
                <p><textarea cols="100" rows="17" name="text"><?= $experience['text'] ?></textarea></p>

                <p><input type="submit" name="<?= $experience['id'] ?>" value="Update"></p>
            </tr>
        <?php endforeach; ?>
    </table>

</form>
</body>
</html>