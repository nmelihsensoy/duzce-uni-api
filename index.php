<?php
    ini_set('max_execution_time', 1000);
    ini_set('memory_limit', '1300M');
    
    require('system/libs/DuzceBot.php');

    $duzceBot = new DuzceBot();
    $debug = $duzceBot->getContent();

    echo '<pre>';
    print_r($debug);
    echo '</pre>';
?>