<?php
ob_start();
session_start(); // start a new session or continues the previous
if( isset($_SESSION['user'])!="" ){
 header("Location: home.php"); // redirects to home.php
}
include_once 'dbconnect.php';
$error = false;
if ( isset($_POST['btn-signup']) ) {
 
 // sanitize user input to prevent sql injection
 $name = trim($_POST['name']);

  //trim - strips whitespace (or other characters) from the beginning and end of a string
  $name = strip_tags($name);

  // strip_tags — strips HTML and PHP tags from a string

  $name = htmlspecialchars($name);
 // htmlspecialchars converts special characters to HTML entities
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
  $nameError = "Name must have at least 3 characters.";
 } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
  $error = true;
  $nameError = "Name must contain alphabets and space.";
 }

 //basic email validation
 if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
  $error = true;
  $emailError = "Please enter valid email address.";
 } else {
  // checks whether the email exists or not
  $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
  $result = mysqli_query($conn, $query);
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

 // password hashing for security
$password = hash('sha256', $pass);


 // if there's no error, continue to signup
 if( !$error ) {
  
  $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
  $res = mysqli_query($conn, $query);
  
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
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <style>
    #form {
      display: flex;
      flex-direction: column;
      width: 35%;
      margin: 0 auto;

    }

    h1 {
      text-align: center;
    }
    
  </style>
</head>
<body>
  <h1>Register</h1>
  <?php
   if ( isset($errMSG) ) {
  
   ?>
           <div class="alert alert-<?php echo $errTyp ?>">
                        <?php echo $errMSG; ?>
       </div>

<?php
  }
  ?>
<form id="form" method="POST" accept-charset="utf-8">
  <input type="text" id="username" name="name" placeholder="Insert Username" value="">
  <span class="text-danger"><?php echo $nameError; ?></span>
  <input type="email" id="email" name="email" placeholder="Insert E-Mail">
  <span class="text-danger"><?php echo $emailError; ?></span>
  <input type="password" id="password" name="pass" placeholder="Insert Password">
  <span class="text-danger"><?php echo $passError; ?></span>
  <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
 
  <a href="index.php">Sign In Here...</a>
</form>
</body>
</html>

