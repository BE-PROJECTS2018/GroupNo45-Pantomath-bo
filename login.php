<?php
    include './serverScript/class/Database.php';

    if(isset($_POST["submit"])){
        $email = $_POST["email"];

        $db = new Database();
        $db->connect();

        //check whether user is already registered or not
        $db->sql('SELECT c_id FROM pb_candidate_details WHERE email="' . $email . '"');
        $res= $db->getResult();
        if(count($res)){
            $candidate_id = $res[0]["c_id"];
            echo '<script type="text/javascript">
                window.location = "./start.php?id=' . $candidate_id . '"
            </script>';
        }else{
            echo '<script type="text/javascript">
            alert("Wrong Mail Address or Not Registered");
            window.location = "./index.php?error=login" 
        </script>';         
        }
    }
?>