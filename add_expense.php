<?php
   include("session.php");
   $update = false;
   $del = false;
   $expenseamount = "";
   $expensedate = date("Y-m-d");
   $expensecategory = "Entertainment";
   $expense_note = "";

   $exp_fetched = mysqli_query($con, "SELECT * FROM expense_category WHERE user_id = '$userid'");


   if (isset($_POST['add'])) {
       $expenseamount = htmlentities(addslashes($_POST['expenseamount']));
       $expensedate = htmlentities(addslashes($_POST['expensedate']));
       $expensecategory = htmlentities(addslashes($_POST['expensecategory']));
       $expense_note = htmlentities(addslashes($_POST['expense_note']));
   
       $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory,expense_note) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory','$expense_note')";
       $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
       header('location: add_expense');
   }
   
   if (isset($_POST['update'])) {
       $id = $_GET['edit'];
       $expenseamount = htmlentities(addslashes($_POST['expenseamount']));
       $expensedate = htmlentities(addslashes($_POST['expensedate']));
       $expensecategory = htmlentities(addslashes($_POST['expensecategory']));
       $expense_note = htmlentities(addslashes($_POST['expense_note']));
   
       $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory', expense_note='$expense_note' WHERE user_id='$userid' AND expense_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: manage_expense');
   }
   
   
   if (isset($_POST['delete'])) {
       $id = $_GET['delete'];
       $expenseamount = htmlentities(addslashes($_POST['expenseamount']));
       $expensedate = htmlentities(addslashes($_POST['expensedate']));
       $expensecategory = htmlentities(addslashes($_POST['expensecategory']));
       $expense_note = htmlentities(addslashes($_POST['expense_note']));
   
       $sql = "DELETE FROM expenses WHERE user_id='$userid' AND expense_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: manage_expense');
   }
   
   if (isset($_GET['edit'])) {
       $id = $_GET['edit'];
       $update = true;
       $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $expenseamount = $n['expense'];
           $expensedate = $n['expensedate'];
           $expensecategory = $n['expensecategory'];
           $expense_note = $n['expense_note'];
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }
   
   if (isset($_GET['delete'])) {
       $id = $_GET['delete'];
       $del = true;
       $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
   
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $expenseamount = $n['expense'];
           $expensedate = $n['expensedate'];
           $expensecategory = $n['expensecategory'];
           $expense_note = $n['expense_note'];
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }
   ?>

   
      <?php 
        include_once 'includes/nav.php';
      ?>

            <div class="container">
               <h3 class="mt-4 text-center">Add Your Daily Expenses</h3>
               <hr>
               <div class="row ">
                  <div class="col-md-6" style="margin:0 auto;">
                     <form action="" method="POST">
                        <div class="form-group row">
                           <label for="expenseamount" class="col-sm-6 col-form-label"><b>Enter Amount(৳)</b></label>
                           <div class="col-md-6">
                              <input type="number" class="form-control col-sm-12" placeholder="Expense Amount" value="<?php echo $expenseamount; ?>" id="expenseamount" name="expenseamount" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="expensedate" class="col-sm-6 col-form-label"><b>Date</b></label>
                           <div class="col-md-6">
                              <input type="date" class="form-control col-sm-12" value="<?php echo $expensedate; ?>" name="expensedate" id="expensedate" required>
                           </div>
                        </div>

                        <div class="form-group row">
                           <label for="expensecategory" class="col-sm-6 col-form-label"><b>Expense Type</b></label>

                           <div class="col-md-6">
                              <select name="expensecategory" id="expensecategory" class="form-control col-sm-12 js-example-basic-single" required>
                                 <option value=""></option>
                                 
                                    <option value="মালিকের উত্তোলন">মালিকের উত্তোলন</option>
                        
                        <?php
                           $sql = "SELECT * FROM expense_category WHERE user_id='$userid' ";
                           $res = mysqli_query($con, $sql);
                           $count = mysqli_num_rows($res);

                           if ($count>0) {
                              while ($row=mysqli_fetch_assoc($res)) {
                                 $e_category_id = $row['e_category_id'];
                                 $e_category_name = $row['e_category_name'];
                                 ?>
                                    <option value="<?php echo $e_category_name; ?>" <?php if($e_category_name == $expensecategory){echo 'selected';} ?>><?php echo $e_category_name; ?></option>
                                      
                                 <?php
                              }
                           }else{
                              ?>
                                 <option disabled value="">Not Found(Please Add New)</option>
                              <?php
                           }

                        ?>    

                             </select>
                           </div>
                        </div>

                        <div class="form-group row">
                           <label for="expense_note" class="col-sm-6 col-form-label"><b>Expense Note</b></label>
                           <div class="col-md-6 speech">
                              <textarea class="form-control" id="transcript" placeholder="Expense Note/ভয়েস আইকনে ক্লিক করে বাংলায় বলুন" rows="4" name="expense_note" id="expense_note"><?php echo $expense_note; ?></textarea>
                              <img onclick="startDictation()" src="icon/voice_type.gif" />
                           </div>
                        </div>

                        <div class="form-group row">
                           <div class="col-md-12 text-right">
                              <?php if ($update == true) : ?>
                              <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                              <?php elseif ($del == true) : ?>
                              <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Delete</button>
                              <?php else : ?>
                              <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add Expense</button>
                              <?php endif ?>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="col-md-6">
                     <form action="" method="POST">
                        <div class="form-group row">
                           <label for="expensecategory" class="col-sm-6 col-form-label"><b>Make An Expenses Type</b></label>
                           <div class="col-md-6">
                              <input type="text" class="form-control col-sm-12" value="<?php //echo $expensecategory; ?>" placeholder="Enter Expenses Type" id="expensecategory" name="expensecategory" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-12 text-right">
                              <button type="submit" name="add_category" class="btn btn-lg btn-block btn-primary" style="border-radius: 0%;">Add Expenses Type</button>
                           </div>
                        </div>
                     </form>
                     <?php 
                        if (isset($_POST['add_category'])) {
                           $new_category = $_POST['expensecategory'];

                           $add_category_sql = "INSERT INTO expense_category (user_id, e_category_name) VALUES ('$userid', '$new_category')";
                      $result = mysqli_query($con, $add_category_sql) or die("Something Went Wrong!");
                      echo("<script>location.href='add_expense'</script>");
                        }
                     ?>

                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>All Expense Type</th>
                           </tr>
                        </thead>
                        <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                        <tr>
                           <td><?php echo $count;?></td>
                           <td><?php echo $row['e_category_name']; ?></td>
                        </tr>
                        <?php $count++; } ?>
                     </table>
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


         // In your Javascript (external .js resource or <script> tag)
         $(document).ready(function() {
             $('.js-example-basic-single').select2();
         });
      </script>
      <script>
         feather.replace();
      </script>


      <script>
         function startDictation() {
            if (window.hasOwnProperty('webkitSpeechRecognition')) {
               var recognition = new webkitSpeechRecognition();

               recognition.continuous = false;
               recognition.interimResults = false;

               recognition.lang = 'bn-US';
               recognition.start();

               recognition.onresult = function (e) {
               document.getElementById('transcript').value = e.results[0][0].transcript;
               recognition.stop();
               };

               recognition.onerror = function (e) {
               recognition.stop();
               };
            }
         }
      </script>
   </body>
</html>