<?php

include("config/config.php");
include("../vendor/autoload.php");

if (isset($_REQUEST['adminusername']) && isset($_REQUEST['adminpassword'])) {
    $adminusername = $_REQUEST['adminusername'];
    $adminpassword = $_REQUEST['adminpassword'];
    
    // check for username password match in db
    $dbclass    = new DBClass();
    $connection = $dbclass->getConnection();
    $query      = "SELECT username, password FROM admin WHERE username='" . $adminusername . "'";
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['password'] == $adminpassword) {
            
            // Generate Token
            $tokenExpiry = time() + 60 * 60; // 1 hour
            
            try {
                $token = ReallySimpleJWT\Token::getToken($adminusername, $secret, $tokenExpiry, 'ratnaapi');
                echo json_encode(array(
                    'token' => $token,
                    'status' => 'success'
                ));
            }
            catch (\Exception $e) {
               // print_r($e);
                echo json_encode(array(
                    'status' => 'error'
                ));
            }
            
        } else {
            
            echo json_encode(array(
                'status' => 'error',
                'msg' => 'wrong username or password'
            ));
        }
    } else {
        
        echo json_encode(array(
            'status' => 'error',
            'msg' => 'wrong username or password'
        ));
    }
} else {
    echo json_encode(array(
        'status' => 'error',
        'msg' => 'invalid parameters passed'
    ));
}
