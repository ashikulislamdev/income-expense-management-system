<?php
    include("session.php");

    //Get all data query
    $income_fetched = mysqli_query($con, "SELECT * FROM incomes WHERE user_id = '$userid' ORDER BY incomedate DESC");

    //Get monthly data
    if (isset($_GET['data']) && $_GET['data']=='last_month') {
    	$income_fetched = mysqli_query($con, "SELECT * FROM `incomes` WHERE incomedate > (NOW() - INTERVAL 1 MONTH) AND `user_id` = '$userid' ORDER BY incomedate DESC");
    }

    //get day to day data
    if (isset($_GET['data']) && $_GET['data']=='last_day') {
        $income_fetched = mysqli_query($con, "SELECT * FROM `incomes` WHERE incomedate > (NOW() - INTERVAL 1 DAY) AND `user_id` = '$userid' ORDER BY incomedate DESC");
    }
?>
	  <?php 
        include_once 'includes/nav.php';
      ?>

      
            <div class="container-fluid" style="overflow:scroll;">
               <h3 class="mt-4 text-center">Manage Incomes</h3>
               <hr>

               <div class="d-flex" style="min-width: 700px;">
                  <div class="mr-auto p-2">
                      <a href="add_income.php" class="btn btn-primary">Add New Income</a>
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
                </div>
               <?php 
                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];

                        $filter_query = "SELECT * FROM incomes WHERE incomedate BETWEEN '$from_date' AND '$to_date' AND user_id = '$userid' ORDER BY incomedate DESC";
                        $filter_res = mysqli_query($con, $filter_query);


                        //get last month income report 
                        $income_filter_amount = mysqli_query($con, "SELECT SUM(income) AS filtered_income FROM `incomes` WHERE incomedate BETWEEN '$from_date' AND '$to_date' AND `user_id` = '$userid'");
                        $income_filter_amount = mysqli_fetch_assoc($income_filter_amount); 
                        $income_filter_amount = $income_filter_amount['filtered_income'];

                        if (mysqli_num_rows($filter_res) > 0) {
                            ?>

                                <div class="row justify-content-center pt-2 print-area-2">

                                  <div class="col-md-12 text-center">
                                      <h5>Income Data <?php echo $from_date; ?> to <?php echo $to_date; ?> </h5>
                                  </div>
                                  <div class="col-md-12 text-center">
                                      <h3> Total Income (<?php echo $income_filter_amount; ?> TK)</h3>
                                  </div>

                                  <div class="col-md-12">
                                     <table class="table table-hover table-bordered">
                                        <thead>
                                           <tr class="text-center">
                                              <th>#</th>
                                              <th>Date</th>
                                              <th>Amount</th>
                                              <th>Income Type</th>
                                              <th>Income Note</th>
                                           </tr>
                                        </thead>
                                        <tbody id="dataTable">
                                            <?php $count=mysqli_num_rows($filter_res); while ($row = mysqli_fetch_array($filter_res)) { ?>
                                            <tr>
                                               <td><?php echo $count--;?></td>
                                               <td><?php echo $row['incomedate']; ?></td>
                                               <td><?php echo $row['income']; ?> TK</td>
                                               <td><?php echo $row['incomecategory']; ?></td>
                                               <td><?php echo $row['income_note']; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               
                               <div style="float: right;">
                                    <a class="btn btn-success" onclick="window.print();">Print Report</a>
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
                  <div class="col-md-12">
                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>Date</th>
                              <th>Amount</th>
                              <th>Income Category</th>
                              <th>Income Note</th>
                              <th colspan="2">Action</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable">
	                        <?php $count=mysqli_num_rows($income_fetched); while ($row = mysqli_fetch_array($income_fetched)) { ?>
	                        <tr>
	                           <td><?php echo $count--;?></td>
	                           <td><?php echo $row['incomedate']; ?></td>
	                           <td><?php echo $row['income']; ?> TK</td>
	                           <td><?php echo $row['incomecategory']; ?></td>
	                           <td><?php echo $row['income_note']; ?></td>
	                           <td class="text-center">
	                              <a href="add_income.php?edit=<?php echo $row['income_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
	                           </td>
	                           <td class="text-center">
	                              <a href="add_income.php?delete=<?php echo $row['income_id']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
	                           </td>
	                        </tr>
	                        <?php } ?>
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