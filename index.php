<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
// if ( isset($_SESSION['user'])!="" ) {
//  header("Location: index.php");
//  exit;
// }
 
 $error = false;
 
 if( isset($_POST['loginBtn']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  // if there's no error, continue to login
  if (!$error) {
   
   $password = hash('sha256', $pass); // password hashing using SHA256
  
   $res=mysqli_query($conn,"SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   
   if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    //header("Location: index.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }
    
  }
  
 }

 if ( isset($_POST['signUpBtn']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name must contain alphabets and space.";
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
   $result = mysqli_query($conn,$query);
   $count = mysqli_num_rows($result);
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
   $res = mysqli_query($conn,$query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now";
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MVRKtech</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="shortcut icon" href="img/mvrk.ico">
    <link rel="stylesheet" href="css/animate.min.css">
</head>
<body id="page-top" class="bod">
    <!-- Navigation -->
    <div id="nav">
    </div>
    <header>
        <div class="header-bg">
            <p style="margin-top:100px;"></p>
<!--            <img alt="header" src="img/headerimage.png" class="img-responsive">-->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                      <li data-target="#myCarousel" data-slide-to="1"></li>
                      <li data-target="#myCarousel" data-slide-to="2"></li>
                      <li data-target="#myCarousel" data-slide-to="3"></li>
                      <li data-target="#myCarousel" data-slide-to="4"></li>
                      <li data-target="#myCarousel" data-slide-to="5"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        
                      <div class="item active">
                        <img src="img/elixir%20x.png" alt="ElexirX">
                      </div>

                      <div class="item">
                        <img src="img/elixir%20y.png" alt="ElexirY">
                      </div>

                      <div class="item">
                        <img src="img/nemesis%20x%20.png" alt="NemesisX" class="img-fluid">
                        </div>
                        <div class="item">
                        <img src="img/nemesis%20y%20.png" alt="NemesisY" class="img-fluid">
                        </div>
                        <div class="item">
                        <img src="img/shaftx780t.png" alt="ShaftX" class="img-fluid">
                        </div>
                        <div class="item">
                        <img src="img/shaftY780t.png" alt="ShaftY" class="img-fluid">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                      <i class="fa fa-angle-left" aria-hidden="true" style="margin-top:250px"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                      <i class="fa fa-angle-right" aria-hidden="true" style="margin-top:250px"></i>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
        </div>
    </header>
<!--
    <section>
        <div class="container" id="viedos">
            <div class="row">
                <div class="col-md-6">
                    <p class="margin"></p>
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/l8NyHzJEaCE" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="margin"></p>
                    <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/DPw0EdzLtHs" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
-->
    <section>
        <div class="container" id="configs">
            <div class="row">
                <div class="col-md-6">
                    <div id="intel" class="type">
                    <h3><b>X Series<br><h4>Intel Configurations</h4></b></h3>
                    <a href="intelconf.html"><img alt="Intel" src="img/intel.png" class="img-responsive"></a>
                    </div>
                </div>
                <div id="amd" class="col-md-6">
                    <div class="type">
                    <h3><b>V Series<br><h4>AMD Configurations</h4></b></h3>
                    <a href="amdconf.html"><img alt="Intel" src="img/amd.png" class="img-responsive"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="text-align:center;font-size:40px;"></h2>
                    <p style="margin-bottom:60px;"></p>
                </div>
                <div class="col-lg-5 div-img">
                    <img id="img1" src="img/unlockpower.png" class="img-responsive">
                </div>
                <div class="col-lg-7 feat">
                    <p style="margin-top:60px;"></p>
                    <h2>A NEW BENCHMARK IN GAMING</h2>
                    <p>Powered by the technology demanded by Enthusiasts, our rigs are specced to the best possible standard for a perfectly seamless experience</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p style="margin-bottom:30px;"></p>
                </div>
                <div class="col-lg-7 feat">
                    <p style="margin-top:120px;"></p>
                    <h2>FEEL THE POWER OF DDR4</h2>
                    <p>The latest DDR4 memory provides you with faster performance and High Frequencies of operation.</p>
                </div>
                <div class="col-lg-5 div-img">
                    <img id="img2" src="img/LPX-DDR4-BLU.png" class="img-responsive">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="text-align:center;font-size:40px;"></h2>
                    <p style="margin-bottom:60px;"></p>
                </div>
                <div class="col-lg-5 div-img">
                    <img id="img3" src="img/H115i_02.png" class="img-responsive">
                </div>
                <div class="col-lg-7 feat">
                    <p style="margin-top:30px;"></p>
                    <h2>ZERO MAINTAINANCE LIQUID COOLING</h2>
                    <p>Best in class liquid cooling to keep your SHAFTx cool under pressure.</p>
                </div>
            </div>
        </div>
    </section>
     <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
        	<div class="modal-dialog">
        		<div class="modal-content">
        			
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">
        					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        				</button>
        				<h3 class="modal-title" id="modal-login-label">Login to MVRK</h3>
        				<p>Enter your username and password to log on:</p>
        			</div>
        			
        			<div class="modal-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form"><?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
	                    	<div class="form-group">
	                    		<label for="form-username">Email</label>
	                        	<input type="email" name="email" placeholder="Email..." class="form-username form-control" value="<?php echo $email; ?>" maxlength="40" >
                                <span class="text-danger"><?php echo $emailError; ?></span>
	                        </div>
	                        <div class="form-group">
                                
	                        	<label for="form-password">Password</label>
	                        	<input type="password" name="pass" placeholder="Password..." class="form-password form-control" maxlength="15">
                                <span class="text-danger"><?php echo $passError; ?></span>
	                        </div>
	                        <button type="submit" class="btn-modal" name="loginBtn">Log in</button>
                            
                        </form>
	                    <p class='create'><a href="#" id="create">Create an account</a></p>
        			</div>
        			
        		</div>
        	</div>
        </div>
    <div class="modal fade" id="register-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
        	<div class="modal-dialog">
        		<div class="modal-content">
        			
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">
        					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        				</button>
        				<h3 class="modal-title" id="modal-login-label">Register at MVRK</h3>
        			</div>
        			
        			<div class="modal-body">
        				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form">
                             <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
	                    	<div class="form-group">
	                    		<label for="form-username">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" class="form-username form-control"/>
	                        	<span class="text-danger"><?php echo $nameError; ?></span>
	                        </div>
                            <div class="form-group">
	                    		<label for="form-email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" class="form-username form-control" />
	                        	<span class="text-danger"><?php echo $emailError; ?></span>
	                        </div>
	                        <div class="form-group">
	                        	<label for="form-password">Password</label>
                                <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" lass="form-password form-control"/>
	                        	<span class="text-danger"><?php echo $passError; ?></span>
	                        </div>
	                        <button type="submit" class="btn-modal" name="signUpBtn">Register</button> 
                            <p class='create'><a href="#" id="reg">Login</a></p>
                        </form>
        			</div>
        			
        		</div>
        	</div>
        </div>
<!--
    <section id="partners">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="text-align:center;font-size:40px;"><b>PARTNERS</b></h2>
                    <p style="margin-bottom:30px;"></p>
                </div>
                <div class="col-lg-2">
                    <img src="img/msi-gaming_logo-vertical-color-b-212x300.png" width="200px" height="200px">
                </div>
                <div class="col-lg-2">
                    <img src="img/Asus-popular-for-gaming-laptop-300x96.png" width="200px" height="200px">
                </div>
                <div class="col-lg-2">
                    <img src="img/cm-logo-200x200.jpg" width="200px" height="200px">
                </div>
            </div>
        </div>
    </section>
-->
<!-- end Left to right-->
    <div class="container" id="why">
        <div class="row why">
            <h2>WHY MVRK</h2>
            <hr>
            <p>A true PC must be focused on Performance, Service and Customization. This is MVRK’s forte.
One of the first Boutique Computer and Peripheral providers here in India, MVRK is determined to serve the best to their valued customers.
</br>

Every system is Rigorously Tested and hand crafted for Superior Performance and Quality, built to last longer. They are not just randomly picked parts, but hours of research and hard work, providing the finest intricately built custom computer solutions in the industry by using the latest technology and supporting it with an optimum level of service to ensure customer satisfaction.</br>

Experience unmatched PC Gaming and Workstation experience. Unrivalled performance that’s better than any console. MVRK PCs are capable of running graphics-intensive games and applications without a hitch. Whether it’s 4K Gaming, Virtual Reality or 3D Modelling, our line of computers are designed for tomorrow’s technology. </br>

We are committed to provide best prices for all customer needs. MVRK is determined to raise its bar with every new offering in the years to come.</br>


<b>Choice of True Enthusiasts. </b> </br> </hr>

</p>
        </div>
    </div>
<div id="footer">
</div>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/common.js"></script> 
<script src="js/modal.js"></script>
<div id="fb-root"></div>

<script>   
$( document ).ready(function() {
        $( "#configs" ).mouseover(function() {
            $("#intel").addClass("animated bounceInLeft");
            $("#amd").addClass("animated bounceInRight");
    });
    $( ".feat" ).mouseover(function() {
            $("h2").addClass("animated rotateInDownLeft");
            $("#img1").addClass("animated slideInLeft");
            $("#img2").addClass("animated slideInRight");
            $("#img3").addClass("animated slideInLeft");
    });
    $( ".why" ).mouseover(function() {
        $("h2").addClass("animated rotateInDownLeft");
        $("p").addClass("animated slideInUp");
    });
    $( "#login" ).click(function() {
  alert( "Handler for .click() called." );
});
});
</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
<?php ob_end_flush(); ?>