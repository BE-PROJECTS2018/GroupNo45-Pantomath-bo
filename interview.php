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
        <style type="text/css">
            form { margin-top: 15px; }
            form > input { margin-right: 15px; }
            #chart-smile{}
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
                                        Number of Cadidates:&nbsp;&nbsp;
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
                    <div id="results" >
                        <?php 
                            $db->sql('SELECT photo FROM pb_candidate_details WHERE c_id=' . $_GET['id']);
                            $res = $db->getResult();

                            $html = '<h2>Candidate Profile:</h2>' . 
                                    '<img src="' . $res[0]["photo"] . '"/>';
                            echo $html;
                        ?>
                    </div>
                    
                    <!-- Interview Controls-->
                    <div>
                        <button id="start" >start Interview</button>
                        <button id="stop">stop Interview</button>
                        <div id="log">Here your log comes</div>
                    </div>

                    <div class="graphs">
                        <ul class="graph-list">
                            <li class="graph-number">
                                    <div id="chart-smile">
                                    <h2 style="text-align: center">Smile Score Variation</h2>
                                    </div>
                            </li>
                        </ul>
                    </div>
                    
                </section>

                <section class="ratings-container" id="final_Score">                       
                </section>
            </div>

            <!--
            <div class="footer">
                <div class="pure-menu pure-menu-horizontal">
                    <ul>
                        <li class="pure-menu-item"><a href="http://purecss.io/" class="pure-menu-link">About</a></li>
                        <br/>
                        <i class="fa fa-heart heart"></i>
                    </ul>
                </div>
            </div>
                        -->
        </div>
    </div>
</div>

<script>
	var graph=null;
    var stop=false;
    var started=false;
	// Generate a graph
	
    $(document).ready(function(){
        $(".graphs").hide();

        $("#start").click(function(){
            if(!started){
                started=true;
                
                $.get("./backend/driver.php",{"id":1},function(data) {
                    $("#log").append("<br><p>" + data + "</p>");
                    initiate();
                });
                
                initiate();
            }
            else{
                alert("Backend is starting soon...");
            }
        });

        $("#stop").click(function(){
            $.get("./backend/driver.php",{"id":2},function(data) {
                
                stop = true;
                
                $("#log").append("<br><p>" + data + "</p>");
                $(".graphs").hide();
                $(".ratings-container").show();

                $.get("./getFeatures.php",{"id":<?php echo $_GET["id"] ?>},function(data) {
                    $("#log").append("<br><p>" + data + "</p>");
                        var obj = data;
                        console.log(obj);
                        $("#final_score").html(data);
                });
            });
        });
    });

    function initiate(){
        console.log("setting up graph and flooding data");
        graph_flood();

        console.log("displaying graphs");
        $(".graphs").show();
        
        console.log("hiding rating container");
        $(".ratings-container").hide();

        console.log("creating new connection");
        fetch_data();
    }

	function graph_flood(){
            console.log("graph instance created");

	        graph = new Rickshaw.Graph( {
	        element: document.getElementById("chart-smile"),
	        width: 600,
	        height: 240,
	        renderer: 'line',
	        series: new Rickshaw.Series.Sliding([{ name: 'smile'}], undefined, {
	            maxDataPoints: 100,
	        })
	    } );

        console.log("graph:"+graph);
	    // Render the graph

        console.log("rendering started");

	    graph.render();
	    
        console.log("Graph setup complete");
	 }

    function fetch_data() {
        console.log("Data fetch started");
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
          console.log("added to graph");

          if(stop != true)
		    {
                setTimeout(fetch_data, 200);
            }else{
                console.log("User stopped");
            }
        }
</script>
</body>
</html>
