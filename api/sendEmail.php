<?php
date_default_timezone_set('Africa/Lusaka');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

// get posted data
$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email; 
$subject = $data->subject;
$message = $data->message;

sendEmail($email, $name, $subject, $message);


 //FUNCTION TO SEND AN EMAIL
     function sendEmail($Client_email, $Client_name , $subjects, $msg){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
        //Server settings
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.mosesjasi.co';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'noreply@mosesjasi.co';                     //SMTP username
        $mail->Password   = '123@dmin#2022';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->Priority = 1;                          //Normal, 5 = low

        //Recipients
        $mail->setFrom('noreply@mosesjasi.co', 'Web Form');
        $mail->addAddress('info@mosesjasi.co', 'info');     //Add a recipient
        $mail->addReplyTo('noreply@mosesjasi.co', 'Web Form');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML

        $message = "<!doctype html>";
        $message .= "<!DOCTYPE html><html><body>";
        
        $message .= "<h1>Hi my name is : ". $Client_name  ."</h1>";
        $message .= "<p>I want to ask about : ". $subjects ."</p>";
        $message .= "<p>My message is as follows : ". $msg ."</p>";
        $message .= "<p>My email address is : ". $Client_email. "</p>";
        
        $message .= "</body>";
        $message .= "</html>";


        $mail->Subject = 'Website Form';
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
      }
      
      ?>