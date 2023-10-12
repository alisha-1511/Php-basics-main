<?php
include("config.php");
session_start();

$id = $_GET['updateid'];
$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$username = $row['username'];
$email = $row['email'];
$selectedCountryName = $row['country'];
$selectedStateName = $row['state'];
$photos = explode(',', $row['photo']);
// $photo = $row['photo'];
$address = $row['address'];
$city = $row['city'];
$zip = $row['zip'];

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $selectedCountryName = $_POST['country'];

    $query = "SELECT country_name FROM countries WHERE id = '$selectedCountryName'";
    $q = mysqli_query($conn, $query);
    if ($q) {
        $row = mysqli_fetch_assoc($q);
        if ($row) {
            $countryName = $row['country_name'];
        }
    }

    $selectedStateName = $_POST['state'];

    if ($_FILES['photoEdit']['name'][0] == '') {
        $param_photo_paths = $photos;


    } else {
        foreach ($_FILES['photoEdit']['tmp_name'] as $key => $tmp_name) {
            $filename = $_FILES['photoEdit']['name'][$key];
            $tempname = $_FILES['photoEdit']['tmp_name'][$key];
            $folder = "images/" . $filename;
            move_uploaded_file($tempname, $folder);
            $newImagePaths[] = $folder;
        }
        $param_photo_paths = $newImagePaths;

    }
    $photo_path = implode(',', $param_photo_paths);
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];

    $sql = "UPDATE users SET id='$id', username='$username', email='$email',country='$selectedCountryName', state='$selectedStateName', photo='$photo_path', address='$address', city='$city', zip='$zip' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // echo "updated";
        $_SESSION['success_message'] = "Updated Successfully!";
        header("location: user.php");
    } else {
        echo "error";
    }
}

?>