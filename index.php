<?php
    ini_set('max_execution_time', 1000);
    
    require('system/libs/DuzceBot.php');

    $duzceBot = new DuzceBot();
    $debug = $duzceBot->getContent();

    print_r($debug);
?>