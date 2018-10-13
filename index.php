<?php
    require('system/libs/DuzceBot.php');

    $duzceBot = new DuzceBot();
    $debug = $duzceBot->getContent();

    print_r($debug);
?>