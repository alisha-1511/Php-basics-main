<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>php Login form</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Php Login System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>

            </ul>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <?php echo "Welcome " . $_SESSION['username'] ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h3>
            <?php echo "Welcome " . $_SESSION['username'] ?>! You can now use this website
        </h3>
        <hr>
        <h5>Here you can UPDATE your current data!</h5>

        <!-- <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <?php echo "Address: " . $_SESSION['address']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "City: " . $_SESSION['city']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "Zip: " . $_SESSION['zip']; ?>
            </li>
        </ul> -->
        <?php
        if(isset($_SESSION['edit'])){
            $_SESSION['address'] = $address;
            $_SESSION['city'] = $city;
            $_SESSION['zip'] = $zip;
        }
        ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" name="address" class="form-control" id="inputAddress"
                    value="<?php echo $_SESSION['address']; ?>">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" name="city" class="form-control" id="inputCity"
                        value="<?php echo $_SESSION['city']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" name="zip" class="form-control" id="inputZip"
                        value="<?php echo $_SESSION['zip']; ?>">
                </div>
            </div>


    </div>
    <div class="container mt-4">
        <!-- <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>  -->
        <a href="edit.php"><button name="edit" class='edit btn btn-sm btn-primary'>Edit</button> </a>

    </div>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>










<!-- 
//if ($_SERVER['REQUEST_METHOD'] == "POST") {

//     // $filename = $_FILES["photo"]["name"];
//     // $tempname = $_FILES["photo"]["tmp_name"];
//     // $folder = "images/" . $filename;
//     // $photo_path = $folder;
//     // move_uploaded_file($tempname, $folder);


//     // check if username is empty
//     if (empty(trim($_POST['username']))) {
//         // $username_err = "Username cannot be blank";
//         $_SESSION['error_message'] = "Username cannot be blank";
//         // header("location:register.php");
//         // exit(0);
//     }
// else if (empty(trim($_POST['email']))) {
//     $_SESSION['error_message'] = "Email cannot be blank";
// } else if (empty(trim($_POST['password']))) {
//     $_SESSION['error_message'] = "Password cannot be blank";
// }else if (empty(trim($_POST['address']))) {
//     $_SESSION['error_message'] = "Address cannot be blank";
// }else if (empty(trim($_POST['city']))) {
//     $_SESSION['error_message'] = "City cannot be blank";
// }else if (empty(trim($_POST['zip']))) {
//     $_SESSION['error_message'] = "Zip cannot be blank";
// }
//     else {
// $sql = "SELECT id FROM users WHERE username = ?";
// $stmt = mysqli_prepare($conn, $sql);
//         if ($stmt) {
//             mysqli_stmt_bind_param($stmt, "s", $param_username);

//             //set the value to param username
//             $param_username = trim($_POST['username']);

// //try to execute this statement
// if (mysqli_stmt_execute($stmt)) {
//     mysqli_stmt_store_result($stmt);
//     if (mysqli_stmt_num_rows($stmt) == 1) {
//         $username_err = "This username is already taken";
//         // $error = true;
//         $_SESSION['error_message'] = "This username is already taken";
//     } else {
//         $username = trim($_POST['username']);
//                     if (empty(trim($_POST['email']))) {
//                         $email_err = "Email cannot be blank";
//                         $_SESSION['error_message'] = "Email cannot be blank";
//                         }else if (empty(trim($_POST['password']))) {
//                             $password_err = "Password error";
//                             $_SESSION['error_message'] = "Password cannot be blank";
//                         }
//                         // else if (strlen(trim($_POST['password'])) < 5) {
//                         //     $password_err = "Password error";
//                         //     $_SESSION['error_message'] = "Password cannot be less than 5 characters";
//                         // }
//                         else if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
//                             $password_err = "Passwords should match";
//                             // $password = true;
//                             $_SESSION['error_message'] = "Passwords should match";
//                         }else if (empty(trim($_POST['address']))) {
//                             $address_err = "Address cannot be blank";
//                             $_SESSION['error_message'] = "Address cannot be blank";
//                         }else if (empty(trim($_POST['city']))) {
//                             $city_err = "City cannot be blank";
//                             $_SESSION['error_message'] = "City cannot be blank";
//                         }else if (empty(trim($_POST['zip']))) {
//                             $zip_err = "ZIP code cannot be blank";
//                             $_SESSION['error_message'] = "Address cannot be blank";
//                         }else if (empty($_FILES['photo']['name'][0])) {
//                             $_SESSION['error_message'] = "Add atleast one photo";
//                         }
//                     else {
//                         $password = trim($_POST['password']);
//                     }

//                     // check for password
//                     // if (empty(trim($_POST['password']))) {
//                     //     $_SESSION['error_message'] = "Password cannot be blank";
//                     // } elseif (strlen(trim($_POST['password'])) < 5) {
//                     //     $_SESSION['error_message'] = "Password cannot be less than 5 characters";
//                     // } else {
//                     //     $password = trim($_POST['password']);
//                     // }

//                     //check for confirm password field
//                     // if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
//                     //     $password_err = "Passwords should match";
//                     //     // $password = true;
//                     //     $_SESSION['error_message'] = "Passwords should match";
//                     // }

//                     // // Check for photo upload success
//                     // if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
//                     //     $photo_err = "Photo upload failed";
//                     // } else {
//                     //     $photo = $_FILES['photo']['name'];
//                     // }


//                     // // Check for empty photo
//                     // if (empty($photo)) {
//                     //     $photo_err = "Photo cannot be blank";
//                     // } else {
//                     //     $photo_path = "images/" . $photo;
//                     //     move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
//                     // }

//                     // Handle multiple image uploads
//                     $uploadedImages = [];
//                     if (!empty($_FILES['photo']['name'][0])) {
//                         $total = count($_FILES['photo']['name']);
//                         // echo $total;
//                         // exit;
//                         for ($i = 0; $i < $total; $i++) {
//                             $imageFileName = $_FILES['photo']['name'][$i];
//                             $imageTmpName = $_FILES['photo']['tmp_name'][$i];
//                             $targetPath = "images/" . basename($imageFileName);

//                             if (move_uploaded_file($imageTmpName, $targetPath)) {
//                                 $uploadedImages[] = $targetPath;
//                             }
//                         }
//                     }else{
//                         $_SESSION['error_message'] = "Add atleast one photo";
//                     }
//                     $imagesValue = implode(",", $uploadedImages);


//                     // Check for address, city, and zip
//                     // if (empty(trim($_POST['address']))) {
//                     //     $address_err = "Address cannot be blank";
//                     //     $_SESSION['error_message'] = "Address cannot be blank";
//                     // } else {
//                     //     $address = trim($_POST['address']);
//                     // }
//                     // if (empty(trim($_POST['city']))) {
//                     //     $city_err = "City cannot be blank";
//                     //     $_SESSION['error_message'] = "City cannot be blank";
//                     // } else {
//                     //     $city = trim($_POST['city']);
//                     // }
//                     // if (empty(trim($_POST['zip']))) {
//                     //     $zip_err = "ZIP code cannot be blank";
//                     //     $_SESSION['error_message'] = "Address cannot be blank";
//                     // } else {
//                     //     $zip = trim($_POST['zip']);
//                     // }

//                     // if there is no error, go ahead and insert into the database

//                     if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($photo_err) && empty($email_err) && empty($address_err) && empty($city_err) && empty($zip_err)) {
//                         $sql = "INSERT INTO users (username, email, password, photo, address, city, zip, status) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
//                         $stmt = mysqli_prepare($conn, $sql);
//                         if ($stmt) {
//                             mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_email, $param_password, $param_photo_path, $param_address, $param_city, $param_zip);
//                             //set these parameters
//                             $param_username = $username;
//                             $param_email = $email;
//                             // $param_password = password_hash($password, PASSWORD_DEFAULT);
//                             $param_password = md5($password);
//                             $param_photo_path = $imagesValue;
//                             $param_address = $address;
//                             $param_city = $city;
//                             $param_zip = $zip;

//                             $mail = new PHPMailer(true);
//                             //HTML content for the email body with user details
//                             $email_body = '
//                                     <html>
//                                     <body>
//                                         <p>Dear ' . $username . ',</p>
//                                         <p>Thank you for registering with us. Here are your registration details:</p>
//                                         <ul>
//                                             <li><strong>Username:</strong> ' . $username . '</li>
//                                             <li><strong>Email:</strong> ' . $email . '</li>
//                                             <li><strong>Address:</strong> ' . $address . '</li>
//                                             <li><strong>City:</strong> ' . $city . '</li>
//                                             <li><strong>ZIP Code:</strong> ' . $zip . '</li>
//                                         </ul>
//                                         <p>We will get back to you soon!</p>

//                             <p>Here are the uploaded photos:</p>';



//                             $uploadedImages = explode(",", $imagesValue);


//                             foreach ($uploadedImages as $imagePath) {
//                                 $email_body .= "<img src='" . $imagePath . "' alt='Uploaded Image' class='img-thumbnail rounded-circle mr-2 mb-2' width='25'><br />";
//                             }


//                             $email_body .= '
//                             </body>
//                                             </html>
//                                         ';


//                             try {
//                                 $mail->isSMTP(); //Send using SMTP
//                                 $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
//                                 $mail->SMTPAuth = true; //Enable SMTP authentication
//                                 $mail->Username = 'alishaali1528@gmail.com'; //SMTP username
//                                 $mail->Password = 'awxbtpumxpewmdvj'; //SMTP password
//                                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
//                                 $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//                                 // PHPMailer::ENCRYPTION_SMTPS

//                                 //Recipients
//                                 $mail->setFrom('alishaali1528@gmail.com', 'Alisha Ali');
//                                 $mail->addAddress($email); //Add a recipient

//                                 //Attachments

//                                 //Content
//                                 $mail->isHTML(true); //Set email format to HTML
//                                 $mail->Subject = 'Testing PHPMailer';
//                                 $mail->Body = $email_body;
//                                 $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//                                 $mail->send();

//                                 echo 'Message has been sent';
//                                // echo ' <script>alert("Message has been sent");</script> ';

//                             } catch (Exception $e) {
//                                 // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//                                 echo ' <script>alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");</script> ';
//                             }

//                             // try to execute the query
//                             if (mysqli_stmt_execute($stmt)) {
//                                 header("location: login.php");

//                             } else {
//                                 // echo "Something went wrong....Cannot Redirect!";
//                                 $wrong = true;
//                             }
//                         }
//                         mysqli_stmt_close($stmt);
//                     }
//                     mysqli_close($conn);
//                 }
//             } else {
//                 // echo "Something went wrong";
//                 $wrong = true;
//             }
//         }
//         mysqli_stmt_close($stmt);
//     }

//     // for email

// }
 -->