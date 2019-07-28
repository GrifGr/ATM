<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Банкомат</title>
</head>
<body>

<form action="cash.php" method="post">
    <input type="number" name="cash" value="0" placeholder="Введите необходимую сумму">
    <input type="submit" value="Ввод">
</form>

<?php
if (file_exists("data.json")) {
    $handle = fopen('data.json', 'rb');
    $str = fread($handle, filesize('data.json'));
    fclose($handle);
    $data = json_decode($str, true);

    include "table.php";
    printTable($data);
}

?>
<a href="addCash.php">Добавить наличность в банкомат</a>
</body>
</html>