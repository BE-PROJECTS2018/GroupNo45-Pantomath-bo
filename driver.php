<?php

    ini_set('max_execution_time', 300);

    if(isset($_GET["id"])){
        $python = "c:\\python36\\python.exe";
        $py = "py";
        
        if($_GET["id"]==2){
            $file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\stop.py";
            $output=exec($python . " " . $file);
            echo "stop is called";
            echo "<br>" . $output;

        }elseif($_GET["id"]==1){
            echo 'id=' . $_GET["id"];
            $file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\launcher.py";
            $output=exec($python . " " . $file);
            echo "<br>start is called<br>";
            echo $output;
        }
    }else{
        echo "Invalid request";
    }
    
?>