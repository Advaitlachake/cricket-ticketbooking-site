<?php 

// Initialize the session 
session_start(); 

 

// Check if the user is already login
 if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ 

header("location: welcomepage.php"); exit; 

} 

require_once "connectfile.php"; 

//initialize with empty values 

$email = $dob = $newpass = ""; 

$email_err = $dob_err = $newpass_err = ""; 



// Processing form data 
if($_SERVER["REQUEST_METHOD"] == "POST"){ 

    if(empty(trim($_POST["email"]))){ 

        $email_err = "Please enter email."; 
        
        } else{ 
        
        $email = trim($_POST["email"]); 
        
        } 

        if(empty(trim($_POST["dob"]))){ 

            $dob_err = "Please enter Date of Birth."; 
            
            } else{ 
            
            $dob = trim($_POST["dob"]); 
            
            } 
 
    
    $check_email = mysqli_query($conn, "SELECT `Email` FROM `stadium` WHERE `email` = '".$_POST['email']."'") or exit(mysqli_error($conn));
    if(! mysqli_num_rows($check_email)) {
        $email_err = 'This email does not exist. Go to Signup Page';
    }
    else{
        $sql = "SELECT dob FROM stadium WHERE `email` = '".$_POST['email']."'";
        $stmt = mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($stmt);
        $correct_dob=$row['dob'];

    if( trim($correct_dob) != trim($dob)) {
        $dob_err = 'Incorrect Date Of Birth';
    }
    }
    

// Validate password
if(empty(trim($_POST["newpass"]))){
    $newpass_err = "Please enter a password.";     
} elseif(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,}$/',trim($_POST["newpass"]))){
    $newpass_err = "Minimum eight characters, at least one uppercase letter, one number and one special character.";
} else{
    $newpass = trim($_POST["newpass"]);
}

if(empty($email_err) && empty($dob_err) && empty($newpass_err)){
    $sql1 = "UPDATE stadium SET password = ? WHERE email = ?";

    if($stmt = mysqli_prepare($conn,$sql1)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_pass, $param_email);
        // Set parameters
        $param_pass = $newpass;
        $param_email = $email;
        if(mysqli_stmt_execute($stmt)){
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);

        echo '<div style="font-size:2em;color:red">Password Change Successfully </div>';
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

<title>Reset Password</title> 

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
            background-image: url("mcg.jpg");
            background-repeat: no-repeat;
             background-size: 1600px,900px;
        }
        }

</style> 

</head> 

<body> 

<div class="wrapper"> 

<h2>Reset Password</h2> 

<p>Please fill in the following to reset the Password</p> 

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>"> 

<label style="color:black;background-color: #FFFFFF;">Email ID</label> 

<input type="text" name="email" class="form-control" value="<?php echo $email; ?>"> 

<span class="help-block"><?php echo $email_err; ?></span> 

</div> 

<div class="form-group <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>"> 

<label style="color:black;background-color: #FFFFFF;" >Date Of Birth</label> 

<input type="date" name="dob" class="form-control"> 

<span class="help-block"><?php echo $dob_err; ?></span> 

</div>

<div class="form-group <?php echo (!empty($newpass_err)) ? 'has-error' : ''; ?>"> 

<label style="color:black;background-color: #FFFFFF;">New Password</label> 

<input type="password" name="newpass" class="form-control"> 

<span class="help-block"><?php echo $newpass_err; ?></span> 

</div>

<div class="form-group"> 

<input type="submit" class="btn btn-primary" value="Change Password"> 

</div> 


<p style="color:white">Know the password? <a style="color:red;" href="loginpage.php">Login</a>.</p> 

<p style="color:white">New to the Page? <a style="color:red;" href="registerpage.php">Sign UP</a>.</p> 

</form> 



</div> 
<p style="font-size: 30px; font-style: italic;color:white; background-color: black; text-align: center; width: 500px;margin-left: 550px; margin-top: -330px; padding-top: 30px; padding-bottom: 30px;"><b>DID YOU KNOW?</b><br> 78 out of every 100 people forget their password!</p>

</body> 

</html>