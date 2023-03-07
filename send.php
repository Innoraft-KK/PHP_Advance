<?php
/**
    * PHP script for sending an email using PHPMailer library and Gmail SMTP server.
    * This script loads the necessary classes from the PHPMailer and Dotenv libraries
    * using Composer's autoloader. It then uses environment variables to retrieve the
    * Gmail account email address and password for SMTP authentication. The script
    * takes input from an HTML form via the POST method and sends an email with the
    * input email address as the recipient.
    * @uses PHPMailer\PHPMailer\PHPMailer
    * @uses PHPMailer\PHPMailer\SMTP
    * @uses PHPMailer\PHPMailer\Exception
    * @uses Dotenv\Dotenv
    * @link https://github.com/PHPMailer/PHPMailer
    * @link https://github.com/vlucas/phpdotenv
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
//Load Composer's autoloader
require 'vendor/autoload.php';
$mail = new PHPMailer(true);

try {

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'yourmail@email.com';                     //SMTP username
    $mail->Password   = 'key' ;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('yourmail@email.com');
    $mail->addAddress($_POST['email']);               //Name is optional
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Form Submission';
    $mail->Body    = '<b>Thank you for your submission</b>';
    $mail->send();
    echo '<br><b>Message has been sent</b>';
} catch (Exception $e) {
    echo '<br> <br>';
    if(isset($_POST["submit"]))
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>