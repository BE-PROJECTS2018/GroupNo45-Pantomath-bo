<?php

    include './serverScript/class/Database.php';

    if(isset($_GET["id"])){
        //create db
        $db = new Database();
        $db->connect();

        $db->select('pb_candidate_details','name',null,'c_id=' . $_GET["id"]);
        $res=$db->getResult();

        //check whether record is already there or not
        //if there do nothing
        if(empty($res[0]["name"])){
            //file locaton
            $filePath = 'backend/data_save/predictedFeatures.json';

            //get the content of thea json file
            $jsonStringData  = file_get_contents($filePath);

            //get json data in associative array
            $json = json_decode($jsonStringData,true);
            $json["c_id"]=$_GET["id"];

            //save it to db
            $db->insert('pb_score_data',$json);
        }

        //prepare for sending data to UI controller
        $db->sql('SELECT * FROM pb_score_data WHERE c_id=' . $_GET['id']);
        $res = $db->getResult();
        $row = $res[0]; // array of paramenter including id's
        $html="";
        foreach ($row as $key => $value) {
            # code...
            if($key == 's_id' || $key == 'c_id')
                continue;
            $html .= '
                <h3>' . $key . '</h3>
                <fieldset class="rating">';
                
                if($value>4.5)
                    {

                        $html .='<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" ' . 'checked="checked"' . ' /><label class = "full" for="star5" title="Awesome - 5 stars"></label>

                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                    }
                elseif ($value >4) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }
                elseif ($value>3.5) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" ' . 'checked="checked"' . '  /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }
                elseif ($value>3) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }elseif ($value >2.5) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3"  ' . 'checked="checked"' . '  /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }elseif ($value >2) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }elseif ($value>1.5) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" ' . 'checked="checked"' . '  /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }elseif ($value>1) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" ' . 'checked="checked"' . '  /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }elseif ($value>0.5) {
                    # code...
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" ' . 'checked="checked"' . '  /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }else{
                    $html .= '<input type="radio" id="star5" name=" ' . $key . '-rating" value="5" /><label class = "full" for="star5" 
                                title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4half" name=" ' . $key . '-rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                            <input type="radio" id="star4" name=" ' . $key . '-rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3half" name=" ' . $key . '-rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                            <input type="radio" id="star3" name=" ' . $key . '-rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2half" name=" ' . $key . '-rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                            <input type="radio" id="star2" name=" ' . $key . '-rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1half" name=" ' . $key . '-rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                            <input type="radio" id="star1" name=" ' . $key . '-rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                            <input type="radio" id="starhalf" name=" ' . $key . '-rating" value="half"  ' . 'checked="checked"' . ' /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>';
                }
            
            $html .=' </fieldset><br><br>';
            }
            
            echo $html;
            $db->disconnect();
    }else{
        echo 'Invalid request';
    }
?>