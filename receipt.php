<?php 
	include("session.php");
	include_once 'includes/nav.php';


    function convertNumber($num = false)
    {
        $num = str_replace(array(',', ''), '' , trim($num));
        if(! $num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : '' ) . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' and ' . $list1[$tens] . ' ' : '' );
            } elseif ($tens >= 20) {
                $tens = (int)($tens / 10);
                $tens = ' and ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        $words = implode(' ',  $words);
        $words = preg_replace('/^\s\b(and)/', '', $words );
        $words = trim($words);
        $words = ucfirst($words);
        $words = $words . ".";
        return $words;
    }
?>
    <div class="pb-2 text-center" id="message_section"></div>

    <div class="container">
        <div class="card" style="border-radius: 0px;">
            <div class="card-header bg-primary text-white">
                <h4 class="m-0 text-center">Money Receipt</h4>
            </div>
            <div class="card-body pt-4">
                <form class="form-vertical" id="addInvoice" name="addInvoice" enctype="multipart/form-data" method="POST" accept-charset="utf-8" novalidate="novalidate">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12" id="customer_section_1">
                                <div class="form-group row">
                                    <label for="customer_name" class="col-md-2 col-form-label">Customers <i class="text-danger">*</i></label>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="Customer Name" name="customer_name" class="form-control" require>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="customer_phone" id="InvCustomerPhone" class=" form-control" placeholder="Customer Phone No" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input placeholder="dd-mm-yyyy" min="2000-01-01" max="2040-12-31" class="form-control" required id="receiptDate" name="receipt_date">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-9 pt-2">
                                        <input type="text" name="customer_address" class=" form-control" placeholder="Customer Address">
                                    </div>
                                </div>                                
                            </div>
                        </div> 

                        <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalInvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center"> # <i class="text-danger">*</i></th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Taka </th>
                                        <th class="text-center">Action </th>
                                    </tr>
                                </thead>
                                <tbody id="addInvoiceItem">
                                    <tr id="invoiceItem1">
                                        <td class="text-center invoiceItem">1</td>
                                        <td>
                                            <input type="text" name="item_name[]" class="form-control" placeholder="Item Name">
                                        </td>
                                        <td style="width: 200px; min-width:auto;">
                                            <input type="text" name="item_price[]" class="form-control item_price" onkeyup="itemPrice()" placeholder="">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" name="rowRemove" data-row="invoiceItem1" class="btn btn-danger btn-sm rowRemove"><i class='bx bx-minus-circle'></i></button>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td style="text-align:right;" colspan="2"><b>Total:</b></td>
                                        <td class="text-right">
                                            
                                            <input id="totalTaka" class="form-control" name="total_taka" id="total_taka" value="0" readonly type="number">

                                            <input id="totalTakaHidden" class="form-control" name="total_taka_hidden" value="0" readonly type="hidden">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" colspan="3">
                                            <input id="add-item" class="btn btn-info" name="add-item" onclick="addNewRow();" value="Add New Item" tabindex="6" type="button">

                                            <input class="btn btn-success" name="receipt-submit" value="Submit" tabindex="9" type="submit">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php 
        if (isset($_POST['receipt-submit'])) {

            $itemCount = count($_POST['item_name']);
            $receipt_date = $_POST['receipt_date'];
            $customer_name = $_POST['customer_name'];
            $customer_phone = $_POST['customer_phone'];
            $customer_address = $_POST['customer_address'];
            $total_taka = $_POST['total_taka'];

            $new_receipt_id = $receipt_id + 1;

            mysqli_query($con, "UPDATE users SET receipt_id=$new_receipt_id WHERE user_id='$userid'");

    ?>
    <div id="printSection ">
        <div class="col-12 mx-auto print-area" style="width: 800px;">
            <div class="card p-0" style="border-radius: 0px;">
                <div class="card-header p-2 px-3" style="background-color: #c7c7c7; border-radius: 0px;">
                    <h5 class="float-left mb-0">Receipt &nbsp;</h5> ID : <?php echo "#".$receipt_id + 1 ?>
                    <div class="float-right"><?php echo $receipt_date ?></div>
                </div>
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="col-3 text-center">
                            <img src="<?php echo $userprofile ?>" style="height: 80px;">
                        </div>
                        <div class="col-5">
                            <h5><?php echo $username ?></h5>
                            <p class="m-0"><?php echo $phone_no ?></p>
                            <p class="m-0"><?php echo $address ?></p>
                            <p class="m-0"><?php echo $useremail ?></p>
                        </div>
                        <div class="col-4">
                            <h5 class="m-0">Customer:</h5>
                            <p class="m-0"><?php echo $customer_name ?> </p>
                            <p class="m-0">Phone: <?php echo $customer_phone ?></p>
                            <p class="m-0"><?php echo $customer_address ?></p>
                        </div>
                    </div>
                    
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Taka</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i=0; $i < $itemCount; $i++) {
                                    $item_name = $_POST['item_name'][$i];
                                    $item_price = $_POST['item_price'][$i];
                            ?>
                            <tr>
                                <td><?php echo $i+'1'; ?></td>
                                <td align="left">
                                    <?php echo $item_name;  ?>
                                </td>
                                <td><?php echo $item_price; ?></td>
                            </tr>	
                            <?php
                                }
                            ?> 
                            <tr>
                                <td class="text-right" colspan="2">Total : </td>
                                <td>
                                    <?php echo $total_taka ?>
                                </td>
                            </tr> 
                            <tr>
                                <td colspan="3" class="text-left" style="font-size: 18px;">
                                    In Word: <?php echo convertNumber($total_taka); ?>
                                </td>
                            </tr>                                                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <button  onclick="window.print();" class="btn btn-info btn-lg py-2" style="width: 150px;"><span class="btn-label"><i class='bx bx-printer'></i></span> Print Now</button>
    </div>
    <?php } ?>

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
         feather.replace();

        // var total_amount = document.getElementById("total_taka").select().val;
        // console.log(total_amount);
      </script>

      <script>

       // cal total
       function itemPrice(){
           totalTaka();
       }
        function totalTaka(){
            var elements = document.getElementsByClassName('item_price');
            var myLength = elements.length,
            total = 0;

            for (var i = 0; i < myLength; ++i) {
                total = total + +elements[i].value;
                //console.log(total);
            }

            $('#totalTaka').val(total);
            $('#totalTakaHidden').val(total);
        }
        totalTaka();

        // var xxxxxxx = totalTaka();
        // document.getElementById("print_total").innerHTML = xxxxxxx;


        // Add New Table Row in Invoice Table
        var rowCount = 1;
        function addNewRow(e){
            rowCount = rowCount + 1;

                //document.getElementsByClassName("rowId").innerHTML = rowCount;

                $("#addInvoiceItem").append('<tr id="invoiceItem' + rowCount + '"><td class="text-center"> '+ rowCount +' </td><td> <input type="text" name="item_name[]" class="form-control" placeholder="Description"> </td><td><input type="number" name="item_price[]" class="form-control item_price" onkeyup="itemPrice()" placeholder=""></td><td class="text-center"><button type="button" name="rowRemove" data-row="invoiceItem'+rowCount+'" class="btn btn-danger btn-sm rowRemove"><i class="bx bx-minus-circle"></i></button></td></tr>');
                productList('productItem' + rowCount);
        }


        // Remove row from invoice table
        $(document).on("click", ".rowRemove", function(a){
            a.preventDefault();
            var delete_row = $(this).data("row");
            //alert(delete_row);
            $('#' + delete_row).remove();

            totalTaka();
        });

      </script>
   </body>
</html>