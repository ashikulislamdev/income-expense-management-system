<?php
include("config.php");
session_start();
if(!isset($_SESSION["email"])){
  header("Location: login.php");
exit();
}

$sess_email = $_SESSION["email"];
$sql = "SELECT user_id, firstname, phone_no, email, password, address, profile_path, status, receipt_id FROM users WHERE email = '$sess_email'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $userid=$row["user_id"];
    $username =$row["firstname"];
    $phone_no = $row["phone_no"];
    $useremail=$row["email"];
    $password=md5($row["password"]);
    $address=$row["address"];
    $userprofile="uploads/".$row["profile_path"];
    $user_type=$row["status"];
    $receipt_id=$row["receipt_id"];
  }
} else {
    $userid="GHX1Y2";
    $username ="White One";
    $useremail="white@domain.com";
    $userprofile="Uploads/default_profile.png";
}
?>