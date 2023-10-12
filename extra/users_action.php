<?php

require_once "config.php";

// echo "<pre>"; print_r($_POST);
// exit;
$update = false;
$delete = false;
$wrong = false;
$error = false;

$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);
$usersData = mysqli_fetch_all($result, MYSQLI_ASSOC);

$username = $photo = $email = $password = $confirm_password = $address = $city = $zip = "";
$username_err = $photo_err = $email_err = $password_err = $confirm_password_err = $address_err = $city_err = $zip_err = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `users` WHERE `id` = $id";
    if (mysqli_query($conn, $sql)) {
        $delete = true;
    } else {
        $wrong = true;
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (isset($_POST['idEdit'])) {




        // update the record
        $id = $_POST["idEdit"];
        $username = $_POST["username"];
        $photo_path = $_FILES['photoEdit']['name'];
        $email = $_POST["emailEdit"];
        $address = $_POST["addressEdit"];
        $city = $_POST["cityEdit"];
        $zip = $_POST["zipEdit"];
        // check if username is empty
        if (empty(trim($_POST['username']))) {
            $username_err = "Username cannot be blank";
        } else {
            $sql = "SELECT id FROM users WHERE username = ? AND id != $id";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                //set the value to param username
                $param_username = trim($_POST['username']);

                //try to execute this statement
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken";
                        $error = true;
                    } else {
                        $username = trim($_POST['username']);
                    }
                } else {
                    // echo "Something went wrong";
                    $wrong = true;
                }
            }
        }
        mysqli_stmt_close($stmt);


        // // Update photo paths

        if ($_FILES['photoEdit']['name'][0] == '') {
            $param_photo_path = trim($_POST['old_image']);


        } else {
            foreach ($_FILES['photoEdit']['tmp_name'] as $key => $tmp_name) {
                $filename = $_FILES['photoEdit']['name'][$key];
                $tempname = $_FILES['photoEdit']['tmp_name'][$key];
                $folder = "images/" . $filename;
                move_uploaded_file($tempname, $folder);
                $newImagePaths[] = $folder;
            }

            $param_photo_path = implode(',', $newImagePaths);

        }
        // echo $param_photo_path;
        // exit;




        // Update address, city, and zip using null coalescing operator

        $photo_path = isset($_FILES['photo']['error']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK ? $param_photo_path : $param_photo_path;
        $username = isset($_POST['usernameEdit']) ? trim($_POST['usernameEdit']) : $username;
        $email = isset($_POST['emailEdit']) ? trim($_POST['emailEdit']) : $email;
        $address = isset($_POST['addressEdit']) ? trim($_POST['addressEdit']) : $address;
        $city = isset($_POST['cityEdit']) ? trim($_POST['cityEdit']) : $city;
        $zip = isset($_POST['zipEdit']) ? trim($_POST['zipEdit']) : $zip;





        // if there is no error, go ahead and update into the database
        if (empty($username_err) && empty($password_err) && empty($email_err) && empty($photo_err) && empty($confirm_password_err) && empty($address_err) && empty($city_err) && empty($zip_err)) {
            $sql = "UPDATE `users` SET username = ?, email = ?, photo = ?, address = ?, city = ?, zip = ? WHERE `users`.`id` = $id";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_email, $param_photo_path, $param_address, $param_city, $param_zip);
                //set these parameters
                $param_username = $username;
                $param_email = $email;
                $param_photo_path = $photo_path;
                // $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_address = $address;
                $param_city = $city;
                $param_zip = $zip;

                // try to execute the query
                if (mysqli_stmt_execute($stmt)) {
                    // echo "Updated Successfully!";
                    $update = true;
                } else {
                    // echo "Something went wrong....Cannot Update!";
                    $wrong = true;
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);

    }
    // else {

    //     if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    //         $photo_err = "Photo upload failed";
    //     } else {
    //         $filename = $_FILES['photo']['name'];
    //         $tempname = $_FILES["photo"]["tmp_name"];
    //         $folder = "images/" . $filename;
    //         $photo_path = $folder;
    //         move_uploaded_file($tempname, $folder);
    //         $param_photo_path = $photo_path;
    //     }

    //     // check if username is empty
    //     if (empty(trim($_POST['username']))) {
    //         $username_err = "Username cannot be blank";
    //     } else {
    //         $sql = "SELECT id FROM users WHERE username = ?";
    //         $stmt = mysqli_prepare($conn, $sql);
    //         if ($stmt) {
    //             mysqli_stmt_bind_param($stmt, "s", $param_username);

    //             //set the value to param username
    //             $param_username = trim($_POST['username']);

    //             //try to execute this statement
    //             if (mysqli_stmt_execute($stmt)) {
    //                 mysqli_stmt_store_result($stmt);
    //                 if (mysqli_stmt_num_rows($stmt) == 1) {
    //                     // $username_err = "This username is already taken";
    //                     $error = true;
    //                 } else {
    //                     $username = trim($_POST['username']);
    //                 }
    //             } else {
    //                 $wrong = true;
    //             }
    //         }
    //     }
    //     mysqli_stmt_close($stmt);

    //     // check for email
    //     if (empty(trim($_POST['email']))) {
    //         $email_err = "Email cannot be blank";
    //     } else {
    //         $email = trim($_POST['email']);
    //     }

    //     // // check for password
    //     // if (empty(trim($_POST['password']))) {
    //     //     $password_err = "Password cannot be blank";
    //     // } elseif (strlen(trim($_POST['password'])) < 5) {
    //     //     $password_err = "Password cannot be less than 5 characters";
    //     // } else {
    //     //     $password = trim($_POST['password']);
    //     // }

    //     // //check for confirm password field
    //     // if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
    //     //     $password_err = "Passwords should match";
    //     // }


    //     // Check for photo upload success
    //     if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    //         $photo_err = "Photo upload failed";
    //     } else {
    //         $photo = $_FILES['photo']['name'];
    //     }


    //     // Check for empty photo
    //     if (empty($photo)) {
    //         $photo_err = "Photo cannot be blank";
    //     } else {
    //         $photo_path = "images/" . $photo;
    //         move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    //     }

    //     // Check for address, city, and zip
    //     if (empty(trim($_POST['address']))) {
    //         $address_err = "Address cannot be blank";
    //     } else {
    //         $address = trim($_POST['address']);
    //     }
    //     if (empty(trim($_POST['city']))) {
    //         $city_err = "City cannot be blank";
    //     } else {
    //         $city = trim($_POST['city']);
    //     }
    //     if (empty(trim($_POST['zip']))) {
    //         $zip_err = "ZIP code cannot be blank";
    //     } else {
    //         $zip = trim($_POST['zip']);
    //     }

    //     // if there is no error, go ahead and insert into the database
    //     if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($photo_err) && empty($email_err) && empty($address_err) && empty($city_err) && empty($zip_err)) {
    //         $sql = "INSERT INTO users (username, email, password, photo, address, city, zip) VALUES (?, ?, ?, ?, ?,  ?, ?)";
    //         $stmt = mysqli_prepare($conn, $sql);
    //         if ($stmt) {
    //             mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_email, $param_password, $param_photo_path, $param_address, $param_city, $param_zip);
    //             //set these parameters
    //             $param_username = $username;
    //             $param_email = $email;
    //             $param_password = password_hash($password, PASSWORD_DEFAULT);
    //             $param_photo_path = $photo_path;
    //             $param_address = $address;
    //             $param_city = $city;
    //             $param_zip = $zip;

    //             // try to execute the query
    //             if (mysqli_stmt_execute($stmt)) {
    //                 header("location: login.php");
    //             } else {
    //                 // echo "Something went wrong....Cannot Redirect!";
    //                 $wrong = true;
    //             }
    //         }
    //         mysqli_stmt_close($stmt);
    //     }
    //     mysqli_close($conn);
    // }


}
?>