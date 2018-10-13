<?php
    require('system/libs/DuzceBot.php');

    $duzceBot = new DuzceBot();
    $debug = $duzceBot->duyuruHttpOutput();

    print_r($debug);
?>