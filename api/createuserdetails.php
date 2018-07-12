<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../vendor/autoload.php");
include('config/config.php');
include('classes/User.php');
// validate token
$token = $_REQUEST['token'];
try{
$result = ReallySimpleJWT\Token::validate($token, $secret);
if($result) {

	$dbclass = new DBClass();
	$connection = $dbclass->getConnection();

	$user = new User($connection);

	$data = json_decode(file_get_contents("php://input"));

	$user->username 	= $data->username;
	$user->price 		= $data->price;
	$user->description 	= $data->description;
	$user->category_id 	= $data->category_id;
	$user->created 		= date('Y-m-d H:i:s'); 

	if($user->create()){
	    echo '{';
	        echo '"message": "User was created successfully."';
	    echo '}';
	}
	else{
	    echo '{';
	        echo '"message": "Unable to create user."';
	    echo '}';
	}
} 
} catch (\Exception $e) {
   echo json_encode(array(
        'status' => 'error',
        'msg' => 'invalid token passed'
    ));
}