<?php
    $python = "c:\\python36\\python.exe";
    if($_GET["id"]==2){
        $file = "C:\\xampp\htdocs\\pb\\front-end\\backend_analysis\\stop.py";
        $output=exec($python . " " . $file);
        echo $output;
    }else if($_GET["id"]==1){
        $file = "C:\\xampp\htdocs\\pb\\front-end\\backend_analysis\\start.py";
        $output=exec($python . " " . $file);
        echo $output;
    }
    
?>