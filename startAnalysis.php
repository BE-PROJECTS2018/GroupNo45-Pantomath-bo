<?php 
    ini_set('max_execution_time', 300);

    if(isset($_GET["id"])){
        $python = "c:\\python36\\python.exe";
        
        if($_GET["id"]==3){
            $file = "C:\\xampp\\htdocs\\pb\\front-end\\serverSideAnalysis.py";
            $output=exec($python . " " . $file);
            echo "analysis is called";
            echo "<br>" . $output;

        }
    }else{
        echo "Invalid request";
    }
?>