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
    <link rel="stylesheet" href="./css/registration/registration.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
</head>
<body>



<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <h1 class="brand-title">Pantomath 'Bo</h1>
            <h2 class="brand-tagline">Discover Cross Model Behavior Analysis</h2>
            <hr>
            <h3>New Generation Intelligent System</h3>
            <br>
            <p class="copyright">Designed by <a href="#" target="_blank" title="Colorlib">Pantomath Team</a></p>
                
            </nav>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div>
            
            <!-- A wrapper for all the blog posts -->
            <div class="posts">
                <h1 class="content-subhead">Welcome to Online Interview</h1>

                <section>
                    <div class="container" id="register">  
                        <form id="contact" action="./register.php" method="post" enctype="multipart/form-data">
                          <h3>Candidate Registration</h3>
                          <h4 style="float:right">One Step toward success ...</h4>
                          
                          <fieldset>
                                <div id="results">Your captured image will appear here...</div>
                                <div id="my_camera"></div>
                                <div id="cam_btn">
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    <input type="button" value="Done" onClick="photo_done()">
                                </div>
                          </fieldset>

                          <fieldset>
                            <input name="fname" placeholder="First Name" type="text" tabindex="1" required autofocus>
                          </fieldset>
                          
                          <fieldset>
                            <input name="lname" placeholder="Last Name" type="text" tabindex="2" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name ="age" placeholder="Age" type="Number" tabindex="3" required min=18 autofocus>
                          </fieldset>

                          
                          <fieldset>
                            <input name="college" placeholder="College" type="text" tabindex="4" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name="degree" placeholder="Degree" type="text" tabindex="5" required autofocus>
                          </fieldset>
                          <fieldset>
                                <input name="stream" placeholder="Stream" type="text" tabindex="5" required autofocus>
                          </fieldset>

                          <fieldset>
                                <input name="experience" placeholder="Experience(years)" type="number" tabindex="5" required autofocus>
                          </fieldset>

                          <fieldset>
                            <input name="email" placeholder="Email Address" type="email" tabindex="6" required>
                          </fieldset>
                          
                          <fieldset>
                            <input name="phone" placeholder="Phone Number" type="tel" tabindex="7" required autofocus="">
                          </fieldset>

                          <fieldset>
                                <button style="display:block;width:120px; height:30px;" onclick="document.getElementById('getFile').click()">Upload Resume</button>
                                <input name="file" type="file" id="getFile" style="display:none;padding:2px;" accept=".pdf" tabindex="5" required autofocus>
                            </fieldset>

                          <input type="hidden" name="image_data" value="" id="image_data"/>
                                                 
                          <fieldset>
                            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                          </fieldset>

                          <h6>Already Registered <a href="#" id="login-trigger">Login</a></h6>
                        </form>
                    
                      </div>

                      <div class="container" id ="login">  
                            <form id="contact" action="./login.php" method="post">
                              <h3>Candidate Login</h3>
                              <h4 style="float:right">One Step toward success ...</h4>
                              
                              
                              <fieldset>
                                <input name="email" placeholder="Email Address" type="email" tabindex="6" required>
                              </fieldset>
                                                     
                              <fieldset>
                                <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
                              </fieldset>
    
                              <h6>New Candidate <a href="#" id = "register-trigger">Register</a></h6>
                            </form>
                          </div>
                          <script>
                              var click=0;
                              $(document).ready(function(){
                                    $("#register").hide();
                                    $("#register-photo").hide();

                                    $("#login-trigger").click(function(){
                                        $("#register").hide();
                                        $("#register-photo").hide();
                                        $("#login").show();

                                        Webcam.reset();
                                    });

                                    $("#register-trigger").click(function(){
                                        $("#login").hide();
                                        $("#register").show();
                                        $("#register-photo").show();
                                        //<!-- Configure a few settings and attach camera -->
                                        Webcam.set({
                                            width: 320,
                                            height: 240,
                                            image_format: 'jpeg',
                                            jpeg_quality: 90
                                        });
                                        Webcam.attach( '#my_camera' );
                                    });
                                });
                          
                            //<!-- Code to handle taking the snapshot and displaying it locally -->
    
                                var img_data = "";
    
                                function take_snapshot() {
                                    click++;
                                    // take snapshot and get image data
                                    Webcam.snap( function(data_uri) {
                                        // display results in page
                                        document.getElementById('results').innerHTML = 
                                            '<h6>Here is your image:</h6>' + 
                                            '<img src="'+data_uri+'"/>';
                                            img_data=data_uri;
                                    } );
                                }
    
                                function photo_done(){
                                    if(click>0){
                                        $("#my_camera").remove();
                                        $("#cam_btn").remove();

                                        document.getElementById('results').innerHTML = 
                                                '<img src="'+img_data+'"/>';
                                        Webcam.reset();
                                        $("#image_data").val(""+img_data);
                                    }else{
                                        alert("Please Capture Image");
                                    }
                                }
                            </script>
                </section>
            </div>
        </div>
    </div>
</div>




</body>
</html>
