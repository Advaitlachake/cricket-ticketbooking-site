<?php 

// Initialize the session 
session_start(); 

 

// Check if the user is already login
 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ 

header("location: welcomepage.php"); exit; 

} 

require_once "connectfile.php"; 

//initialize with empty values 

$username = $password = ""; 

$username_err = $password_err = ""; 

 

// Processing form data 
if($_SERVER["REQUEST_METHOD"] == "POST"){ 

if(empty(trim($_POST["username"]))){ 

$username_err = "Please enter username."; 

} else{ 

$username = trim($_POST["username"]); 

} 

if(empty(trim($_POST["password"]))){ 

$password_err = "Please enter your password."; 

} else{ 

$password = trim($_POST["password"]); 

} 

// Validate credentials 

if(empty($username_err) && empty($password_err)){ 

//select statement 

$sql = "SELECT username, password FROM stadium WHERE username = ?"; 

if($stmt = mysqli_prepare($conn, $sql)){ 

// Bind variables to the prepared statement as parameters
 mysqli_stmt_bind_param($stmt, "s", $param_username); 

// Set parameters 

$param_username = $username; 

 

// Attempt to execute the prepared statement
 if(mysqli_stmt_execute($stmt)){ 

// Store result 
 	mysqli_stmt_store_result($stmt); 

 

// Check if username exists
 if(mysqli_stmt_num_rows($stmt) == 1){ 

// Bind result variables
 mysqli_stmt_bind_result($stmt, $username, $password1); if(mysqli_stmt_fetch($stmt)){ 

if($password==$password1){ 

// Password correct start a new session
 session_start(); 

//session variables 

$_SESSION["loggedin"] = true; 

$_SESSION["username"] = $username; 

//welcome page 

header("location: welcomepage.php"); 

} else{ 

$password_err = "The password you entered was not valid."; 

} 

} 

} else{ 

$username_err = "No account found with that username."; 

} 

} else{ 

echo "Oops! Something went wrong. Please try again later."; 

} 

 

// Close statement
 mysqli_stmt_close($stmt); 

} 

} 

 

// Close connection
 mysqli_close($conn); 

} 

?> 

<!DOCTYPE html> 

<html lang="en"> 

<head> 

<meta charset="UTF-8"> 

<title>Login</title> 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.css"> 

 <style type="text/css"> 

body{ font: 14px sans-serif; } 

.wrapper{ width: 350px; padding: 20px;

            font-family: "Open Sans", Sans-serif;
  text-transform: uppercase;
  font-weight: 700;
  
  letter-spacing: 0.1em;
  margin-bottom: 10px;  
  position: relative;
 } 
body{
            background-image: url("edenstadium.jpg");
            background-repeat: no-repeat;

             background-size: 1600px,900px;
        }


</style> 

</head> 

<body> 

<div class="wrapper"> 

<h2>Login</h2> 

<p style="color:white;">Please fill in your credentials to login.</p> 

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"> 

<label style="color:black;background-color: #FFFFFF;">Username</label> 

<input type="text" name="username" class="form-control" value="<?php echo $username; ?>"> 

<span class="help-block"><?php echo $username_err; ?></span> 

</div> 

<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>"> 

<label style="color:black;background-color: #FFFFFF;">Password</label> 

<input type="password" name="password" class="form-control"> 

<span class="help-block"><?php echo $password_err; ?></span> 

</div> 

<div class="form-group"> 

<input type="submit" class="btn btn-primary" value="Login"> 

</div> 

<p style="color:white;">Don't have an account? <a style="margin-left: 50px;" href="registerpage.php"><br>Sign up </a>.</p> 

</form> 
<div class="form-group">
<button class="btn btn-primary" onclick="location.href='forgotpasspage.php'">Forgot Password</button>

</div> 

</div> 
<p style="font-size: 30px; font-style: italic; background-color: #E0A62B; text-align: center; width: 500px;margin-left: 550px; margin-top: -300px; padding-top: 30px; padding-bottom: 30px;"><b>DID YOU KNOW?</b><br> Eden Gardens has a stadium capacity of 68,000.</p>

</body> 

</html>