<?php
require('config.php');
session_start();
$errormsg = "";
if (isset($_POST['email'])) {

  $email = stripslashes($_REQUEST['email']);
  $email = mysqli_real_escape_string($con, $email);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($con, $password);
  $query = "SELECT * FROM `users` WHERE email='$email'and password='" . md5($password) . "'";
  $result = mysqli_query($con, $query) or die(mysqli_error($con));
  $rows = mysqli_num_rows($result);
  if ($rows == 1) {
    $_SESSION['email'] = $email;
    header("Location: index");
  } else {
    $errormsg  = "Wrong";
  }
} else {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="income and expenses management system জমাখরচ is very easy to user. You can manage your buseness, dealy income and dealy expenses.">
  <meta name="keywords" content="income, expenses, income-expenses, income-expenses management system, জমাখরচ, host-satkania, dedicated-hosting, web-hosthing, cloud hosting">
  <meta name="developer" content="income and expenses management system জমাখরচ is developed by RS Group, ashikul islam saun, rabiull hassan">
  <meta name="author" content="Rabull hassan, ashikul islam saun">

  <title>Login</title>
  <link rel="icon" type="image/png" href="icon/জমাখরচ-2-cir.png">

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-form {
      width: 340px;
      margin: 50px auto;
      font-size: 15px;
    }

    .login-form form {
      margin-bottom: 15px;
      background: #fff;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border: 1px solid #ddd;
    }

    .login-form h2 {
      color: #636363;
      margin: 0 0 15px;
      position: relative;
      text-align: center;
    }

    .login-form h2:before,
    .login-form h2:after {
      content: "";
      height: 2px;
      width: 25%;
      background: #d4d4d4;
      position: absolute;
      top: 50%;
      z-index: 2;
    }

    .login-form h2:before {
      left: 0;
    }

    .login-form h2:after {
      right: 0;
    }

    .login-form .hint-text {
      color: #999;
      margin-bottom: 30px;
      text-align: center;
    }

    .login-form a:hover {
      text-decoration: none;
    }

    .form-control,
    .btn {
      min-height: 38px;
      border-radius: 2px;
    }

    .btn {
      font-size: 15px;
      font-weight: bold;
    }
  </style>
</head>

<body>
    <div class="login-form">
      <form action="" method="POST" autocomplete="off">
        <h2 class="text-center">জমা খরচ</h2>
        <p class="hint-text">Login Panel</p>
        <div class="form-group">
          <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success btn-block" style="border-radius:0%;">Login</button>
        </div>
        <div class="clearfix">
          <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
          
        </div>
      </form>
      <!-- <p class="text-center">Don't have an account?<a href="iems-register" class="text-danger"> Register Here</a></p> -->
    </div>

    <div class="text-center px-3">
      <h6>
        To see demo account use "demo@gmail.com" and "12345" as Email and Password.
      </h6>
      <p>To register your account click <a href="https://amarseba.net/?page=2">Amarseba</a></p>
    </div>
</body>
<!-- Bootstrap core JavaScript -->
<script src="js/jquery.slim.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
<script>
  feather.replace()
</script>

</html>
