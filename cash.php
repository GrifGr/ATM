<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Выдача наличности</title>
</head>
<body>
<?php
$countBill = 1000;
$arrBill = array(500, 200, 100, 50, 20, 10, 5);
$cash = verification($arrBill, $countBill);

if ($cash) {
    echo "Сумма:". $cash."<br>";
    echo "Число купюр:" . giveCash($arrBill, $countBill, $cash);
}

function verification($arrBill, $countBill)
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

    if ($cash > maxSumCash($arrBill, $countBill)) {
        echo "Выдача невозможна: введена сумма больше чем есть в банкомате.";
        return false;
    }

    return $cash;
}

function maxSumCash($arrBill, $countBill)
{
    $maxCash = 0;


    foreach ($arrBill as $value) {
        $maxCash += $value * $countBill;
    }

    return $maxCash;
}

function giveCash($arrBill, $countBill, $cash)
{
    $textCash = "";
    $balance = $cash;

    foreach ($arrBill as $value) {
        $arrCash = calcCash($value, $countBill, $balance);
        $textCash = $textCash . (strlen($arrCash[0])>0?" ":"").$arrCash[0];
        $balance -= $arrCash[1];
    }

    return $textCash;
}

function calcCash($value, $countBill, $balance)
{
    if ($value > $balance) {
        return array("", 0);
    }

    $countBillResult = intdiv ($balance, $value)>$countBill?$countBill:intdiv ($balance, $value);

    return array($countBillResult . "x" . $value, $countBillResult*$value);
}

?>
<form action="http://atm/">
    <button>Вернуться к выбору суммы</button>
</form>
</body>
</html>
