<?php
    header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET');
	header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Autorization, X-Requested-With');
    
    include "../config.php";

    $user_id = 0;
    if(isset($_REQUEST['user_id'])){
        $user_id = htmlentities(addslashes($_REQUEST['user_id']));
        $user_id = str_replace("/", "", $user_id);
    }

    $sql = "SELECT * FROM `incomes` WHERE `user_id` = $user_id";
    $runSql = mysqli_query($con, $sql);
    if($runSql && mysqli_num_rows($runSql) > 0){
        while ($myData = mysqli_fetch_assoc($runSql)) {
            $arr[] = $myData;
        }
    }else{
        $arr[] = ["message" => "No Data Found"];
    }
    
    echo json_encode($arr);

?>