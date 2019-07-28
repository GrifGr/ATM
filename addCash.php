<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Внесение купюр в банкомат</title>
</head>
<body>
<form action="addCashCalc.php" method="post">


<?php

$arrBill = array(500, 200, 100, 50, 20, 10, 5);
$countBill = 10;

$datadef = getCountBill($arrBill, $countBill);

include 'myFunction.php';
saveData($datadef, "dataDef");

foreach ($datadef as $bill => $countBill) {
    echo $bill . ': <br> <input type="text" value="'.$countBill.'" name="banknote'.$bill.'"> <br>';
}

function getCountBill($arrBill, $countBill){
    if (file_exists("dataDef.json")) {
        $handle = fopen('dataDef.json', 'rb');
        $str = fread($handle, filesize('dataDef.json'));
        fclose($handle);
        $datadef = json_decode($str,true);
    }
    else {
        foreach ($arrBill as $value) {
            $datadef[$value]= $countBill;
        }
    }
    return $datadef;
}
?>


    <br>
    <input type="submit" value="Ввод">
</form>
</body>
</html>