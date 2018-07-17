<?php
// sample input
 // {"email": "", "mobile":"", "subject": "", "message":""}
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

include('classes/DBClass.php');

    $dbclass = new DBClass();
    $connection = $dbclass->getConnection();

	$data = json_decode(file_get_contents("php://input"));
	if($data == NULL) {
		$email   = $_POST['email'];
		$mobile  = $_POST['mobile'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
	} else {
		$email   = $data->email;
		$mobile  = $data->mobile;
		$subject = $data->subject;
		$message = $data->message;		
	}
	
	$query = "SELECT username FROM user_dealer WHERE email='" . $email . "' AND contact_number_mobile='".$mobile."'";
	$stmt = $connection->prepare($query);
	$stmt->execute();
	$count = $stmt->rowCount();
	if ($count) {
	  // To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		$headers[] = 'From: Info <info@mydomain.com>';

	  if(mail($email, $subject, $message, implode("\r\n", $headers))){
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