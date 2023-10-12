<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include("config.php");

    if (isset($_POST['op']) && isset($_POST['np']) && isset($_POST['cnp'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $op = validate($_POST['op']);
        $np = validate($_POST['np']);
        $cnp = validate($_POST['cnp']);

        // Debugging: Check if form data is received
        echo "Old Password: $op<br>";
        echo "New Password: $np<br>";
        echo "Confirm Password: $cnp<br>";

        if (empty($op)) {
            $_SESSION['error_message'] = "Old Password is required";
            header("location:chng-pswrd.php");
            exit();
        } else if (empty($np)) {
            $_SESSION['error_message'] = "New Password is required";
            header("location:chng-pswrd.php");
            exit();
        } else if ($np !== $cnp) {
            $_SESSION['error_message'] = "Passwords do not match";
            header("location:chng-pswrd.php");
            exit();
        } else {
            $op = md5($op);
            $np = md5($np);
            $id = $_SESSION['id'];

            // Debugging: Check hashed passwords
            // echo "Old Password Hash: $op<br>";
            // echo "New Password Hash: $np<br>";

            $sql = "SELECT password FROM users WHERE id='$id' AND password='$op' ";
            $result = mysqli_query($conn, $sql);

            // if (!$result) {
            //     die('Query Error: ' . mysqli_error($conn));
            // }

            if (mysqli_num_rows($result) === 1) {
                $sqll = "UPDATE users SET password='$np' WHERE id='$id'";
                mysqli_query($conn, $sqll);
                

                // Debugging: Check if the update query executed correctly
                if (mysqli_affected_rows($conn) > 0) {
                    $_SESSION['success_message'] = "Password changed successfully";
                    header("location:chng-pswrd.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Password update failed";
                    header("location:chng-pswrd.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Incorrect password";
                header("location:chng-pswrd.php");
                exit();
            }
        }
    } else {
        header("location:chng-pswrd.php");
        exit();
    }
} else {
    header("location:login.php");
    exit();
}
?>
