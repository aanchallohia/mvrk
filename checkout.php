<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 $email= "";
  //it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
    $email = $_SESSION['email'];
  //exit;
 }
 
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
  } 
  else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
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
       $_SESSION['email'] = $email;
        $errTyp = "success";
    $errMSG = "Successful";
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }
    
  echo "<script>$('#mytabs a[href='#reg']').tab('show');</script>";
    
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

 if ( isset($_POST['addBtn']) ) {
  
  // clean user inputs to prevent sql injections
  $city = trim($_POST['city']);
  $city = strip_tags($city);
  $city = htmlspecialchars($city);
     
  $state = trim($_POST['state']);
  $state = strip_tags($state);
  $state = htmlspecialchars($state);

  $add1 = trim($_POST['add1']);
  $add2 = trim($_POST['add2']);
  $phone = trim($_POST['phoneNO']);
  $fullName = trim($_POST['fullName']);
     
  $id = $_SESSION['user'];
    
  // basic name validation
  if (empty($city)) {
   $error = true;
   $cityError = "Please enter city.";
  } else if (strlen($city) < 3) {
   $error = true;
   $cityError = "City must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$city)) {
   $error = true;
   $cityError = "City must contain alphabets and space.";
  }
     
  if (empty($state)) {
   $error = true;
   $stateError = "Please enter State.";
  } else if (strlen($state) < 3) {
   $error = true;
   $stateError = "State must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$state)) {
   $error = true;
   $stateError = "State must contain alphabets and space.";
  }
     
  if (empty($phone)) {
   $error = true;
   $phoneError = "Please enter Phone Number.";
  }
   if (empty($fullName)) {
   $error = true;
   $fullNameError = "Please enter Full Name.";
  }
   if (empty($add1)) {
   $error = true;
   $add1Error = "Please enter Address.";
  }
     if (empty($add2)) {
   $error = true;
   $add2Error = "Please enter Address.";
  }
  
  // if there's no error, continue to signup
  if( !$error ) {
   
   $query = "update users set city='$city',state='$state',addLine1='$add1',addLine2='$add2',phone='$phone',userName='$fullName' WHERE userId='$id';";
   $res = mysqli_query($conn,$query);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successful";
//    unset($name);
//    unset($email);
//    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>

<!DOCTYPE html>
<html lang="en" ng-app="confApp">

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
</head>
<body id="page-top" class="bod" ng-controller="checkoutController">

    <!-- Navigation -->
   <div id="nav">
    </div>
<!--    Nav bar end-->
    
    <div class="container">
        <div class="row">
            <p style="margin-top:100px"></p>
            <div class="col-xs-8 col-sm-8">
                <p><h3>Your Cart</h3></p>
            </div>
            <div class="hidden-lg hidden-md col-sm-4 col-xs-4">
                <div>
                <p><h5>Total Price</h5></p>
                <p class="margin-top:100px"><h4>&#8377; {{totalprice}}</h4></p>
                </div>
            </div>   
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs" id="mytabs">
                    <li id="cartTab" class="active"><a data-toggle="tab" href="#cart">Cart</a></li>
                    <li id="accTab"><a data-toggle="tab" href="#reg"> Account Credentials</a></li>
                    <li id="addTab"><a data-toggle="tab" href="#address">Address</a></li>
                    <li id="payTab"><a data-toggle="tab" href="#payment">Payment</a></li>
                  </ul>
                <div class="tab-content">
                    <div id="cart" class="tab-pane fade in active">
                    <div class="row">
                            <p style="margin-top:10px"></p>
                            <div class="col-md-2 hidden-xs">
                                
                            </div>
                            <div class="col-md-5 hidden-xs">
                                <p>Name</p>
                            </div>
                            <div class="col-md-2 hidden-xs">
                              <p>Price</p>
                            </div>
                        </div>
                    <div ng-repeat="product in cart">
                        <div class="cart-el">
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-xs-6">
                                <img src={{product.imageURL}} alt="cart Product" width="100px" height="100px"> 
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-6">
                                <p><h3>{{product.name}}</h3></p>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6">
                              <p><h4>&#8377; {{product.price}}</h4></p>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6">
                                <a class="btn btn-danger" role="button" ng-click="remove(product)">Remove</a>
                            </div>
                        </div>
                    </div>
                        </div>
                    <a href="#" id="proceed" class="btn btn-success pull-right" role="button">Next</a>
                    </div>
                    <div id="reg" class="tab-pane fade">
                        <div class="row">
                        <p style="margin-top:10px;margin-left:15px;"></p>
                             <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form"><?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-success">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>                       
                            <div class="col-md-5">
                            <div class="form-group">
	                       <label for="form-email">Email</label>
	                       <input type="email" name="email" placeholder="Email..." class="form-username form-control" value="<?php echo $email; ?>" maxlength="40" >
                                <span class="text-danger"><?php echo $emailError; ?></span>
	                  </div>
                            <div class="form-group">
	                       <label for="form-password">Password</label>
	                       <input type="password" name="pass" placeholder="Password..." class="form-password form-control" maxlength="15">
                            <span class="text-danger"><?php echo $passError; ?></span>
	                  </div>
                            <a href="">Create a New Account</a>
                            </div>
                      </div>
                            <button type="submit" class="btn btn-info" name="loginBtn">Submit</button>
                            <a href="#" id="proceed1" class="btn btn-success pull-right" role="button">Next</a>
                     </form>
                        </div>
                    <div id="address" class="tab-pane fade">
                      <div class="row">
                        <p style="margin-top:10px;margin-left:15px;"></p>
                          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form"><?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-success">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
                            <div class="col-md-6">
                            <div class="form-group">
	                       <label for="form-name">Full Name</label>
	                       <input type="text" name="fullName" placeholder="Name" class="form-username form-control" id="form-username">
                                <span class="text-danger"><?php echo $fullNameError; ?></span>
	                       </div>
                            <div class="form-group">
	                       <label for="form-addline1">Address Line 1</label>
	                       <input type="text" name="add1" placeholder="Street Address" class="form-text form-control" id="form-addline1">
                                <span class="text-danger"><?php echo $add1Error; ?></span>
	                       </div>
                            <div class="form-group">
                            <label for="form-addline2">Address Line 2</label>
	                       <input type="text" name="add2" placeholder="Apartment, Building, Floor" class="form-text form-control" id="form-addline2">
                                <span class="text-danger"><?php echo $add2Error; ?></span>
                            </div>
                          </div>
                            <div class="col-md-6"> 
                            <div class="form-group">
                            <label for="form-city">City</label>
                                
	                       <input type="text" name="city" placeholder="City" class="form-text form-control" value="<?php echo $city; ?>" maxlength="15">
                                <span class="text-danger"><?php echo $cityError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="form-state">State</label>
	                       <input type="text" name="state" placeholder="State" class="form-text form-control">
                                <span class="text-danger"><?php echo $stateError; ?></span>
                            </div>
                            <div class="form-group">
                            <label for="form-state">Phone Number</label>
	                       <input type="tel" name="phoneNO" placeholder="Phone" class="form-text form-control" id="form-phone" maxlength="11">
                                <span class="text-danger"><?php echo $phoneError; ?></span>
                            </div>
                            </div>
                      </div>
                         <button type="submit" class="btn btn-info" name="addBtn">Submit</button> 
                        <a href="#" id="proceed2" class="btn btn-success pull-right" role="button">Next</a>
                          </form>
	               </div>
                    <div id="payment" class="tab-pane fade">
                      <div class="row">
                        <p style="margin-top:10px;margin-left:15px;"></p>
                          <p>Payment Method</p>  
                      </div>
                        <a href="#" id="proceed2" class="btn btn-success pull-right" role="button">Next</a>
                </div>         
                </div>
            </div>
             <div class="col-md-3 hidden-xs hidden-sm">
                <div class="totalpricebox">
                <p><h3>Total Price</h3></p>
                <p><h4>&#8377; {{totalprice}}</h4></p>
                </div>
            </div>       
        </div>
    </div>   
<!-- end Left to right-->
  <div id="footer">
</div>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
     <script src="js/bootstrap.min.js"></script>
    <script src="js/common.js"></script>
     <script src="js/angular.min.js"></script>
    

<script src="js/checkout.js"></script>
</body>

</html>
