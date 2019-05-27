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


<!DOCTYPE html>
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
    <link href="css/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="shortcut icon" href="img/mvrk.ico">
</head>
<body id="page-top" class="bod">
    <!-- Navigation -->
     <div id="nav">
    </div>
    
    <div class="container">
        <div class="row">
             <p style="margin-top:120px"></p>
             <h1>Post Your Query</h1>
        </div>
        <div class="row">
            <p style="margin-top:10px;margin-left:15px;"></p>
                <form method="post" action="" class="login-form">
                            <div class="col-md-6">
                            <div class="form-group">
	                       <label for="form-name">First Name</label>
	                       <input type="text" name="fullName" placeholder="First Name" class="form-username form-control" id="form-username">
                                <span class="text-danger"><?php echo $firstNameError; ?></span>
	                       </div>
                            <div class="form-group">
	                    		<label for="form-email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" class="form-username form-control" />
	                        	<span class="text-danger"><?php echo $emailError; ?></span>
	                        </div>
                            <div class="form-group">
                            <label for="form-state">Phone Number</label>
	                       <input type="tel" name="phoneNO" placeholder="Phone" class="form-text form-control" id="form-phone" maxlength="11">
                                <span class="text-danger"><?php echo $phoneError; ?></span>
                            </div>
                            </div>
                            <div class="col-md-6"> 
                            <div class="form-group">
                            <label for="form-lastname">Last Name</label>
                                
	                       <input type="text" name="lastname" placeholder="Last Name" class="form-text form-control" value="<?php echo $city; ?>" maxlength="15">
                                <span class="text-danger"><?php echo $lastnameError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="form-order">Order No.</label>
	                       <input type="text" name="state" placeholder="Order #" class="form-text form-control">
                            </div>
                            <div class="form-group">
                            <label for="form-supportType">Support</label><br>
	                       <select>
                              <option value="">A</option>
                              <option value="">B</option>
                              <option value="">C</option>
                              <option value="">D</option>
                            </select>
                            </div>
                            </div>
                            <div class="row quer">
                                <div class="col-md-8">
                                    <div class="form-group">
                                    <label for="form-query">Query</label><br>
                                     <textarea rows="8" cols="80" class="form-control"></textarea>   
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info" name="submitQuery">Submit</button>
            </form>
        </div>
                         
    </div>
    </div>




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

<!-- end Left to right-->
    
 <div id="footer">
</div>
</body>    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/common.js"></script>
<script src="js/modal.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


</html>
<?php ob_end_flush(); ?>