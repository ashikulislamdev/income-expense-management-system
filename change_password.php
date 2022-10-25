<?php
    include("session.php");
    $exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

?>
      <?php 
        include_once 'includes/nav.php';
      ?>

            <div class="container-fluid">
                <h5>Hi <?php echo $username ?>! You can change your password here</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <form class="form" action="" method="POST" id="registrationForm" autocomplete="off">
                            <div class="form-group">
                                <div class="col">
                                    <label for="password">
                                        Enter Current Password
                                    </label>
                                    <input type="password" class="form-control" name="curr_password" id="curr_password" placeholder="Current Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col">
                                    <label for="password">
                                        Enter New Password
                                    </label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col">
                                    <label for="password2">
                                        Confirm New Password
                                    </label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-block btn-primary" name="updatepassword" type="submit">Update Password</button>
                                </div>
                            </div>
                        </form>
                        <!--/tab-content-->
                <?php 
                    if(isset($_POST['updatepassword'])){
                    //echo "Batton Clicked";
                    $curr_password = md5($_POST['curr_password']);
                    $new_password = md5($_POST['new_password']);
                    $confirm_password = md5($_POST['confirm_password']);

                    //check execute query
                    $sql = "SELECT * FROM users WHERE user_id ='$userid' AND password='$curr_password'";

                    $res = mysqli_query($con, $sql);

                    if ($res==true) {
                    $count = mysqli_num_rows($res);

                        if ($count==1) {
                            if ($new_password==$confirm_password) {
                                //password updated
                                $sql2 = "UPDATE users SET password='$new_password' WHERE user_id='$userid' ";

                                //execute the query
                                $res2 = mysqli_query($con, $sql2);

                                if ($res2==true) {
                                    printf("<script>location.href='profile.php'</script>");
                                }else{
                                    echo "Password Doesn't updated";
                                }

                            }else{
                                echo "Password didn't metch";
                            }

                        }else{
                            echo "User Not found";
                        }
                    }
          
                    }
                ?>
                    </div>
                    <!--/col-9-->
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

</body>

</html>