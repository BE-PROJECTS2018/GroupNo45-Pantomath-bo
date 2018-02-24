<?php
echo "init prediction started";

$python = "c:\\python36\\python.exe";
$file = "C:\\xampp\htdocs\\pb\\front-end\\backend\\analysis\\predict.py";
$file2 = "C:\\xampp\\htdocs\pb\\front-end\\backend\\analysis\\predict.py";

exec($python . " " . $file2, $output, $return_var);

if($return_var==0){
    //prediction done
    echo "ready";
}else{
    echo "not done with output:" . $return_var;
}
?>