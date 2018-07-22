<?php
// sample input
 // {"email": "", "mobile":"", "subject": "", "message":""}
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

include('classes/DBClass.php');
include('classes/Mailer.php');

    $dbclass = new DBClass();
    $connection = $dbclass->getConnection();

	$data = json_decode(file_get_contents("php://input"));
	if($data == NULL) {
		$email   = $_POST['customeremail'];
		$mobile  = $_POST['customeremobile'];
	} else {
		$email   = $data->customeremail;
		$mobile  = $data->customeremobile;
	}
	
	$subject = "ForgotPassword, ".$email.", ".$mobile;
	$message = "ForgotPassword, ".$email.", ".$mobile;
	$toEmail = "gopay.admin@tunetalk.com";

	$query = "SELECT * FROM user_dealer WHERE email='" . $email . "' AND phonenumber='".$mobile."'";
	$stmt = $connection->prepare($query);
	$stmt->execute();
	$count = $stmt->rowCount();
	if ($count) {

	  if(sendemail($toEmail, $subject, $message)){
			echo '{';
				echo '"message": "Email sent successfully.", "status": 1';
			echo '}';
		}
		else{
			echo '{';
				echo '"message": "Unable to send email.", "status": 0';
			echo '}';
		}
	} else {		
		 echo '{';
	        echo '"message": "Wrong email or mobile", "status": 0';
	    echo '}';
	}