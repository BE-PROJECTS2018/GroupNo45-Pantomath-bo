<?php
    include './serverScript/class/Database.php';


    if(isset($_POST["submit"])){

        $Fname = $_POST["fname"];
        $Lname = $_POST["lname"];
        $age = $_POST["age"];
        $image_data = $_POST["image_data"];
        $college = $_POST["college"];
        $stream = $_POST["stream"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $degree = $_POST["degree"];
        $experience = $_POST["experience"];

        $name = $Fname . " " . $Lname;


        /**
         * Receive file and store to candidate directory
         */

        $uploadDir = "candidate/Resume/";
        $uploadfile = $email . "_" . basename($_FILES["file"]["name"]);
        /*
        if(move_uploaded_file($_FILES['resume']['tmp_name'], $uploadfile))
        {
            echo "The file has been uploaded successfully";
        }
        else
        {
            echo "There was an error uploading the file";
        }
*/
        $temp_name  = $_FILES['file']['tmp_name'];
        if(isset($name)){
            if(!empty($name)){      
                $location = $uploadDir;      
                if(move_uploaded_file($temp_name, $location.$uploadfile)){
                    echo 'File uploaded successfully';
                }
            }       
        }  else {
            echo 'You should select a file to upload !!';
        }

        /**
         * convert image data uri to image file
         */

        $file_path = "candidate/Images/" . $email . "__Image.png";
        $img = str_replace('data:image/png;base64,', '', $image_data);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);
        
        file_put_contents($file_path, $img);

        $db = new Database();
        $db->connect();

        $db->insert('pb_candidate_details',array(
            'name'=>$name,
            'age'=>$age,
            'college'=>$college,
            'resume'=>$uploadfile,
            'photo'=>$file_path,
            'degree'=>$degree,
            'experience'=>$experience,
            'mobile'=>$phone,
            'email'=>$email,
            'Stream'=>$stream));

        $res = $db->getResult();
        $db->disconnect();
        $error=false;
        if(strlen($res[0][0] . "")>2){
            //echo 'Some Error Occured';
            $error=true;
        }

        echo '<script type="text/javascript">
           window.location = "./index.php?error="' . $error . ' 
      </script>';
    }
?>
