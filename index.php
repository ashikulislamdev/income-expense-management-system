<?php
  include("session.php");
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");

  $inc_category_dc = mysqli_query($con, "SELECT incomecategory FROM incomes WHERE user_id = '$userid' GROUP BY incomecategory");
  $inc_amt_dc = mysqli_query($con, "SELECT SUM(income) FROM incomes WHERE user_id = '$userid' GROUP BY incomecategory");


  $exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");


  $inc_date_line = mysqli_query($con, "SELECT incomedate FROM incomes WHERE user_id = '$userid' GROUP BY incomedate");
  $inc_amt_line = mysqli_query($con, "SELECT SUM(income) FROM incomes WHERE user_id = '$userid' GROUP BY incomedate");


  //get last all income report
  $income_amount = mysqli_query($con, "SELECT SUM(income) AS incomes FROM `incomes` WHERE `user_id` = '$userid'");
  $income_amount = mysqli_fetch_assoc($income_amount); 
  $income_amount = $income_amount['incomes'];

  //get last all expense report
  $expence_amount = mysqli_query($con, "SELECT SUM(expense) AS expenses FROM `expenses` WHERE `user_id` = '$userid'");
  $expence_amount = mysqli_fetch_assoc($expence_amount); 
  $expence_amount = $expence_amount['expenses'];

//SELECT SUM(income) AS last_month_incomes FROM incomes WHERE MONTH(incomedate)=MONTH(now()) AND YEAR(incomedate)=YEAR(now()) AND user_id = 20;
  
  //get last month income report
  $income_last_month_amount = mysqli_query($con, "SELECT SUM(income) AS last_month_incomes FROM `incomes` WHERE MONTH(incomedate)=MONTH(now()) AND YEAR(incomedate)=YEAR(now()) AND `user_id` = '$userid'");
  $income_last_month_amount = mysqli_fetch_assoc($income_last_month_amount); 
  $income_last_month_amount = $income_last_month_amount['last_month_incomes'];


  //get last month expense report 
  $expence_last_month_amount = mysqli_query($con, "SELECT SUM(expense) AS last_month_expenses FROM `expenses` WHERE MONTH(expensedate)=MONTH(now()) AND YEAR(expensedate)=YEAR(now()) AND `user_id` = '$userid'");
  $expence_last_month_amount = mysqli_fetch_assoc($expence_last_month_amount); 
  $expence_last_month_amount = $expence_last_month_amount['last_month_expenses'];


  //get last day income report 
  $income_last_day_amount = mysqli_query($con, "SELECT SUM(income) AS last_day_incomes FROM `incomes` WHERE incomedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid'");
  $income_last_day_amount = mysqli_fetch_assoc($income_last_day_amount); 
  $income_last_day_amount = $income_last_day_amount['last_day_incomes'];


  //get last day expense report 
  $expenses_last_day_amount = mysqli_query($con, "SELECT SUM(expense) AS last_day_expenses FROM `expenses` WHERE expensedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid'");
  $expenses_last_day_amount = mysqli_fetch_assoc($expenses_last_day_amount); 
  $expenses_last_day_amount = $expenses_last_day_amount['last_day_expenses'];


  // à¦®à¦¾à¦²à¦¿à¦•à§‡à¦° à¦‰à¦¤à§à¦¤à§‹à¦²à¦¨ মানে মালিকের উত্তোলন latin1_swedish_ci EntrepreneurWithdrawal 

                                  // Warning, Edit carefully
  $self_profit = mysqli_query($con, "SELECT SUM(expense) AS full_profit FROM `expenses` WHERE expensecategory='????' AND `user_id` = '$userid'");
  $self_profit = mysqli_fetch_assoc($self_profit);
  $self_profit = $self_profit['full_profit'];


  $all_users = "SELECT * FROM users";
  $users_result = $con->query($all_users);

?>
      
      <?php 
        include_once 'includes/nav.php';
      ?>

      
      <?php 
        if ($user_type==1) {
          ?>
            <div class="container-fluid">
                <div class="justify-content-center pt-2">
                  <div class="col-md-12" style="overflow:scroll;">
                  <div class="mr-auto p-2">
                      <a href="iems-register" class="btn btn-primary">Add New Expance</a>
                  </div>
                     <table class="table table-hover table-bordered" style="min-width: 700px;">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>User Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Profile</th>
                              <th colspan="2">Action</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable" class="text-center">
                          <?php $count=1; while ($row = mysqli_fetch_array($users_result)) { ?>
                          <tr>
                             <td><?php echo $count;?></td>
                             <td><?php echo $row["firstname"]; ?></td>
                             <td><?php echo $row["email"]; ?> </td>
                             <td><?php echo $row["phone_no"]; ?></td>
                             <td><img src="<?php echo "uploads/".$row["profile_path"]; ?>" width="57px" ></td>
                             <td class="text-center">
                             <a type="button" data-toggle="modal" data-target="#confirmEditModal" class="btn btn-primary btn-sm text-white" style="border-radius:0%;">Details</a>
                             </td>
                             <td class="text-center">
                                <a type="button" data-toggle="modal" data-target="#confirmDeleteModal" class="btn btn-danger btn-sm text-white" style="border-radius:0%;">Delete</a>
                             </td>
                          </tr>
                          <?php $count++; } ?>
                        </tbody>
                     </table>

                      <!-- Delete Modal -->
                      <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-danger">Are you sure? You want to delete this user!</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>


                      <!--Edit Modal -->
                      <div class="modal fade" id="confirmEditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="EditModalLabel">Edit User Data</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p class="text-danger">Are you sure? You want to edit this user!</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </div>
                        </div>
                      </div>

                  </div>
               </div>
            </div>
          <?php
        }else{
          ?>
            <div class="container-fluid">
              <h3 class="mt-4">Dashboard</h3>
              <div class="row">
                <div class="col-md" style="overflow: scroll;">
                  <div class="card" style="min-width: 700px;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col text-center">
                          <a href="add_income"><img src="icon/add-income.png" width="57px" />
                            <p class="language_en" id="language_en">Add Income</p>
                            <p class="language_bn" id="language_bn">আয় যুক্ত করুন</p>
                          </a>
                        </div>
                        <div class="col text-center">
                          <a href="manage_income"><img src="icon/manage-income.png" width="57px" />
                            <p class="language_en" id="language_en">Manage Income</p>
                            <p class="language_bn" id="language_bn">আয় ম্যানেজ করুন</p>
                          </a>
                        </div>
                        <div class="col text-center">
                          <a href="add_expense"><img src="icon/addex.png" width="57px" />
                            <p class="language_en" id="language_en">Add Expenses</p>
                            <p class="language_bn" id="language_bn">খরচ যুক্ত করুন</p>
                          </a>
                        </div>
                        <div class="col text-center">
                          <a href="manage_expense"><img src="icon/maex.png" width="57px" />
                            <p class="language_en" id="language_en">Manage Expenses</p>
                            <p class="language_bn" id="language_bn">খরচ ম্যানেজ করুন</p>
                          </a>
                        </div>
                        <div class="col text-center">
                          <a href="profile"><img src="icon/prof.png" width="57px" />
                            <p class="language_en" id="language_en">Profile</p>
                            <p class="language_bn" id="language_bn">প্রোফাইল</p>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="d-flex">
                  <div class="mr-auto">
                      <h3 class="mt-4">Summery</h3>
                  </div>
                  <div class="mr-auto">
                      <h3 class="mt-4 text-success">Cash <?php echo $income_amount - $expence_amount; ?></h3>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bx-dollar-circle'></i>
                              </div>
                              <h5 class="text-light">Income</h5>
                            </div>
                            <h5 class="text-white my-2">Total - <?php echo $income_amount; ?> TK</h5>
                            <a href="manage_income" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bx-food-menu'></i>
                              </div>
                              <h5 class="text-light">Expense</h5>
                            </div>
                            <h5 class="text-white my-2">Total - <?php echo $expence_amount - $self_profit; ?> TK</h5>
                            <a href="manage_expense" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-check'></i>
                              </div>
                              <h5 class="text-light">This Month</h5>
                            </div>
                            <h5 class="text-white my-2">Income - <?php echo $income_last_month_amount; ?> TK</h5>
                            <a href="manage_income?data=last_month" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-minus'></i>
                              </div>
                              <h5 class="text-light">This Month</h5>
                            </div>
                            <h5 class="text-white my-2">Expense - <?php echo $expence_last_month_amount; ?> TK</h5>
                            <a href="manage_expense?data=last_month" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-minus'></i>
                              </div>
                              <h5 class="text-light">Today</h5>
                            </div>
                            <h5 class="text-white my-2">Income - <?php echo $income_last_day_amount; ?> TK</h5>
                            <a href="manage_income?data=last_day" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-minus'></i>
                              </div>
                              <h5 class="text-light">Today</h5>
                            </div>
                            <h5 class="text-white my-2">Expenses - <?php echo $expenses_last_day_amount; ?> TK</h5>
                            <a href="manage_expense?data=last_day" class="btn btn-sm">View All</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-minus'></i>
                              </div>
                              <h5 class="text-light">Today</h5>
                            </div>
                            <h5 class="text-white my-2">Cash - <?php echo $income_last_day_amount - $expenses_last_day_amount; ?> TK</h5>
                            <a href="daily_subtotal" class="btn btn-sm">Report</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 my-2">
                    <div class="card p-1 student_d_card">
                        <div class="border rounded p-2">
                            <div class="d-flex">
                              <div class="mr-auto">
                                  <i class='bx bxs-calendar-minus'></i>
                              </div>
                              <h5 class="text-light">Profit</h5>
                            </div>
                            <h5 class="text-white my-2">Total - <?php echo $self_profit ? $self_profit : '0'; ?> TK</h5>
                            <a href="view-withdraw?ctgry=en_wdr" class="btn btn-sm">Report</a>
                        </div>
                    </div>
                </div>

              </div>

              <h3 class="mt-4">Full-Expense Report</h3>
              <div class="row">
                <div class="col-md">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title text-center">Yearly Expenses</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="expense_line" height="150"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title text-center">Expense Category</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="expense_category_pie" height="150"></canvas>
                    </div>
                  </div>
                </div>
              </div>

              <h3 class="mt-4">Full-Income Report</h3>
              <div class="row">
                <div class="col-md">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title text-center">Yearly Incomes</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="income_line" height="150"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title text-center">Income Category</h5>
                    </div>
                    <div class="card-body">
                      <canvas id="income_category_pie" height="150"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
        }
      ?>



    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

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
  <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
                    echo '"' . $a['expensecategory'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Category',
          data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                    echo '"' . $b['SUM(expense)'] . '",';
                  } ?>],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2',
            '#1A59ED'
          ],
          borderWidth: 1
        }]
      }
    });



    var ctx2 = document.getElementById('income_category_pie').getContext('2d');
    //alert()
    var myChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($inc_category_dc)) {
                    echo '"' . $a['incomecategory'] . '",';
                  } ?>],
        datasets: [{
          label: 'Income by Category',
          data: [<?php while ($b = mysqli_fetch_array($inc_amt_dc)) {
                    echo '"' . $b['SUM(income)'] . '",';
                  } ?>],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2',
            '#1A59ED'
          ],
          borderWidth: 1
        }]
      }
    });


    var line = document.getElementById('expense_line').getContext('2d');
    var myChart = new Chart(line, {
      type: 'line',
      data: {
        labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                    echo '"' . $c['expensedate'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Month (Whole Year)',
          data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                    echo '"' . $d['SUM(expense)'] . '",';
                  } ?>],
          borderColor: [
            '#adb5bd'
          ],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2',
            '#1A59ED'
          ],
          fill: false,
          borderWidth: 2
        }]
      }
    });




    var line = document.getElementById('income_line').getContext('2d');
    var myChart = new Chart(line, {
      type: 'line',
      data: {
        labels: [<?php while ($c = mysqli_fetch_array($inc_date_line)) {
                    echo '"' . $c['incomedate'] . '",';
                  } ?>],
        datasets: [{
          label: 'Income by Month (Whole Year)',
          data: [<?php while ($d = mysqli_fetch_array($inc_amt_line)) {
                    echo '"' . $d['SUM(income)'] . '",';
                  } ?>],
          borderColor: [
            '#adb5bd'
          ],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          fill: false,
          borderWidth: 2
        }]
      }
    });
  </script>
</body>

</html>