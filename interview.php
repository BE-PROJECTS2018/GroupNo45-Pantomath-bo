<?php
    include './serverScript/class/Database.php';

    $db = new Database();
    $db->connect();

    $db->sql("SELECT count(*) as num FROM pb_candidate_list;");

    $num_conducted = $db->getResult();

    $db->sql("SELECT count(*) as num FROM pb_candidate_details;");
    $num_total = $db->getResult();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example that shows off a blog page with a list of posts.">
    <title>Blog &ndash; Layout Examples &ndash; Pure</title>
    
    <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <!-- JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bower_components/rickshaw/vendor/d3.min.js"></script>
    <script type="text/javascript" src="./js/bower_components/rickshaw/vendor/d3.layout.min.js"></script>
    <script type="text/javascript" src="./js/bower_components/rickshaw/rickshaw.min.js"></script>
    <script type="text/javascript" src="./js/plot/Rickshaw.Series.Sliding.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://d3js.org/d3.v2.js"></script>
    <script type="text/javascript" src="./js/webcam/webcam.min.js"></script>
    
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-old-ie-min.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/grids-responsive-min.css">
    <!--<![endif]-->
    
    
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="css/layouts/blog-old-ie.css">
        <![endif]-->
        <!--[if gt IE 8]><!-->
            <link rel="stylesheet" href="css/layouts/blog.css">
        <!--<![endif]-->
        <style type="text/css">
            form { margin-top: 15px; }
            form > input { margin-right: 15px; }
            #results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
        </style>
</head>
<body onload="startTime()">

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title">Pantomath 'Bo</h1>
            <h2 class="brand-tagline">Discover Cross Model Behavior Analysis</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a class="pure-button" href="./start.php">Interview Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href="./list.php">List of Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a class="pure-button" href=>Nerd Statistics</a>
                    </li>
                    
                </ul>
            </nav>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div>
            <!-- A wrapper for all the blog posts -->
            <div class="posts">
                <h1 class="content-subhead">Pinned Board</h1>

                <!-- A single blog post -->
                <section class="post">
                    <header class="post-header">
                       
                        <script>
                            function startTime() {
                                var today = new Date();
                                var h = today.getHours();
                                var m = today.getMinutes();
                                var s = today.getSeconds();
                                m = checkTime(m);
                                s = checkTime(s);
                                document.getElementById('txt').innerHTML =
                                h + ":" + m + ":" + s;
                                var t = setTimeout(startTime, 500);
                            }
                            function checkTime(i) {
                                if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
                                return i;
                            }
                            </script>
                                
                        <h2 class="post-title">Time <div id="txt"></div></h2>

                        
                    </header>

                    <div class="post-description">
                       
                            <div class="list">
                                <ul class="quantity-list">
                                    <li class="quantity-item">
                                        Number of interviews:&nbsp;&nbsp;
                                        <h2 class="quantity-item"><?php echo $num_total[0]["num"];?></h2>
                                    </li>
                                    <li class="quantity-item">
                                        Number of interviews conducted:&nbsp;&nbsp;
                                        <h2 class="quantity-item"><?php echo $num_conducted[0]["num"];?></h2>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </section>
                <section>
                    <!-- candidate photo -->
                    <div id="results" ></div>
                    

                    <div class="graphs">
                        <ul class="graph-list">
                            <li class="graph-number">
                                    <div id="chart"><h2 style="text-align: center">Smile Score Variation</h2></div>
                            </li>
                        </ul>
                    </div>
                    
                </section>

                <section class="ratings-container">
                        <?php 
                            $db->sql('SELECT * FROM pb_score_data WHERE c_id=' . $_GET['id']);
                            $res = $db->getResult();
                            $row = $res[0]; // array of paramenter including id's
                            
                            foreach ($row as $key => $value) {
                                # code...
                                if($key == 's_id' || $key == 'c_id')
                                    continue;
                                $html = '
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

                                   echo $html;
                            }
                        ?>                          
                    </section>
            </div>

                
            <div class="footer">
                <div class="pure-menu pure-menu-horizontal">
                    <ul>
                        <li class="pure-menu-item"><a href="http://purecss.io/" class="pure-menu-link">About</a></li>
                        <br/>
                        <i class="fa fa-heart heart"></i>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	var graph=null;

	// Generate a graph
	$(".graphs").hide();
	$(".ratings-container").hide();
    $(document).ready(function(){
        put_sample_photo();
    });

    function initiate(){
        graph_flood();
        $(".graphs").show();
        $(".ratings-container").show();
        fetch_data(graph);
    }

	function graph_flood(){
	        graph = new Rickshaw.Graph( {
	        element: document.getElementById("chart"),
	        width: 600,
	        height: 240,
	        renderer: 'line',
	        series: new Rickshaw.Series.Sliding([{ name: 'mySeries'}], undefined, {
	            maxDataPoints: 100,
	        })
	    } );

	    // Render the graph
	    graph.render();
	    
	 }

    console.log('about to stream');

    function fetch_data() {
		  $.ajax({
		  	type: "GET",
		    url: "./stream.php",
		    success: function(e) {
		      var obj = JSON.parse(e);
		      	console.log(obj);
		      	graph.series.addData(obj.series, obj.x);
		        graph.render();
		    }

		  });

		  setTimeout(fetch_data, 200);
		}

    var image_data_uri = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCM0Y4QzdFMEM0NEQxMUUyQUVBOUE1NTI0M0Y5MTUxNiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyQzY4OUMwQUM2MUYxMUUyQUVBOUE1NTI0M0Y5MTUxNiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkIzRjhDN0RFQzQ0RDExRTJBRUE5QTU1MjQzRjkxNTE2IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkIzRjhDN0RGQzQ0RDExRTJBRUE5QTU1MjQzRjkxNTE2Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+JwrHOQAAAwBQTFRF6puIbHJx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";

    function put_sample_photo() {
        document.getElementById('results').innerHTML = 
                '<h2>Candidate Profile:</h2>' + 
                '<img src="'+image_data_uri+'"/>';
    }
/*
//<!-- Configure a few settings and attach camera -->
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );

//<!-- Code to handle taking the snapshot and displaying it locally -->

    var img_data = "";
    var flag = false;

    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML = 
                '<h2>Here is your image:</h2>' + 
                '<img src="'+data_uri+'"/>';
                img_data=data_uri;
        } );
    }

    function photo_done(){
        var element =  document.getElementById("photo-click-widget");
        element.outerHTML="";
        var cam = document.getElementById("my_camera");
        cam.outerHTML="";
        Webcam.reset();
        flag = true;
        graph_flood();
        $(".graphs").show();
        $(".ratings-container").show();
        fetch_data(graph);
    }
*/
</script>
</body>
</html>
