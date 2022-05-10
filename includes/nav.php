<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="income and expenses management system জমাখরচ is very easy to user. You can manage your business, delay income and daily expenses.">
  <meta name="keywords" content="income, expenses, income-expenses, income-expenses management system, জমাখরচ, host-satkania, dedicated-hosting, web-hosting, cloud hosting">
  <meta name="developer" content="income and expenses management system জমাখরচ is developed by RS Group, ashikul islam saun, rabiull hassan">
  <meta name="author" content="Rabiull hassan, ashikul islam saun">


  <title>জমাখরচ - Dashboard</title>
  <link rel="icon" type="image/png" href="icon/জমাখরচ-2-cir.png">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Bx Icon CDN -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }
    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }

  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <?php 
          if ($user_type==1) {
            ?>
              <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Manage Users</a>
            <?php
          }else{
            ?>
              <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
              <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="minus-square"></span> Add Expenses</a>
              <a href="manage_expense.php" class="list-group-item list-group-item-action "><i class='bx bx-slider-alt'></i> Manage Expenses</a>

              <a href="add_income.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Income</a>
              <a href="manage_income.php" class="list-group-item list-group-item-action "><i class='bx bx-customize'></i> Manage Income</a>
            <?php
          }
        ?>
      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span> Profile</a>
        
        <!-- <select class="list-group-item list-group-item-action" onchange="set_language()" name="language">
          <option value="en">ENGLISH</option>
          <option value="bn">বাংলা</option>
        </select> -->

        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>

      <div class="sidebar-heading">About</div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action"><i class='bx bx-user-pin' ></i>About Us</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light  border-bottom">

        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Your Profile</a>
                <a class="dropdown-item" href="change_password.php">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>