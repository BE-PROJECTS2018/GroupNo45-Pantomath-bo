<?php
ini_set('max_execution_time', 300); 
    if(isset($_GET["id"])){
        $python = "c:\\python36\\python.exe";
        if($_GET["id"]==2){
            $file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\stop.py";
            $output=exec($python . " " . $file);
            if(strcmp("file removed",$output)==0){
                //initialize prediction process
                echo "init prediction started";
                $file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\predict.py";
                $output=exec($python . " " . $file);
                echo "\n" . $output;
            }
        }elseif($_GET["id"]==1){
            $file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\start.py";
            $output=exec($python . " " . $file);
            echo $output;
        }
    }else{
        echo "Invalid request";
    }
    
?>