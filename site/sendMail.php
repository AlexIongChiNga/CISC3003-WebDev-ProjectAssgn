<?php
/*
 * This script is called from form submission in registration.php by GET method
 */

require "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../vendor/phpmailer/phpmailer/src/Exception.php";
require "../vendor/phpmailer/phpmailer/src/SMTP.php";

class Mail
{
    private $mail;
    function __construct()
    {

        //Create an instance; passing `true` enables exceptions
        $this->mail = new PHPMailer(true);

        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
            $this->mail->isSMTP(); //Send using SMTP
            $this->mail->Host = "smtp.mailersend.net"; //Set the SMTP server to send through
            $this->mail->SMTPAuth = true; //Enable SMTP authentication
            $this->mail->Username =
                "MS_AQxpiR@test-nrw7gymmy6og2k8e.mlsender.net"; //SMTP username
            $this->mail->Password = "mssp.PW1k75j.3z0vklovedvg7qrx.7AAIrXU"; //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $this->mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $this->mail->setFrom(
                "MS_AQxpiR@test-nrw7gymmy6og2k8e.mlsender.net"
            );
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    /**
     * Sends an email.
     *
     * @param string $email The recipient's email address.
     * @param string $subject The subject of the message.
     * @param string $body The content of the email.
     * @param string $altBody The alt text of the email.
     * @return void
     */
    function sendMessage($email, $subject, $body, $altBody): void
    {
        try {
            //Recipients
            $this->mail->addAddress($email); //Add a recipient

            //Content
            $this->mail->isHTML(true); //Set email format to HTML
            $this->mail->Subject = $subject;

            $this->mail->Body = $body;
            $this->mail->AltBody = $altBody;

            $this->mail->send();
            echo "Message has been sent";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    /**
     * Sends a verification email after user registration.
     *
     * @param string $email The recipient's email address.
     * @param int $user_id The unique user identifier.
     * @param bool $debug debug information
     * @return void
     */
    function sendRegisterEmail($email, $user_id, $debug = false): void
    {
        $subject = "Verification of email";
        $address =
            "http://localhost" .
            substr(
                realpath("validation.php"),
                strlen($_SERVER["SERVER_NAME"])
            ) .
            "?id=" .
            $user_id;

        $body =
            '
<html>
<head>
<meta charset="UTF-8">
<title>Email Verification</title>
<style>
body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
.container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; text-align: center; }
.button { display: inline-block; background-color: #007bff; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; }
.footer { margin-top: 20px; font-size: 12px; color: #777; }
</style>
</head>
<body>
<div class="container">
<h2>Email Verification</h2>
<p>Thank you for signing up! Please click the button below to verify your email address.</p>
<a href="' .
            $address .
            '" class="button">Verify Email</a>
<p class="footer">If you did not request this email, please ignore it.</p>
</div>
</body>
</html>
';
        $altBody =
            "Thank you for signing up! Click this link to verify your email: " .
            $address;
        $this->sendMessage($email, $subject, $body, $altBody);
        echo $address . '\n' . $email;
        if ($debug) {
        include "connection.php";
        $con->query("DELETE FROM `users` WHERE username = 'asdf'");
        die("Test ends here");
        }
    }

/**
 * Sends a verification email after user registration.
 *
 * @param string $email The recipient's email address.
 * @param int $user_id The unique user identifier.
 * @param bool $debug debug information
 * @return void
 */
    function sendForgetPasswordEmail($email, $user_id, $debug = false): void
    {   
        $path = realpath("forgetPassword.php");
        $path = str_replace('htdocs\\','/',$path);
        $path = str_replace('\\','/',$path);
        $subject = "Change password";
        $reset_link =
            "http://localhost" .
            substr(
                $path,
                strlen($_SERVER["SERVER_NAME"])
            ) .
            "?id=" .
            $user_id;

        $body = '
<html>
<head>
<meta charset="UTF-8">
<title>Password Reset Request</title>
<style>
body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
.container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 5px; text-align: center; }
.button { display: inline-block; background-color: #dc3545; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; }
.footer { margin-top: 20px; font-size: 12px; color: #777; }
</style>
</head>
<body>
<div class="container">
<h2>Password Reset Request</h2>
<p>We received a request to reset your password. Click the button below to proceed:</p>
<a href="' . $reset_link . '" class="button">Reset Password</a>
<p class="footer">If you did not request this reset, please ignore this email or contact support.</p>
</div>
</body>
</html>
        ';

        $altBody = "We received a request to reset your password. Click this link to proceed: " . $reset_link;

        $this->sendMessage($email, $subject, $body, $altBody);
        echo $reset_link . '<br>' . $email;
        if ($debug) {
        include "connection.php";
        $con->query("DELETE FROM `users` WHERE username = 'asdf'");
        die("Test ends here");
        }
    }

}
