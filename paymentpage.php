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
     <style type="text/css">
        body{background-color: #B5E61D ;
        
        . width: 350px; padding: 20px;

            font-family: "Open Sans", Sans-serif;
  text-transform: uppercase;
  font-weight: 700;
  
  letter-spacing: 0.1em;
  margin-bottom: 10px;  
  position: relative;
 
        text-align: center; }
         body{
            background-image: url("msd3.png"),url("vk2.png");
            background-repeat: no-repeat,no-repeat;
            background-position: -100px 100px,950px 100px; 
             background-size: 900px 600px, 700px 600px; 
              
        }
        * {
  box-sizing: border-box;
}

:root {
  --background: #E5FFB3;
  --background-accent: #DBF8A3;
  --background-accent-2: #BDE66E;
  --light: #92DE34;
  --dark: #69BC22;
  --text: #025600;
}


 
input[type=submit]
{
    display: block;
  cursor: pointer;
  outline: none;
  border: none;
  background-color: var(--light);
  width: 200px;
  height: 70px;
  border-radius: 30px;
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text);
  background-size: 100% 100%;
  box-shadow: 0 0 0 7px var(--light) inset;
  margin-bottom: -100px;
  margin-left: 650px; 
}
input[type=submit]:hover {
  background-image: linear-gradient(
    145deg,
    transparent 10%,
    var(--dark) 10% 20%,
    transparent 20% 30%,
    var(--dark) 30% 40    
    transparent 40% 50%,
    var(--dark) 50% 60%,
    transparent 60% 70%,
    var(--dark) 70% 80%,
    transparent 80% 90%,

    var(--dark) 90% 100%
  );
  animation: background 3s linear infinite;
}

button {
  display: block;
  cursor: pointer;
  outline: none;
  border: none;
  background-color: var(--light);
  width: 200px;
  height: 70px;
  border-radius: 30px;
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text);
  background-size: 100% 100%;
  box-shadow: 0 0 0 7px var(--light) inset;
  
   }
button:hover {
  background-image: linear-gradient(
    145deg,
    transparent 10%,
    var(--dark) 10% 20%,
    transparent 20% 30%,
    var(--dark) 30% 40%
    transparent 40% 50%,
    var(--dark) 50% 60%,
    transparent 60% 70%,
    var(--dark) 70% 80%,
    transparent 80% 90%,
    var(--dark) 90% 100%
  );
  animation: background 3s linear infinite;
}


    </style>
    <title>Redirecting to Payment</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

    <div class="page-header">
        <h1>Payment Summary for <b><?php echo htmlspecialchars(strtoupper($_SESSION["username"])); ?>'s Ticket Booking</b></h1>
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
        $individual_seats = explode(" ", $seat);
        $count = count($individual_seats);
        $cost = 0;

        foreach ($individual_seats as &$seat_val) {
            
            $stand_cost = 0;

            if($seat_val[0] == 'A'){
                $stand_cost = 500;
            }
            if($seat_val[0] == 'B'){
                $stand_cost = 750;
            }
            if($seat_val[0] == 'C'){
                $stand_cost = 1000;
            }
            if($seat_val[0] == 'D'){
                $stand_cost = 2000;
            }
            $cost = $cost + $stand_cost;
        }

        
         echo "<p><font face='arial' size='6pt'>Stadium: <b>$stadium</b></font> </p>";
         
         echo "<p> <font face='arial' size='6pt'>Seat Details: <b>$seat</b></font> </p>";
         
        echo "<p> <font face='arial' size='6pt'>No of seats: <b>$count</b></font> </p>";
        
        echo "<p> <font face='arial' size='6pt'>Total Cost: <b>$cost</b></font> </p>";
        

        $content = "Stadium:".$stadium."\n"."Seat Details:".$seat."\n"."No of seats:".$count."\n"."Total Cost:".$cost."\n";

        if(array_key_exists('button', $_POST)) { 
                  final_mail($content,$email);}
  
function final_mail($content,$email) {
    $sender = "shubhamk00@gmail.com";
    $to = $email;
    $subject = "Ticket Booked";

$mailsent = mail($to,$subject,$content);

if($mailsent)
  echo "<h3><b>Booking  Details have been sent successfully!</b></h3>";
else
 echo "<h3>the mail couldn't be sent . Something went wrong.</h3>";
}

?>

<form method="post">
<input style="font-size:30px" type="submit" name="button" class="w3-button w3-black w3-padding-large w3-margin-bottom" value="Book" /><br>
</form>
<br>
<br>
<button style ="margin-top: -50px;" class="w3-button w3-black w3-padding-large w3-margin-bottom" onclick="location.href='ratingpage.html'">RATE OUR PAGE</button>
<br>
<br>
<button  style ="margin-top: 0px;"class="w3-button w3-black w3-padding-large w3-margin-bottom" onclick="location.href='logoutpage.php'">SIGN OUT</button>

</body>
</html>