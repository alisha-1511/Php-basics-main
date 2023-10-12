<?php
require_once "config.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('PHPMailer/Exception.php');
require('PHPMailer/SMTP.php');
require('PHPMailer/PHPMailer.php');

$error = false;
$wrong = false;
$password = false;

// print_r($_FILES["photo"]);


// echo "<img src='$folder' height='100px' width='100px'>" ;




$username = $photo = $email = $password = $confirm_password = $address = $city = $zip = $stmt = "";
$username_err = $photo_err = $email_err = $password_err = $confirm_password_err = $address_err = $city_err = $zip_err = "";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uploadedImages = [];
    //check if username is empty
    if (empty(trim($_POST['username']))) {
        $_SESSION['error_message'] = "Username cannot be blank";
    } else if (empty(trim($_POST['email']))) {
        $_SESSION['error_message'] = "Email cannot be blank";
    } else if (empty(trim($_POST['password']))) {
        $_SESSION['error_message'] = "Password cannot be blank";
    } else if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $_SESSION['error_message'] = "Passwords should match";
    } else if (empty(trim($_POST['country']))) {
        $_SESSION['error_message'] = "Please select Country";
    } else if (empty(trim($_POST['state']))) {
        $_SESSION['error_message'] = "Please select State";
    } else if (empty($_FILES['photo']['name'][0])) {
        $_SESSION['error_message'] = "Add atleast one photo";
    } else if (empty(trim($_POST['address']))) {
        $_SESSION['error_message'] = "Address cannot be blank";
    } else if (empty(trim($_POST['city']))) {
        $_SESSION['error_message'] = "City cannot be blank";
    } else if (empty(trim($_POST['zip']))) {
        $_SESSION['error_message'] = "Zip cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            //set the value to param username
            $param_username = trim($_POST['username']);
            //try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $_SESSION['error_message'] = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $password = trim($_POST['password']);
                    $country = trim($_POST['country']);
                    // if (isset($_POST['country'])) {
                    //     $country = $_POST['country'];
                    //     $query = "SELECT id FROM countries WHERE id = '$country'";
                    //     $q = mysqli_query($conn, $query);
                    //     if ($q) {
                    //         $row = mysqli_fetch_assoc($q);

                    //         if ($row) {
                    //             $countryName = $row['id'];
                    //         }


                    //     }
                    // }
                    $state = trim($_POST['state']);
                    $total = count($_FILES['photo']['name']);
                    // echo $total;
                    // exit;
                    for ($i = 0; $i < $total; $i++) {
                        $imageFileName = $_FILES['photo']['name'][$i];
                        $imageTmpName = $_FILES['photo']['tmp_name'][$i];
                        $targetPath = "images/" . basename($imageFileName);

                        if (move_uploaded_file($imageTmpName, $targetPath)) {
                            $uploadedImages[] = $targetPath;
                        }
                    }
                    
                    $imagesValue = implode(",", $uploadedImages);
                    $address = trim($_POST['address']);
                    $city = trim($_POST['city']);
                    $zip = trim($_POST['zip']);
                    $sql = "INSERT INTO users (username, email, password, country, state, photo, address, city, zip, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "sssssssss", $param_username, $param_email, $param_password, $param_country, $param_state, $param_photo_path, $param_address, $param_city, $param_zip);
                        //set these parameters
                        $param_username = $username;
                        $param_email = $email;
                        // $param_password = password_hash($password, PASSWORD_DEFAULT);
                        $param_password = md5($password);
                        $param_country = $country;
                        $param_state = $state;
                        $param_photo_path = $imagesValue;
                        $param_address = $address;
                        $param_city = $city;
                        $param_zip = $zip;

                        $mail = new PHPMailer(true);
                        //HTML content for the email body with user details
                        $email_body = '
                                    <html>
                                    <body>
                                        <p>Dear ' . $username . ',</p>
                                        <p>Thank you for registering with us. Here are your registration details:</p>
                                        <ul>
                                            <li><strong>Username:</strong> ' . $username . '</li>
                                            <li><strong>Email:</strong> ' . $email . '</li>
                                            <li><strong>Country:</strong> ' . $country . '</li>
                                            <li><strong>State:</strong> ' . $state . '</li>
                                            <li><strong>Address:</strong> ' . $address . '</li>
                                            <li><strong>City:</strong> ' . $city . '</li>
                                            <li><strong>ZIP Code:</strong> ' . $zip . '</li>
                                        </ul>
                                        <p>We will get back to you soon!</p>
                                        </body>
                                            </html>
                                        ';

                        // <p>Here are the uploaded photos:</p>';



                        // $uploadedImages = explode(",", $imagesValue);


                        // foreach ($uploadedImages as $imagePath) {
                        //     $email_body .= "<img src='" . $imagePath . "' alt='Uploaded Image' class='img-thumbnail rounded-circle mr-2 mb-2' width='25'><br />";
                        // }


                        // $email_body .= '
                        // </body>
                        //                 </html>
                        //             ';


                        try {
                            $mail->isSMTP(); //Send using SMTP
                            $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                            $mail->SMTPAuth = true; //Enable SMTP authentication
                            $mail->Username = 'alishaali1528@gmail.com'; //SMTP username
                            $mail->Password = 'awxbtpumxpewmdvj'; //SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
                            $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                            // PHPMailer::ENCRYPTION_SMTPS

                            //Recipients
                            $mail->setFrom('alishaali1528@gmail.com', 'Alisha Ali');
                            $mail->addAddress($email); //Add a recipient

                            //Attachments

                            //Content
                            $mail->isHTML(true); //Set email format to HTML
                            $mail->Subject = 'Testing PHPMailer';
                            $mail->Body = $email_body;
                            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                            $mail->send();

                            // echo 'Message has been sent';
                            // $_SESSION['error_message'] = 'Message has been sent';

                        } catch (Exception $e) {
                            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                            $_SESSION['error_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        // try to execute the query
                        if (mysqli_stmt_execute($stmt)) {
                            // header("location: login.php");
                            $_SESSION['success_message'] = "Registration Successfull!  Mail has been sent to you on your email address! Now you can login";

                        } else {
                            // echo "Something went wrong....Cannot Redirect!";
                            $_SESSION['error_message'] = "Something went wrong....Cannot Register!";
                            // $wrong = true;
                        }
                    }
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($conn);
            }
        }
    }
}

?>