<?php
$error = false;
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);



//check if user is already logged in
// if (isset($_SESSION['username'])) {
//     header("location: welcome.php");
//     exit();
// }

require_once "config.php";

$username = $email = $photo = $password = $address = "";
$err = "";



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $_SESSION['error_message'] = "Both fields are required";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $sql = "SELECT id, username, email, country, state, photo, password, address, city, zip FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        // try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $email, $countryName, $state, $photo, $hashed_password, $address, $city, $zip);
                if (mysqli_stmt_fetch($stmt)) {
                    if (md5($password) == $hashed_password) {
                        // Password is correct

                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = $email;
                        $_SESSION["countryName"] = $countryName;
                        $_SESSION["state"] = $state;
                        $_SESSION["photo"] = $photo;
                        $_SESSION["address"] = $address;
                        $_SESSION["city"] = $city;
                        $_SESSION["zip"] = $zip;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        // Set user's status to 1
                        $sql_update_status = "UPDATE users SET status = 1 WHERE id = ?";
                        $stmt_update_status = mysqli_prepare($conn, $sql_update_status);
                        mysqli_stmt_bind_param($stmt_update_status, "i", $id);
                        mysqli_stmt_execute($stmt_update_status);
                        mysqli_stmt_close($stmt_update_status);

                        // Redirect to the welcome page
                        header("location: welcome.php");
                    } else {
                        // Password is incorrect
                        // $_SESSION['error_message'] = md5($password);
                        $_SESSION['error_message'] = 'Password is incorrect';
                        // $_SESSION['success_message'] = md5($hashed_password);
                    }
                }
            } else {
                // Username does not exist
                $_SESSION['error_message'] = "Username does not exist";
            }
        }
    }
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
    <?php include("includes/nav.php"); ?>



    <div class="container mt-4">
        <h3>Please Login Here!</h3>
        <hr>

        <!-- Display success message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- error message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" name="username" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Enter Username">

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <a href="password-reset.php" class="float-end">Forgot your password?</a>
        </form>
    </div>

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