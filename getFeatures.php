<?php

    include './serverScript/class/Database.php';

    if(isset($_GET["id"])){
        
        //file locaton
        $filePath = 'backend/data_save/predictedFeatures.json';

        //get the content of thea json file
        $jsonStringData  = file_get_contents($filePath);

        //get json data in associative array
        $json = json_decode($jsonStringData,true);
        $json["c_id"]=$_GET["id"];

        //create db connnection and save it to db
        $db = new Database();
        $db->connect();
        $db->insert('pb_score_data',$json);
        $db->disconnect();

        //prepare for sending data to UI controller
        header('Content-Type: application/json');
        echo json_encode($json);
        
    }else{
        echo 'Invalid request';
    }
?>