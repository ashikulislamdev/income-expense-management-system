<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

?>
      <?php 
        include_once 'includes/nav.php';
      ?>

            <div class="container">
                <div class="justify-content-center">
                   <p>
                        <a href="http://rsdev.xyz/" rel="dofollow" target="_blank">RS-DEV</a> is a software development company based in Satkania Chattogram, Bangladesh. <br>
                        In addition to our flagship products – IEMS(Income Expense Management System), <a href="http://rsdev.xyz/" rel="dofollow" target="_blank">RS-Dev</a> also has over half-dozen software products in the market. With over 10,000 customers and over 3 years of proven technology expertise, QLC is working on a number of product ideas.
                   </p>
                   <h6>
                       Contact Us
                   </h6>
                   <p>
                        We are always ready to help you! <br>
                        Already using our solutions and experiencing technical issues? <br>
                        Reach out to +880 1609103475 or email (rsgroup150@gmail.com) us for support.
                   </p>
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