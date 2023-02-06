<?php
   include("session.php");
   date_default_timezone_set('Asia/Dhaka');
   $update = false;
   $del = false;
   $note_title = "";
   // $incomedate = date("Y-m-d");
   // $incomecategory = "";
   $note_desc = "";
   
   $note_fetched = mysqli_query($con, "SELECT * FROM needed_note WHERE user_id = '$userid'");


   if (isset($_POST['add'])) {
       $note_title = htmlentities(addslashes($_POST['note_title']));
       $note_desc = htmlentities(addslashes($_POST['note_desc']));
   
       $notes = "INSERT INTO needed_note (user_id, note_title, note_desc) VALUES ('$userid', '$note_title','$note_desc')";
       $result = mysqli_query($con, $notes) or die("Something Went Wrong!");
       echo("<script>location.href='my_notes'</script>");
   }

   if (isset($_POST['update'])) {
       $id = $_GET['edit'];
       $note_title = htmlentities(addslashes($_POST['note_title']));
       $note_desc = htmlentities(addslashes($_POST['note_desc']));
   
       $sql = "UPDATE needed_note SET note_title='$note_title', note_desc='$note_desc' WHERE user_id='$userid' AND note_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: my_notes');
   }


   if (isset($_GET['edit'])) {
       $id = $_GET['edit'];
       $update = true;
       $record = mysqli_query($con, "SELECT * FROM needed_note WHERE user_id='$userid' AND note_id=$id");
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $note_title = $n['note_title'];
           $note_desc = $n['note_desc'];

           //echo $incomecategory; die();
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }

   if (isset($_POST['delete'])) {
       $id = $_GET['delete'];
       $note_title = htmlentities(addslashes($_POST['note_title']));
       $note_desc = htmlentities(addslashes($_POST['note_desc']));
   
       $sql = "DELETE FROM needed_note WHERE user_id='$userid' AND note_id='$id'";
       if (mysqli_query($con, $sql)) {
           echo "Records were updated successfully.";
       } else {
           echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
       }
       header('location: my_notes');
   }

   if (isset($_GET['delete'])) {
       $id = $_GET['delete'];
       $del = true;
       $record = mysqli_query($con, "SELECT * FROM needed_note WHERE user_id='$userid' AND note_id=$id");
   
       if (mysqli_num_rows($record) == 1) {
           $n = mysqli_fetch_array($record);
           $note_title = $n['note_title'];
           $note_desc = $n['note_desc'];
       } else {
           echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
       }
   }

?>
	  <?php 
        include_once 'includes/nav.php';
      ?>
            <div class="container">
               <h3 class="mt-4 text-center">Needed Notes</h3>
               <div id="note_alert" class="alert alert-success alert-dismissible fade show" role="alert">
                 বকেয়া তালিকা কিংবা পরবর্তীতে প্রয়োজন হবে এমন গুরুত্বপূর্ণ নোট লিখে রাখতে পারেন! <strong>ধন্যবাদ!</strong> 
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <hr>
               <div class="row "> 
                  <div class="col-12">
                  	<form action="" method="POST">
                        <div class="form-group row">
                           <label for="note_title" class="col-sm-3 col-form-label"><b>Enter Title</b></label>
                           <div class="col-md-9">
                              <input type="text" class="form-control col-sm-12" placeholder="Note Title" value="<?php echo $note_title; ?>" id="note_title" name="note_title" required>
                           </div>
                        </div>
                        
                        <div class="form-group row">
                           <label for="note_desc" class="col-sm-3 col-form-label"><b>Enter Note Description</b></label>
                           <div class="col-md-9">
                              <textarea class="form-control col-sm-12" id="transcript" rows="4" placeholder="Enter Note Description" name="note_desc" id="note_desc"><?php echo $note_desc; ?></textarea>
                           </div>
                        </div>

                        <div class="form-group row">
                           <div class="col-md-12 text-right">
                              <?php if ($update == true) : ?>
                              <button class="btn btn-lg btn-block btn-warning" style="border-radius: 0%;" type="submit" name="update">Update</button>
                              <?php elseif ($del == true) : ?>
                              <button class="btn btn-lg btn-block btn-danger" style="border-radius: 0%;" type="submit" name="delete">Delete</button>
                              <?php else : ?>
                              <button type="submit" name="add" class="btn btn-lg btn-block btn-success" style="border-radius: 0%;">Add Notes</button>
                              <?php endif ?>
                           </div>
                        </div>
                     </form>

                     <br>
                     <h5 class='text-center text-danger'>All notes</h5>
                     <table class="table table-hover table-bordered">
                        <thead>
                           <tr class="text-center">
                              <th>#</th>
                              <th>Title</th>
                              <th>Description</th>
                              <th colspan="2">Action</th>
                           </tr>
                        </thead>
                        <tbody id="dataTable">
                           <?php $count=mysqli_num_rows($note_fetched); while ($row = mysqli_fetch_array($note_fetched)) { ?>

                           <tr>
                              <td><?php echo $count--;?></td>
                              <td><?php echo $row['note_title']; ?></td>
                              <td><?php echo $row['note_desc']; ?></td>
                              <td class="text-center">
                                 <a href="my_notes?edit=<?php echo $row['note_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
                              </td>
                              <td class="text-center">
                                 <a href="my_notes?delete=<?php echo $row['note_id']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
                              </td>
                           </tr>

                           <?php } ?>
                        </tbody>
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


         //modal popup closing automatically after few seconds
         // $(document).ready(function() {
         //     $('#note_alert').dialog({
         //       open:function(){
         //          setTimeout(function(){
         //             $('#note_alert').dialog('close');
         //          }, 3000);
         //       }
         //     });
         // });

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