<?php
	
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Autorization, X-Requested-With');

	$data = json_decode(file_get_contents("php://input"), true);

    if (!array_key_exists("email",$data) || !array_key_exists("password",$data)){
        echo json_encode(array('massage' => 'input all field', 'status' => false));
        die();
    }

	$email = htmlentities(addslashes($data['email']));
	$get_password = htmlentities(addslashes($data['password']));
    $password = md5($get_password);
    //$auth = md5(sha1($email . $password));

	include "../config.php";

    if(($email != '') && ($get_password != '')){

        $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($con, $sql) or die("SQL Query Failed!");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $userId=$row["user_id"];
            $username =$row["firstname"];
            $phone_no = $row["phone_no"];
            $useremail=$row["email"];
            $password=md5($row["password"]);
            $address=$row["address"];
            $userprofile="uploads/".$row["profile_path"];
            $user_type=$row["status"];
            $receipt_id=$row["receipt_id"];

                echo json_encode(array(
                    'massage' => 'login successfully..!', 
                    'userId' => $userId,
                    'username' => $username,
                    'phone_no' => $phone_no,
                    'email' => $useremail,
                    'password' => $password,
                    'address' => $address,
                    'userprofile' => $userprofile,
                    'user_type' => $user_type,
                    'receipt_id' => $receipt_id,
                    'status' => true));
            
        }else{
            echo json_encode(array('massage' => 'email or password is invalid', 'status' => false));
        }
    }else{
        echo json_encode(array('massage' => 'Attention, All field are required..!', 'status' => false));
    }

?>