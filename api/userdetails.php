<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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

  $stmt = $user->read();
  $count = $stmt->rowCount();

  if($count > 0){

      $userdetails = array();
      $userdetails["records"]   = array();
      $userdetails["count"]  = $count;

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

          extract($row);

          $p  = array(
                "username"	=> $username,
                "icnumber"	=> $icnumber,
                "firstName" => $firstname,
                "lastName" 	=> $lastname,
                "phone" 		=> $phone,
                "address1" 	=> $address1,
                "address2" 	=> $address2,
                "address3" 	=> $address3,
                "postcode" 	=> $postcode,
                "city" 		  => $city,
                "state" 		=> $state,
                "country" 	=> $country,
                "email" 		=> $email,
                "gender" 		=> $gender,
                "dob"			  => $dob,
                "race" 		  => $race,
                "parentcode"  => $parentcode,
                "created_at"  => $createdat,
          );

          array_push($userdetails["records"], $p);
      }

      echo json_encode($userdetails);
  }
  else {

      echo json_encode( 
          array("records" => array(), "count" => 0)
      );
  } 
} 
} catch(\Exception $e){
  echo json_encode(array(
        'status' => 'error',
        'msg' => 'invalid token passed'
    ));

}