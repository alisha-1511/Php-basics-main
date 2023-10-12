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


    <?php include("includes/nav.php"); ?>

    <div class="container mt-4">
        <h3>
            <?php echo "Welcome " . $_SESSION['username'] ?>! You can now use this website
        </h3>
        <hr>
        <h5>Here is your current data!</h5>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <?php echo "Address: " . $_SESSION['address']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "City: " . $_SESSION['city']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "Zip: " . $_SESSION['zip']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "Email: " . $_SESSION['email']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "Country: " . $_SESSION['countryName']; ?>
            </li>
            <li class="nav-item active">
                <?php echo "State: " . $_SESSION['state']; ?>
            </li>
        </ul>
        <h5>Your Uploaded Images:</h5>

        <?php
        $imagePaths = explode(",", $_SESSION['photo']);
        foreach ($imagePaths as $imagePath) {
            echo "<img src='$imagePath' alt='Uploaded Image' class='img-thumbnail rounded-circle mr-2 mb-2' width='150'>";
        }
        ?>


        <a href="chng-pswrd.php"><button type="submit" class="btn btn-danger ml-5">Change Password</button></a>


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