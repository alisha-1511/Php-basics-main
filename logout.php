<!-- <?php

// session_start();
// $_SESSION = array();
// session_destroy();
// header("location: login.php");

?> -->

<?php
session_start();
require_once "config.php";

if (isset($_SESSION["loggedin"])) {
    // Get the user's ID
    $user_id = $_SESSION["id"];

    // Update the user's status to 0
    $sql_update_status = "UPDATE users SET status = 0 WHERE id = ?";
    $stmt_update_status = mysqli_prepare($conn, $sql_update_status);
    
    mysqli_stmt_bind_param($stmt_update_status, "i", $user_id);

    if (mysqli_stmt_execute($stmt_update_status)) {
        // Update successful
        $_SESSION = array();
        session_destroy();
        header("location: login.php");
        exit;
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

header("location: login.php");
?>



