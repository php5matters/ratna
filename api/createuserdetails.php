<?php
// sample data
//{"username":"test2","icnumber":"123456","firstname":"test2name","lastname":"test2ast","phone":"1111111111","address1":"address1line","address2":"address2line","address3":"address3line","postcode":"200000","city":"Delhi","state":"Delhi","country":"India","email":"anyone@gmail.com","gender":"M","dob":"1991-05-05","race":"black","parentcode":"2345"}
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
	//print_r($data); exit;
	$user->username     =   (($data->username));
    $user->icnumber     =   (($data->icnumber));
    $user->firstname    =   (($data->firstname));
    $user->lastname     =   (($data->lastname));
    $user->phone        =   (($data->phone));
    $user->address1     =   (($data->address1));
    $user->address2     =   (($data->address2));
    $user->address3     =   (($data->address3));
    $user->postcode     =   (($data->postcode));
    $user->city         =   (($data->city));
    $user->state        =   (($data->state));
    $user->country      =   (($data->country));
    $user->email        =   (($data->email));
    $user->gender       =   (($data->gender));
    $user->dob          =   (($data->dob));
    $user->race         =   (($data->race));
    $user->parentcode   =   (($data->parentcode));
	$user->createdat 		=   date('Y-m-d H:i:s'); 

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