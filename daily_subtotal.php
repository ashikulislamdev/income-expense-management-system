<?php 
  include("session.php");

  $exp_fetched = mysqli_query($con, "SELECT * FROM `expenses` WHERE expensedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid' ORDER BY expensedate DESC");

  $income_fetched = mysqli_query($con, "SELECT * FROM `incomes` WHERE incomedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid' ORDER BY incomedate DESC");

  //get last day income report 
  $income_last_day_amount = mysqli_query($con, "SELECT SUM(income) AS last_day_incomes FROM `incomes` WHERE incomedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid'");
  $income_last_day_amount = mysqli_fetch_assoc($income_last_day_amount); 
  $income_last_day_amount = $income_last_day_amount['last_day_incomes'];


  //get last day expense report 
  $expenses_last_day_amount = mysqli_query($con, "SELECT SUM(expense) AS last_day_expenses FROM `expenses` WHERE expensedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid'");
  $expenses_last_day_amount = mysqli_fetch_assoc($expenses_last_day_amount); 
  $expenses_last_day_amount = $expenses_last_day_amount['last_day_expenses'];

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

    @media print{
      body{
        visibility: hidden;
      }
      .print-area, .print-area * {
        visibility: visible;
      }
      .print-area, .print-area body{
        justify-content: center;
        align-items: center;
        margin: auto;
      }
    }

  </style>

</head>

<body class="bg-white">
      
    <div class="container-fluid pt-2">
      <div class="row justify-content-center table-bordered m-1 print-area">
        <div class="col-md-12 d-flex mt-2">
          <h6 class="mr-auto">Date : <?php echo date('d-m-y') ?> </h6>
          <h6>Name : <?php echo $username; ?></h6>
        </div>
          <div class="col-md-12 col-sm-12 col-12">
             <table class="table table-hover table-bordered">
                <thead>
                   <tr class="text-center">
                      <th colspan="4">Incomes</th>
                   </tr>
                   <tr class="text-center">
                      <th>S/N</th>
                      <th>Income Type</th>
                      <th>Income Note</th>
                      <th>Amount</th>
                   </tr>
                </thead>
                <tbody id="dataTable">
                    <?php $count=1; while ($row = mysqli_fetch_array($income_fetched)) { ?>
                    <tr>
                       <td><?php echo $count;?></td>
                       <td><?php echo $row['incomecategory']; ?></td>
                       <td><?php echo $row['income_note']; ?></td>
                       <td><?php echo $row['income']; ?> TK</td>
                    </tr>
                    <?php $count++; } ?>
                    <tr>
                       <td colspan="3" class="text-right">Total Incomes</td>
                       <td><?php echo $income_last_day_amount ? $income_last_day_amount : '00' ; ?> TK</td>
                    </tr>
                </tbody>
             </table>
          </div>

          <div class="col-md-12 col-sm-12 col-12">
             <table class="table table-hover table-bordered">
                <thead>
                   <tr class="text-center">
                      <th colspan="4">Expenses</th>
                   </tr>
                   <tr class="text-center">
                      <th>S/N</th>
                      <th>Expense Type</th>
                      <th>Expense Note</th>
                      <th>Amount</th>
                   </tr>
                </thead>
                <tbody id="dataTable">
                    <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                    <tr>
                       <td><?php echo $count;?></td>
                       <td><?php echo $row['expensecategory']; ?></td>
                       <td><?php echo $row['expense_note']; ?></td>
                       <td><?php echo $row['expense']; ?> TK</td>
                    </tr>
                    <?php $count++; } ?>
                    <tr>
                       <td colspan="3" class="text-right">Total Expenses</td>
                       <td><?php echo $expenses_last_day_amount ? $expenses_last_day_amount : '00'; ?> TK</td>
                    </tr>
                    <tr>
                       <td colspan="3" class="text-right"><b>Cash</b></td>
                       <td><?php echo $income_last_day_amount - $expenses_last_day_amount ? $income_last_day_amount - $expenses_last_day_amount : '00' ; ?> TK</td>
                    </tr>
                </tbody>
             </table>
          </div>

      </div>
          <div class="float-right pt-1 pr-2">
            <a class="btn btn-success" href="index.php">Go-to Home</a>
            <a class="btn btn-primary" onclick="window.print();">Print</a>
          </div>
    </div>
    


  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
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
  
</body>

</html>