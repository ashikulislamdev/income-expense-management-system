<?php
   include("session.php");
   date_default_timezone_set('Asia/Dhaka');
   $update = false;
   $del = false;
   $incomeamount = "";
   $incomedate = date("Y-m-d");
   $incomecategory = "";
   $income_note = "";
   
   $inc_fetched = mysqli_query($con, "SELECT * FROM income_category WHERE user_id = '$userid'");


   if (isset($_POST['add'])) {
       $incomeamount = htmlentities(addslashes($_POST['incomeamount']));
       $incomedate = htmlentities(addslashes($_POST['incomedate']));
       $incomecategory = htmlentities(addslashes($_POST['incomecategory']));
       $income_note = htmlentities(addslashes($_POST['income_note']));
   
       $incomes = "INSERT INTO incomes (user_id, income,incomedate,incomecategory, income_note) VALUES ('$userid', '$incomeamount','$incomedate','$incomecategory','$income_note')";
       $result = mysqli_query($con, $incomes) or die("Something Went Wrong!");
       echo("<script>location.href='add_income'</script>");
   }

   if (isset($_POST['update'])) {
       $id = $_GET['edit'];
       $incomeamount = htmlentities(addslashes($_POST['incomeamount']));
       $incomedate = htmlentities(addslashes($_POST['incomedate']));
       $incomecategory = htmlentities(addslashes($_POST['incomecategory']));
       $income_note = htmlentities(addslashes($_POST['income_note']));
   
       $sql = "UPDATE incomes SET income='$incomeamount', incomedate='$incomedate', incomecategory='$incomecategory', income_note='$income_note' WHERE user_id='$userid' AND income_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: manage_income');
   }


   if (isset($_GET['edit'])) {
       $id = $_GET['edit'];
       $update = true;
       $record = mysqli_query($con, "SELECT * FROM incomes WHERE user_id='$userid' AND income_id=$id");
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $incomeamount = $n['income'];
           $incomedate = $n['incomedate'];
           $incomecategory = $n['incomecategory'];
           $income_note = $n['income_note'];

           //echo $incomecategory; die();
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }

   if (isset($_POST['delete'])) {
       $id = $_GET['delete'];
       $incomeamount = htmlentities(addslashes($_POST['incomeamount']));
       $incomedate = htmlentities(addslashes($_POST['incomedate']));
       $incomecategory = htmlentities(addslashes($_POST['incomecategory']));
       $income_note = htmlentities(addslashes($_POST['income_note']));
   
       $sql = "DELETE FROM incomes WHERE user_id='$userid' AND income_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: manage_income');
   }

   if (isset($_GET['delete'])) {
       $id = $_GET['delete'];
       $del = true;
       $record = mysqli_query($con, "SELECT * FROM incomes WHERE user_id='$userid' AND income_id=$id");
   
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $incomeamount = $n['income'];
           $incomedate = $n['incomedate'];
           $incomecategory = $n['incomecategory'];
           $income_note = $n['income_note'];
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }

?>
	  <?php 
        include_once 'includes/nav.php';
      ?>
            <div class="container">
               <h3 class="mt-4 text-center">Add Your Daily Income</h3>
               <hr>
               <div class="row ">
                  <div class="col-md-6" style="margin:0 auto;">
                     <form action="" method="POST">
                        <div class="form-group row">
                           <label for="incomeamount" class="col-sm-6 col-form-label"><b>Enter Amount(৳)</b></label>
                           <div class="col-md-6">
                              <input type="number" class="form-control col-sm-12" placeholder="Income Amount" value="<?php echo $incomeamount; ?>" id="incomeamount" name="incomeamount" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="incomecategory" class="col-sm-6 col-form-label"><b>Select Income Type</b></label>

                           <div class="col-md-6">
                              <select name="incomecategory" id="incomecategory" class="form-control col-sm-12 js-example-basic-single" required>
                              	<option value=""></option>
								
								<?php
									$sql = "SELECT * FROM income_category WHERE user_id='$userid' ";
									$res = mysqli_query($con, $sql);
									$count = mysqli_num_rows($res);

									if ($count>0) {
										while ($row=mysqli_fetch_assoc($res)) {
											$i_category_id = $row['i_category_id'];
											$i_category_name = $row['i_category_name'];
											?>
												<option value="<?php echo $i_category_name; ?>" <?php if($i_category_name == $incomecategory){echo 'selected';} ?>><?php echo $i_category_name; ?></option>
                                      
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
                           <label for="incomedate" class="col-sm-6 col-form-label"><b>Date</b></label>
                           <div class="col-md-6">
                              <input type="Date" class="form-control col-sm-12" value="<?php echo $incomedate; ?>" name="incomedate" id="incomedate" required>
                           </div>
                        </div>


                        <div class="form-group row">
                           <label for="income_note" class="col-sm-6 col-form-label"><b>Income Note</b></label>
                           <div class="col-md-6">
                              <textarea class="form-control col-sm-12" id="transcript" rows="4" placeholder="Income Note/ভয়েস আইকনে ক্লিক করে বাংলায় বলুন" name="income_note" id="income_note"><?php echo $income_note; ?></textarea>
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
                              <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add Income</button>
                              <?php endif ?>
                           </div>
                        </div>
                     </form>
                  </div>
 
                  <div class="col-md-6">
                  	<form action="" method="POST">
                        <div class="form-group row">
                           <label for="incomecategory" class="col-sm-6 col-form-label"><b>Make An Income Type</b></label>
                           <div class="col-md-6">
                              <input type="text" class="form-control col-sm-12" value="<?php //echo $incomecategory; ?>" placeholder="Enter Income Type" id="incomecategory" name="incomecategory" required>
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-md-12 text-right">
                              <button type="submit" name="add_category" class="btn btn-lg btn-block btn-primary" style="border-radius: 0%;">Add Income Type</button>
                           </div>
                        </div>
                     </form>
                     <?php 
                     	if (isset($_POST['add_category'])) {
                     		$new_category = $_POST['incomecategory'];

                     		$add_category_sql = "INSERT INTO income_category (user_id, i_category_name) VALUES ('$userid', '$new_category')";
					       $result = mysqli_query($con, $add_category_sql) or die("Something Went Wrong!");
					       echo("<script>location.href='add_income'</script>");
                     	}
                     ?>

                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>All Income Type</th>
                           </tr>
                        </thead>
                        <?php $count=1; while ($row = mysqli_fetch_array($inc_fetched)) { ?>
                        <tr>
                           <td><?php echo $count;?></td>
                           <td><?php echo $row['i_category_name']; ?></td>
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