<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

define('MAILGUN_USERNAME', 'postmaster@sandboxe5f476c30e234290bc9da37309b4f9e1.mailgun.org');
define('MAILGUN_PASSWORD', '8981103551864f4d71ee8701031a76ba-7bce17e5-2d5356fd');
define('FROM_EMAIL','brian@aquahound.co.za');
define('FROM_NAME','Aqua Hound');
//While testing, you set this to your email address, otherwize he is gonna get a bunch of $email_subject
//define('TO_EMAIL','uhururay@gmail.com');
//define('TO_NAME','Uhuru');
define('TO_EMAIL','brian@aquahound.co.za');
define('TO_NAME','Brian');

$mail = new PHPMailer(true);

$status = false;

try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = MAILGUN_USERNAME;                     // SMTP username
    $mail->Password   = MAILGUN_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addReplyTo(FROM_EMAIL, FROM_NAME);
    $mail->addAddress(TO_EMAIL, TO_NAME);     // Add a recipient

    $email_html = file_get_contents('email.html');
    if(strlen($_POST['need']) > 0){
        $email_subject = 'Aqua Hound - New Enquiry - ' . $_POST['need'];
    }
    else{
        $email_subject = 'Aqua Hound - New Enquiry';
    }
    $email_html = str_replace('[EMAIL-PREHEADER]',$email_subject,$email_html);
    $email_html = str_replace('[EMAIL-SUBJECT]',$email_subject,$email_html);
    $email_contents .= '<h2>New reply on your enquiry form</h2>';
    $email_contents .= '<p>Email: '.$_POST['email'].'<br />Name: '.$_POST['name'].' '.$_POST['surname'].'<br/>Requirement: '.$_POST['need'].'<br/>Message: '.$_POST['message'].'</p>';
    $email_html = str_replace('[EMAIL-CONTENTS]',$email_contents,$email_html);

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Body    = $email_html;
    $mail->AltBody = $email_html;
    $mail->Subject = $email_subject;
    $mail->send();
    $status = true;
} catch (Exception $e) {
    print_r($e);
}

$response = new stdClass();
if($status == true){
    $response->type =  'success';
    $response->message = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
}
else{
    $response->type =  'danger';
    $response->message = 'There was an error while submitting the form. Please try again later';
}
header('Content-Type: application/json');
echo json_encode($response);
exit(0);
?>
