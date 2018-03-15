<?php
    $server_ip = "192.168.0.7";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $server_ip . "/dataHandler.php");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'csv' => '@/data_save/realtimeVideoCues.csv'
            //'audio' => '@/file.wav'
    ));

    $result = curl_exec($ch);
    curl_close($ch);
?>