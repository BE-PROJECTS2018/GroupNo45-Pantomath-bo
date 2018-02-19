<?php
    include './serverScript/class/Database.php';


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
    $uploadDir = "candidate_resume/";
    $uploadfile = $uploadDir . $email . "__resume.pdf";

    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
    {
        echo "The file has been uploaded successfully";
    }
    else
    {
        echo "There was an error uploading the file";
    }

    /**
     * convert image data uri to image file
     */

    $file_path = "candidate/Images/" . $email . "__Image.png";
    $img = str_replace('data:image/png;base64,', '', $image_data);
    $img = str_replace(' ', '+', $img);
    $img = base64_decode($img);
    
    file_put_contents($file_path, $img);
    
    print "Image has been saved!";

    $db = new Database();
    $db->connect();

    $db->insert('CRUDClass',array(
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
    print_r($res);
?>