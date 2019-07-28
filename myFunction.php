<?php
function saveData($data, $nameData){
    $handle = fopen($nameData.'.json', 'wb');

    $str = json_encode($data);
    fwrite($handle, $str);
    fclose($handle);
}
?>