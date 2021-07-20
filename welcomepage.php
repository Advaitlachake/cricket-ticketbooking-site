<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: loginpage.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.css">
    <style type="text/css">

table, th, td {
  border: 2px solid black;
}
        body{ font: 14px sans-serif; text-align: center; }
         body{
            background-image: url("welcomestadium.jpg");
            background-repeat: no-repeat;
               background-size: 1600px,900px;
        
        }
        .h1{ width: 350px; padding: 20px;

            font-family: "Open Sans", Sans-serif;
  text-transform: uppercase;
  font-weight: 700;
  
  letter-spacing: 0.1em;
  margin-bottom: 10px;  
  position: relative;
 } 
        td {
  height: 70px;
  width: 100px;
}

div.container {
   display: block;
     
  

  
  width: 80%;
}

.container h3 {
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


th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:23px;
  font-weight: 100;
  padding:24px;
  font-weight: bold;
  text-align:center;
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
  text-align:center;
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


}
    </style>
}
</head>
<body>
    <div class="page-header">
        <h1> <b> Booking Details</b></h1>
    </div>
    <?php
    require_once "connectfile.php";
        $username=$_SESSION["username"];
        $sql = "SELECT Gender, Name, Email, seatno, stadiumname FROM stadium WHERE username = '$username'";
        $stmt = mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($stmt);
        $Gender=$row['Gender'];
        $name=$row['Name'];
        $email=$row['Email'];
        $seat=$row['seatno'];
        $stadium=$row['stadiumname'];
        echo '
              <div class="container">  
              <table style="width:100%"  textalign="center">
              <thead>
                <tr>
                <th><b>Name</b></th>
                <th><b>Email</b></th>
                <th><b>Gender</b></th>
                <th><b>Stadium</b></th>
                <th><b>Seat</b></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                <td style="height:100px;width:50px"><b>'.$name.'</b></td>
                <td><b>'.$email.'</b></td>
                <td><b>'.$Gender.'</b></td>
                <td><b>'.$stadium.'</b></td>
                <td><b>'.$seat.'</b></td>
                </tr>
              </tbody>
              </table>
              </div>' ;
    ?>
    <p><br>
        <br>
        <a href="infopage.php" class="btn btn-warning">Edit Your Booking Details</a>
         <a href="paymentpage.php" class="btn btn-warning">Proceed to Payment</a>
        <a href="logoutpage.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>