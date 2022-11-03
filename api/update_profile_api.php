<?php
	
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Autorization, X-Requested-With');

	$data = json_decode(file_get_contents("php://input"), true);

    // if (!array_key_exists("firstname",$data) || !array_key_exists("phone_no",$data)){
    //     echo json_encode(array('massage' => 'input all field', 'status' => false));
    //     die();
    // }
    // echo("this is");
    // print($data); die();

	$username =$data["firstname"];
    $phone_no = $data["phone_no"];
    $address =$data["address"];

	include "../config.php";

    $checkSql = "UPDATE `users` SET `firstname`='$username', `phone_no`='$phone_no', `address`='$address' WHERE `user_id` = '$user_id'";
    $res = mysqli_query($con, $checkSql);

    if ($res == TRUE) {
        echo json_encode(array('massage' => 'Updated Successful..!', 'status' => true));
    }else{
        echo json_encode(array('massage' => 'Sorry, Something Wrong..!', 'status' => false));
    }
    
    // if(mysqli_num_rows($res) == 0){
    //     $sql = "UPDATE `users` SET `firstname`='$username', `phone_no`='$phone_no', `address`='$address' WHERE `user_id` = '$user_id'";
    //     $result = mysqli_query($con, $sql);
    //     if ($result == TRUE) {
    //         echo json_encode(array('massage' => 'Updated Successful..!', 'status' => true));
    //     }else{
    //         echo json_encode(array('massage' => 'Sorry, Something Wrong..!', 'status' => false));
    //     }
    // }else{
    //     echo json_encode(array('massage' => 'Attention, You have already purchased this book.', 'status' => false));
    // }

?>