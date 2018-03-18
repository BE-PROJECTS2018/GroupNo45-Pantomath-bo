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
    <meta name="description" content="New Intelligent System">
    <title>Pantomath'Bo</title>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./bower_components/rickshaw/rickshaw.css">
    <link rel="stylesheet" href="./css/mainstyle.css" >
    <link rel="stylesheet" href="./css/fontawesome.css" >
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    
    
    <!-- JS -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/plot/d3.min.js"></script>
    <script type="text/javascript" src="./js/plot/d3.layout.min.js"></script>
    <script type="text/javascript" src="./js/plot/rickshaw.min.js"></script>
    <script type="text/javascript" src="./js/plot/Rickshaw.Series.Sliding.js"></script>
    <script type="text/javascript" src="./js/plot/d3.v2.js"></script>
    
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
</head>
<body onload="startTime();">

    <div id="layout" class="pure-g">
        <div class="sidebar pure-u-1 pure-u-md-1-4">
            <div class="header">
                <h1 class="brand-title">Pantomath 'Bo</h1>
                <h2 class="brand-tagline">Discover Cross Model Behavior Analysis</h2>

                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a class="pure-button" href="index.php">Interview Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="pure-button" href="./list.php">List of Candidates</a>
                        </li>
                        <li class="nav-item">
                            <a class="pure-button" href="index.php">New Interview</a>
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
                </div>

                <?php
                                    $db->sql('SELECT * FROM pb_candidate_details WHERE c_id=' . $_GET['id']);
                                    $res = $db->getResult();
                                    $row = $res[0];
                                    $li = "";
                                    foreach ($row as $key => $value) {
                                        # code...
                                        if($key == 'c_id')
                                            $key = 'candidate ID:';
                                        if($key == 'photo')
                                            continue;

                                        if($key == 'resume')
                                            $value = "<a href=\"" . $value . "\">Link</a>";
                                        $li .= "<li class=\"candidate-item-1\">" . $key;
                                        $li .= "<h2>" . $value . "</h2></h3><br></li>";
                                    }
                ?>

                <div class="posts">
                    <h1 class="content-subhead">Statistical Analysis</h1>

                    <section class="post">
                        <header class="post-header">
                            <?php
                                echo "<img width=\"300\" height=\"300\" alt=\"Eric Ferraiuolo&#x27;s avatar\" class=\"post-avatar\" src=\"" . $row["photo"] . "\">";
                            ?>
                            <h2 class="post-title">Everything You Need to Know About "Candidate"</h2>
                            
                        </header>

                        <div class="candidate details">
                            <p>
                                <ul class="candidate-gen-info">
                                    <?php echo $li; ?>
                                </ul>
                            </p>
                        </div>
                    </section>

                    <br/>
                    <section class="graphs-container">
                    <div class="graphs">
                        <ul class="graph-list">
                            <li class="graph-number">
                                    <div id="chart"><h2 style="text-align: center">Smile Score Variation</h2></div>
                                    <script type="text/javascript">
                                        // Generate a graph
                                        var graph = new Rickshaw.Graph( {
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

                                        // Create a new EventSource
                                        var evtSrc = new EventSource("./stream.php");

                                        // Handle receiving data
                                        var count = 0;
                                        evtSrc.onmessage = function(e) {
                                            var obj = JSON.parse(e.data);
                                            // New data is entered as ({seriesKey: yval, ...}, xval)
                                            graph.series.addData(obj.series, obj.x);
                                            graph.render();
                                            count += 1;
                                            console.log(obj);
                                        };
                                    </script>
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
</body>
</html>
<?php
$db->disconnect();
?>