<?php
// Initialize the session
session_start();
 
// Check if the user is logged
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginpage.php");
    exit;
}
 
require_once "connectfile.php";
// Define variables and initialize with empty values
$name=$Gender=$seat1=$seat2=$seat3=$stadium="";
$name_err=$Gender_err=$seat_err=$stadium_err="";
 
// Processing form data
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate Name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter the Name.";     
    }else{
        $name= trim($_POST["name"]);
    }
    if(empty(trim($_POST["Gender"]))){
        $Gender_err = "Please enter the Gender.";     
    }else{
        $Gender= trim($_POST["Gender"]);
    }
    if(empty(trim($_POST["stadium"]))){
        $stadium_err = "Please enter the Stadium.";     
    }else{
        $stadium= trim($_POST["stadium"]);
    }
    if(empty(trim($_POST["seat1"]))){
        $seat_err = "Please enter the Seat no.";     
    }else{
        $seat1= trim($_POST["seat1"]);
    }


    $seat2= trim($_POST["seat2"]);
    $seat3= trim($_POST["seat3"]);

    if(($_POST["seat1"]) == ($_POST["seat2"])){
        $seat2= trim("");
    }
    
    if(($_POST["seat1"]) == ($_POST["seat3"])){
        $seat3= trim("");
    }
    if(($_POST["seat2"]) == ($_POST["seat3"])){
        $seat3= trim("");
    }

    if(($_POST["seat2"]) == "NOT SELECTED"){
        $seat2= trim("");
    }
    if(($_POST["seat3"]) == "NOT SELECTED"){
        $seat3= trim("");
    }
    


        
    // Check input errors 
    if(empty($name_err) && empty($Gender_err) && empty($seat_err) && empty($stadium_err)){
        // Prepare an update statement
        $sql1 = "UPDATE stadium SET Name = ? WHERE username = ?";
        $sql3 = "UPDATE stadium SET Gender = ? WHERE username = ?";
        $sql4 = "UPDATE stadium SET seatno = ? WHERE username = ?";
        $sql5 = "UPDATE stadium SET stadiumname = ? WHERE username = ?";

        if($stmt = mysqli_prepare($conn,$sql1)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_usr);
            echo"Quit";
            // Set parameters
            $param_name = strtoupper($name);
            $param_usr = $_SESSION["username"];
            if(mysqli_stmt_execute($stmt)){
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
            
        }
        
        if($stmt = mysqli_prepare($conn,$sql3)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_Gender, $param_usr);
            
            // Set parameters
            $param_Gender = $Gender;
            $param_usr = $_SESSION["username"];
            if(mysqli_stmt_execute($stmt)){
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
            
        }
        if($stmt = mysqli_prepare($conn,$sql5)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_stadium, $param_usr);
            
            // Set parameters
            $param_stadium = $stadium;
            $param_usr = $_SESSION["username"];
            if(mysqli_stmt_execute($stmt)){
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
            
        }
        if($stmt = mysqli_prepare($conn,$sql4)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_seat, $param_usr);
            
            // Set parameters
            if($seat1 == "" and $seat2 == "" and $seat3 == ""){
                $s = "";
            }
            if($seat1 == "" and $seat2 == "" and $seat3 != ""){
                $s = $seat3;
            }
            if($seat1 == "" and $seat2 != "" and $seat3 == ""){
                $s = $seat2;
            }
            if($seat1 != "" and $seat2 == "" and $seat3 == ""){
                $s = $seat1;
            }
            if($seat1 != "" and $seat2 != "" and $seat3 == ""){
                $s = $seat1." ".$seat2;
            }
            if($seat1 != "" and $seat2 == "" and $seat3 != ""){
                $s = $seat1." ".$seat3;
            }
            if($seat1 == "" and $seat2 != "" and $seat3 != ""){
                $s = $seat2." ".$seat3;
            }
            if($seat1 != "" and $seat2 != "" and $seat3 != ""){
                $s = $seat1." ".$seat2." ".$seat3;
            }
            
            $param_seat = $s;
            $param_usr = $_SESSION["username"];
            if(mysqli_stmt_execute($stmt)){
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
            
        }

    }
                header("location: welcomepage.php");
                exit();
            
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seat Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="drop_down.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
         body{
            background-color: ##90ee90;
            background-image: url("seats.png");
            background-repeat: no-repeat;
            background-position: 95% 50%;
            background-size: 617px 700px;

        }
        body {
  background-color: #C0C0C0;
  font-family: "Roboto", helvetica, arial, sans-serif;
  font-size: 16px;
  font-weight: 400;
  text-rendering: optimizeLegibility;
}

div.table-title {
   display: block;
     margin-left: 510px;
  max-width: 600px;

  padding:5px;
  width: 100%;
}

.table-title h3 {
   color: #fafafa;
   font-size: 30px;
   margin-top: -600px;
   font-weight: 400;
   font-style:normal;
   font-family: "Roboto", helvetica, arial, sans-serif;
   text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
   text-transform:uppercase;
}


/*** Table Styles **/

.table-fill {
  background: white;
  border-radius:3px;
  border-collapse: collapse;
  height: 320px;
  margin-top: -570px;
  margin-left: 420px;
  max-width: 700px;
  padding:5px;
  width: 120%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  animation: float 5s infinite;
}
 
th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:23px;
  font-weight: 100;
  padding:24px;
  font-weight: bold;
  text-align:left;
  font-style: italic;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
}

th:first-child {
  border-top-left-radius:3px;
  font-style: italic;
  font-weight: bold;
}
 
th:last-child {
  border-top-right-radius:3px;
  border-right:none;
  font-style: italic;
  font-weight: bold;
}
  
tr {
  border-top: 1px solid #C1C3D1;
  border-bottom-: 1px solid #C1C3D1;
  color:#666B85;
  font-size:16px;
  font-weight:normal;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}
 
tr:hover td {
  background:#4E5066;
  color:#FFFFFF;
  border-top: 1px solid #22262e;
}
 
tr:first-child {
  border-top:none;
}

tr:last-child {
  border-bottom:none;
}
 
tr:nth-child(odd) td {
  background:#EBEBEB;
}
 
tr:nth-child(odd):hover td {
  background:#4E5066;
}

tr:last-child td:first-child {
  border-bottom-left-radius:3px;
}
 
tr:last-child td:last-child {
  border-bottom-right-radius:3px;
}
 
td {
  background:#FFFFFF;
  padding:20px;
  text-align:left;
  vertical-align:middle;
  font-weight:300;
  font-size:18px;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  border-right: 1px solid #C1C3D1;
}

td:last-child {
  border-right: 0px;
}

th.text-left {
  text-align: left;
}

th.text-center {
  text-align: center;
}

th.text-right {
  text-align: right;
}

td.text-left {
  text-align: left;
}

td.text-center {
  text-align: center;
}

td.text-right {
  text-align: right;
}

#table1{  
  width: 120%;  
  border: 2px solid black;
  padding: 30 px;
  border-collapse: collapse;
  text-align: center;
  font-size: 20px;  
  margin-left: 420px;
  margin-top: 30px;
  font-weight: bold;
}

    </style>
</head>
<body>
    <div class="wrapper">
        <h2 style="color:black">Seat Booking Details</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($Gender_err)) ? 'has-error' : ''; ?>">

                <label>Gender:</label><br>
                <select name="Gender" id="Gender" style="width: 312px;height: 35px;" class="form_control" value="<?php echo $Gender; ?>" required>
                    <option value="">NOT SELECTED</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                </select>
                <!--<input type="char" name="Gender" class="form-control" value=""required>-->
                <span class="help-block"><?php echo $Gender_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($stadium_err)) ? 'has-error' : ''; ?>">
            
                <label for="stadium">Stadium Name:</label><br>
                    <select name="stadium"style="width: 312px;height: 35px;" class="form_control" value="<?php echo $stadium; ?>" required>
                    <option value="">NOT SELECTED</option>
                        <option value="Wankhede Stadium">Wankhede Stadium</option>
                        <option value="Chinmaswamy Stadium">Chinmaswamy Stadium</option>
                        <option value="Eden Gardens">Eden Gardens</option>
                        <option value="Chidambaram Stadium">Chidambaram Stadium</option>
                    </select>
                    
                <!--<input type="text" name="stadium" class="form-control" value="" required>-->
                <span class="help-block"><?php echo $stadium_err; ?></span>
            </div>




            
            <div class="form-group <?php echo (!empty($seat_err)) ? 'has-error' : ''; ?>">
                <label>Seat1</label><br>
                    <select name="seat1"style="width: 312px;height: 35px;" class="form_control" value="<?php echo $seat1; ?>" required>
                         <option value="">NOT SELECTED</option>
                         <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="B4">B4</option>
                        <option value="B5">B5</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                        <option value="C4">C4</option>
                        <option value="C5">C5</option>
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </select>
                <!--<input type="text" name="seat" class="form-control" value="" required>-->
                <span class="help-block"><?php echo $seat_err; ?></span>
            </div>
            <div class="form-group">

                <label>Seat2</label><br>
                    <select name="seat2"style="width: 312px;height: 35px;" class="form_control" value="<?php echo $seat2; ?>">
                         <option value="NOT SELECTED">NOT SELECTED</option>
                         <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="B4">B4</option>
                        <option value="B5">B5</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                        <option value="C4">C4</option>
                        <option value="C5">C5</option>
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </select>
            </div>
            <div class="form-group">

                <label>Seat3</label><br>
                    <select name="seat3"style="width: 312px;height: 35px;" class="form_control" value="<?php echo $seat3; ?>">
                         <option value="NOT SELECTED">NOT SELECTED</option>
                         <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="B4">B4</option>
                        <option value="B5">B5</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                        <option value="C4">C4</option>
                        <option value="C5">C5</option>
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="D4">D4</option>
                        <option value="D5">D5</option>
                    </select>
            </div>


            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <div class="table-title">

</div>
<table class="table-fill">
<thead>
<tr>
<th class="text-left">  Stand  </th>
<th class="text-left">Price</th>
</tr>
</thead>
<tbody class="table-hover">
<tr>
<td class="text-left"> Stand A</td>
<td class="text-left"> Rs.500</td>
</tr>
<tr>
<td class="text-left">Stand B</td>
<td class="text-left"> Rs.750</td>
</tr>
<tr>
<td class="text-left">Stand C</td>
<td class="text-left"> Rs.1000</td>
</tr>
<tr>
<td class="text-left">Stand D</td>
<td class="text-left"> Rs.2000</td>
</tr>

</tbody>
</table>
  
<table id="table1">
  <tr bgcolor="grey">
    <th><b><i>Stadium Name</i></b></th>
    <th><b><i>Match</i></b></th>
  </tr>
  <tr bgcolor="#096CFF">
    <td>Wankhede Stadium</td>
    <td>MI vs DC</td>
  </tr>
  <tr bgcolor="#FF2309">
    <td>Chinmaswamy Stadium</td>
    <td>RCB vs KXIP</td>
  </tr>
   <tr bgcolor="#A309FF">
    <td>Eden Gardens</td>
    <td>KKR vs RR</td>
  </tr>
  <tr bgcolor="yellow">
    <td>Chidambaram Stadium</td>
    <td>CSK vs SRH</td>
  </tr>
</table>


    </div>    
</body>
</html>