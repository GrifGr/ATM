<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Выдача наличности</title>
</head>
<body>
<?php
include 'myFunction.php';

if (file_exists("data.json")) {
    $handle = fopen('data.json', 'rb');
    $str = fread($handle, filesize('data.json'));
    fclose($handle);
    $data = json_decode($str,true);

    $cash = verification($data);

    if ($cash) {

        echo "Сумма:". $cash."<br>";
        echo "Число купюр:" . giveCash($data,  $cash)["text"];

        include "table.php";
        printTable($data);

        saveData($data, "data");
    }

    echo "<br><a href=\"index.php\">Вернуться к выбору суммы</a>";
}
else {
    echo "Выдача невозможна: в банкомате нет денег. <br>";
    echo "Перейдите по  <a href=\"addCash.php\">ссылке</a> для внесения денег в банкомат";
}

function verification($data)
{
    if (isset($_POST['cash']) && $_POST['cash']) {
        $cash = $_POST['cash'];
    } else {
        echo "Выдача невозможна: не введена сумма.";
        return false;
    }

    if ($cash < 0) {
        echo "Выдача невозможна: введена отрицательная сумма.";
        return false;
    }

    if ($cash % 5) {
        echo "Выдача невозможна: введена сумма не кратная 5.";
        return false;
    }
    
    if (maxSumCash($data) == 0) {
        echo "Выдача невозможна: в банкомате нет денег. <br>";
        echo "Перейдите по  <a href=\"addCash.php\">ссылке</a> для внесения денег в банкомат";
        return false;
    }

    if ($cash > maxSumCash($data)) {
        echo "Выдача невозможна: введена сумма больше чем есть в банкомате.";
        return false;
    }



    $sumDiff = giveCash($data,  $cash)["sumDiff"];
    if ($sumDiff > 0) {
        echo "Выдача невозможна: наявными купюрами нет возможности выдать указанную сумму <br>";
        echo "Возможна выдача " . ($cash - $sumDiff) . " грн";
        return false;
    }


    return $cash;
}

function maxSumCash($data)
{
    $maxCash = 0;

    foreach ($data as $bill => $countBill) {
        $maxCash += $bill * $countBill;
    }

    return $maxCash;
}

function giveCash(&$data,  $cash)
{
    $textCash = "";
    $balance = $cash;
    foreach ($data as $bill => $countBill) {
        $countBillGive = calcCash($bill, $countBill, $balance);

        If ($countBillGive>0){
            $data[$bill] = ($countBill - $countBillGive);

            $textCash = $textCash . (strlen($textCash)>0?" ":"").$countBillGive . "x" . $bill;
            $balance -= ($countBillGive*$bill);
        }
    }

    return array("text"=>$textCash, "sumDiff"=>$balance);
}

function calcCash($bill, $countBill, $balance)
{

    if ($bill > $balance) {
        return 0;
    }

    $countBillResult = intdiv ($balance, $bill)>$countBill?$countBill:intdiv ($balance, $bill);

//    return array($countBillResult . "x" . $value, $countBillResult*$value);
//    echo $countBillResult;
    return $countBillResult;
}

?>

</body>
</html>
