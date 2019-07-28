<?php

if (file_exists("dataDef.json")) {
    $handle = fopen('dataDef.json', 'rb');
    $str = fread($handle, filesize('dataDef.json'));
    fclose($handle);
    $datadef = json_decode($str, true);
    $err = '';

    foreach ($datadef as $bill => $countBill) {
        if (isset($_POST["banknote" . $bill]) && $_POST["banknote" . $bill]) {
            $cash = $_POST["banknote" . $bill];
        } else {
            $cash = 0;
        }

        if (!filter_var($cash, FILTER_VALIDATE_INT)) {
            $err = $err . "Введіть правильне значення для купюр по $bill грн<br>";
        }

        $data[$bill] = $cash;
    }

    if ($err != '') {
        echo $err;
        echo "<a href=\"addCash.php\">Повернутися до внесення банкнот в банкомат</a>";
    }
    else{
        include 'myFunction.php';

        saveData($data, "data");
        saveData($data, "dataDef");

        header("Location: http://atm//");
    }
} else {
    header("Location: http://atm//addCash");
}
?>