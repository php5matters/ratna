<?php
include_once('../vendor/autoload.php');

function sendemail($email, $subject, $message) {
	######################## EMAIL CONFIGURATIONS STARTS ####################
	$smtpUsername = "";
	$smtpPassword = "";
	$smtpHost = 'smtp.gmail.com'; // For GMAIL
	$smtpPort = 587;

	$fromEmail = "php5matters@gmail.com";
	######################## EMAIL CONFIGURATIONS ENDS ####################

	// if(empty($smtpUsername) || empty($smtpPassword)) { return false; } // IF not configured no further logics
	
	######################################################################################
	// NOT TO BE CHANGED UNTIL REQUIRED
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	$mail->isSMTP();                  // Set mailer to use SMTP
	$mail->Host     = $smtpHost;      // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;           // Enable SMTP authentication
	$mail->Username = $smtpUsername;  // SMTP username
	$mail->Password = $smtpPassword;  // SMTP password
	$mail->SMTPSecure = 'tls';        // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $smtpPort;          // TCP port to connect to
	$mail->isHTML(true);             // Set email format to HTML
	$mail->SMTPDebug = 2;            // Enable verbose debug output
     #######################################################################################
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->setFrom($fromEmail);
    
   $recipients = explode(",", $email);
   

	foreach($recipients as $recipient) {
		$mail->AddAddress(trim($recipient));
	}

	try{
		$mail->send();
		return true;
	} catch (Exception $e) {
		return false;
	}
}