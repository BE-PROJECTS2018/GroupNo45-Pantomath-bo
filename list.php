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
    <link rel="stylesheet" type="text/css" href="./css/card/card-style.css">

    <!-- js -->
    <script type="text/javascript" src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/candidate/candidate-list.js"></script>
    
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
<body onload="startTime()">







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
                        <a class="pure-button" href="#">List of Candidates</a>
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
                <section id="candidate-list">
                    <!--
                    <div class="mdl-card mdl-shadow--2dp mdl-card--horizontal">
                      <div class="mdl-card__media">
                        <img src="./img/common/reid-avatar.png" alt="img">
                      </div>
                        <div class="mdl-card__title">
                          <h2 class="mdl-card__title-text">Michael Jordon</h2>
                        </div>
                        <div class="mdl-card__supporting-text">
                            <ul class="qualification">
                                <li>Degree : B.Tech</li>
                                <li>Experience: 2 yr</li>
                            </ul>
                        </div>
                        <div class="mdl-card__actions mdl-card--border">
                          <a href="#" class="more-info">More info</a>
                        </div>
                        <div class="mdl-card__menu">
                          <h2>#1</h2>
                        </div>
                    </div>
                -->
                </section>
            </div>
        </div>
    </div>
</div>




</body>
</html>
