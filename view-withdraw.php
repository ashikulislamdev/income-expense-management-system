<?php
    include("session.php");

    
?>
      <?php 
        include_once 'includes/nav.php';
      ?>
            <div class="container-fluid" style="overflow:scroll;">
            
               <br>
               <br>
                

                <?php 
                    if (isset($_GET['ctgry']) && $_GET['ctgry']=='en_wdr') {

                        $all_withdrowal = mysqli_query($con, "SELECT * FROM expenses WHERE expensecategory='মালিকের উত্তোলন' AND user_id = '$userid' ORDER BY expense_id DESC");

                        
                        ?>

                        <div class="row justify-content-center pt-2 print-area-2">

                          <div class="col-md-12 text-center">
                              <h5>মালিকের উত্তোলনসমূহ</h5>
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
                                      <th colspan="2">Action</th>
                                   </tr>
                                </thead>
                                <tbody id="dataTable">
                                    <?php $count = 1; while ($row = mysqli_fetch_array($all_withdrowal)) { ?>
                                    <tr>
                                       <td><?php echo $count++ ;?></td>
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
                                    <?php } ?>
                                </tbody>
                             </table>
                          </div>
                       </div>
                       
                        <!-- <div style="float: right;">
                            <a class="btn btn-success" onclick="window.print();">Print Report</a>
                        </div> -->
                       <br>
                       <br>
                    <?php 
                        
                    }
                ?>


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