<?php

    ini_set('max_execution_time', 300);

    if(isset($_GET["id"])){
        $python = "c:\\python36\\python.exe";
        
        if($_GET["id"]==2){
            $file = "C:\\xampp\\htdocs\\pb\\front-end\\stop.py";
            $output=exec($python . " " . $file);
            echo "stop is called";
            echo "<br>" . $output;

        }elseif($_GET["id"]==1){
            echo 'id=' . $_GET["id"];
            $file = "C:\\xampp\\htdocs\\pb\\front-end\\launcher.py";
            $output=exec($python . " " . $file);
            echo "started";
            
        }
    }else{
        echo "Invalid request";
    }
    
?>