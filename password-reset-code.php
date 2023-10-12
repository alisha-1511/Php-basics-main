<?php
session_start();
include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/SMTP.php');
require('PHPMailer/PHPMailer.php');

function send_password_reset($get_name, $get_email, $tkn)
{
    $mail = new PHPMailer(true);
    //HTML content for the email body with user details
    $email_body = '
   <html>
   <body>
       <h2>Hello</h2>
       <h3>You are receiving this email because we received a password reset request for your account.</h3>
       <br>
       <a href="http://localhost/login/password-change.php?token=' . $tkn . '&email=' . $get_email . '">Click me</a>
   </body>
   </html>
';


    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = 'alishaali1528@gmail.com'; //SMTP username
    $mail->Password = 'awxbtpumxpewmdvj'; //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
    $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    // PHPMailer::ENCRYPTION_SMTPS

    //Recipients
    $mail->setFrom('alishaali1528@gmail.com', 'Heyy');
    $mail->addAddress($get_email); //Add a recipient

    //Attachments

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Password reset Notification';
    $mail->Body = $email_body;

    try {
        $mail->send();
        $_SESSION['success_message'] = 'Message has been sent';
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}





if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $tkn = md5(rand());

    $check_email = "SELECT email FROM users WHERE email = '$email' LIMIT 1 ";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['username'];
        $get_email = $row['email'];

        $update_tkn = "UPDATE users SET token = '$tkn' WHERE email = '$get_email' LIMIT 1 ";
        $update_tkn_run = mysqli_query($conn, $update_tkn);

        if ($update_tkn_run) {
            send_password_reset($get_name, $get_email, $tkn);
            $_SESSION['success_message'] = "We e-mailed you a password reset link";
            header("location: password-reset.php");
            exit(0);

        } else {
            $_SESSION['error_message'] = "Something went wrong. #1: " . mysqli_error($conn);
            header("location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['error_message'] = "No email found";
        header("location: password-reset.php");
        exit(0);
    }
}



if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {

            //Checking token is valid or not
            $check_token = "SELECT token FROM users WHERE token='$token' LIMIT 1 ";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $new_password = md5($new_password);
                    $update_password = "UPDATE users SET password='$new_password' WHERE token='$token' LIMIT 1 ";
                    $update_password_run = mysqli_query($conn, $update_password);

                    if ($update_password_run) {
                        $new_token = md5(rand()) . "funda";
                        $update_to_new_token = "UPDATE users SET token='$new_token' WHERE token='$token' LIMIT 1 ";
                        $update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        // echo "Password updated successfully";
                        $_SESSION['success_message'] = "Password updated successfully";
                        header("location: login.php");
                        exit(0);

                    } else {
                        $_SESSION['error_message'] = "Unable to update password";
                        header("location: password-change.php?token=$token&email=$email");
                        exit(0);
                    }

                } else {
                    // echo "Passwords does not match";
                    $_SESSION['error_message'] = "Passwords do not match";
                    header("location: password-change.php?token=$token&email=$email");
                    exit(0);
                }

            } else {
                $_SESSION['error_message'] = "Invalid token";
                header("location: password-change.php?token=$token&email=$email");
                exit(0);
            }

        } else {
            $_SESSION['error_message'] = "All fields are mandatory";
            header("location: password-change.php?token=$token&email=$email");
            exit(0);
        }

    } else {
        $_SESSION['error_message'] = "No token available";
        header("location: password-change.php");
        exit(0);
    }
}

?>