<?php
ini_set('max_execution_time', 300); 
    if(isset($_GET["id"])){
        $python = "c:\\python36\\python.exe";
        if($_GET["id"]==2){
            //$file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\stop.py";
            //$output=exec($python . " " . $file);
            echo "stop is called";
        }elseif($_GET["id"]==1){
            //$file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\launcher.py";
            //$output=exec($python . " " . $file);
            echo "start is called";
        }
    }else{
        echo "Invalid request";
    }
    
?>