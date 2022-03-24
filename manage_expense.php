<?php
    include("session.php");

    //get all data query 
    $exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid' ORDER BY expensedate DESC");

    //get monthly data 
    if (isset($_GET['data']) && $_GET['data']=='last_month') {
        $exp_fetched = mysqli_query($con, "SELECT * FROM `expenses` WHERE expensedate > (NOW() - INTERVAL 1 MONTH) AND `user_id` = '$userid' ORDER BY expensedate DESC");
    }

    //get day to day data
    if (isset($_GET['data']) && $_GET['data']=='last_day') {
        $exp_fetched = mysqli_query($con, "SELECT * FROM `expenses` WHERE expensedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid' ORDER BY expensedate DESC");
    }


?>
      <?php 
        include_once 'includes/nav.php';
      ?>
            <div class="container-fluid">
            
               <hr>
                <div class="d-flex">
                  <div class="mr-auto p-2">
                      <a href="add_expense.php" class="btn btn-primary">Add New Expance</a>
                  </div>
                  <div class="mr-auto p-2">
                      <form class="form-inline ml-auto" method="GET">
                          <div class="row">
                              <div class="form-group">
                                  <label>From date &nbsp;</label>
                                  <input type="date" name="from_date" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label>&nbsp; To date &nbsp</label>
                                  <input type="date" name="to_date" class="form-control">&nbsp; 
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary">Filter</button>
                              </div>
                          </div>
                      </form>
                  </div>
                  <!-- <div class="p-2">
                    <form class="form-inline ml-auto">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar bg-white" type="search" id="search_box" placeholder="Search here..." style="height: 40px; width: 200px;">
                            <div class="input-group-append">
                                <button class="btn btn-navbar bg-primary px-3" type="submit">
                                    <i class='bx bx-search-alt-2' style="font-size: 25px; color: white;"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                  </div> -->
                </div>
                <?php 
                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];

                        $filter_query = "SELECT * FROM expenses WHERE expensedate BETWEEN '$from_date' AND '$to_date' AND  user_id = '$userid' ORDER BY expensedate DESC";
                        $filter_res = mysqli_query($con, $filter_query);


                        //get last month expense report 
                        $expence_filter_amount = mysqli_query($con, "SELECT SUM(expense) AS filtered_expenses FROM `expenses` WHERE expensedate BETWEEN '$from_date' AND '$to_date' AND `user_id` = '$userid'");
                        $expence_filter_amount = mysqli_fetch_assoc($expence_filter_amount); 
                        $expence_filter_amount = $expence_filter_amount['filtered_expenses'];

                        if (mysqli_num_rows($filter_res) > 0) {
                            ?>

                                <div class="row justify-content-center pt-2">

                                  <div class="col-md-12 text-center">
                                      <h5>Expenses Data <?php echo $from_date; ?> to <?php echo $to_date; ?> </h5>
                                  </div>
                                  <div class="col-md-12 text-center">
                                      <h3> Total Expenses (<?php echo $expence_filter_amount; ?> TK)</h3>
                                  </div>

                                  <div class="col-md-12">
                                     <table class="table table-hover table-bordered">
                                        <thead>
                                           <tr class="text-center">
                                              <th>#</th>
                                              <th>Date</th>
                                              <th>Amount</th>
                                              <th>Expense Category</th>
                                              <th>Expense Note</th>
                                           </tr>
                                        </thead>
                                        <tbody id="dataTable">
                                            <?php $count=1; while ($row = mysqli_fetch_array($filter_res)) { ?>
                                            <tr>
                                               <td><?php echo $count;?></td>
                                               <td><?php echo $row['expensedate']; ?></td>
                                               <td><?php echo $row['expense']; ?> TK</td>
                                               <td><?php echo $row['expensecategory']; ?></td>
                                               <td><?php echo $row['expense_note']; ?></td>
                                            </tr>
                                            <?php $count++; } ?>
                                        </tbody>
                                     </table>
                                  </div>
                               </div>

                               <br>
                               <br>
                            <?php 
                        }else{
                            echo "<h5 class='text-center text-danger'>No Data Found!</h5>";
                        }
                    }
                ?>

                
               <div class="row justify-content-center pt-2">
                  <h4>All Expenses Record</h4>
                  <div class="col-md-12">
                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Expense Category</th>
                              <th>Expense Note</th>
                              <th colspan="2">Action</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable">
                            <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                            <tr>
                               <td><?php echo $count;?></td>
                               <td><?php echo $row['expensedate']; ?></td>
                               <td><?php echo $row['expense']; ?> TK</td>
                               <td><?php echo $row['expensecategory']; ?></td>
                               <td><?php echo $row['expense_note']; ?></td>
                               <td class="text-center">
                                  <a href="add_expense.php?edit=<?php echo $row['expense_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
                               </td>
                               <td class="text-center">
                                  <a href="add_expense.php?delete=<?php echo $row['expense_id']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
                               </td>
                            </tr>
                            <?php $count++; } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
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
        $(document).ready(function(){
            $("#search_box").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#dataTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
      </script>
   </body>
</html>