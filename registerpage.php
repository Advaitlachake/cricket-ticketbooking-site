<?php
require_once "connectfile.php";

session_start(); 
//initialize with empty values
$username = $password = $confirm_password = $dob = $email = "";
$username_err = $password_err = $confirm_password_err = $dob_err = $email_err = "";
 
// Processing form data
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        $sql = "SELECT username FROM stadium WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            
            //execute the statement
            if(mysqli_stmt_execute($stmt)){
                //store result 
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email id.";
    } else{
        $sql = "SELECT Email FROM stadium WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            
            //execute the statement
            if(mysqli_stmt_execute($stmt)){
                //store result 
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,}$/',trim($_POST["password"]))){
        $password_err = "Minimum eight characters, at least one uppercase letter, one number and one special character.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{ 
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate date of birth
    if(empty(trim($_POST["dob"]))){
        $dob_err = "Please enter the date of birth.";     
    } else{ 
        $dob = trim($_POST["dob"]);
        if(!empty($dob_err)){
            $dob_err = "Please enter the date of birth.";
        }
    }
    
    // Check input errors
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($dob_err) && empty($email_err)){
        
        $sql = "INSERT INTO stadium (username, password, dob, Email) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_dob, $param_email);
            $param_username = $username;
            $param_password = $password;
            $param_dob = $dob;
            $param_email = $email;
            
            //execute the statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: infopage.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

    $_SESSION["loggedin"] = true;
    $_SESSION["username"] = $username;

    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
            background-image: url("wankhedestadium4.jpg");
            background-repeat: no-repeat;
             background-size: 1600px,900px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" align="center">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email ID</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                <label>Date Of Birth</label>
                <input type="date" name="dob" class="form-control" value="<?php echo $dob; ?>">
                <span class="help-block"><?php echo $dob_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label style="color:black;background-color: #FFFFFF;">Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label style="color:black;background-color: #FFFFFF;">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-primary" value="Reset">
            </div>
            <p style="color:white;">Already have an account? <a href="loginpage.php" style="color:#f54242"><br>Login here</a>.</p>
        </form>
    </div>    
    <p style="font-size: 30px; font-style: italic; background-color: #E0A62B; text-align: center; width: 500px;margin-left: 550px; margin-top: -400px; padding-top: 30px; padding-bottom: 30px;"><b>DID YOU KNOW?</b><br> Wankhede Stadium has hosted the most IPL Matches!</p>

</body>
</html>