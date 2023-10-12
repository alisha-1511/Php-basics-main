<?php
include("config.php");

require_once('plugin/php-excel-reader/excel_reader2.php');
require_once('plugin/SpreadsheetReader.php');

if(isset($_POST["import"])){
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if(in_array($_FILES["file"]["type"],$allowedFileType)){
        // is uploaded file
        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        //end is uploaded file

        $Reader = new SpreadsheetReader($targetPath);

        $sheetCount = count($Reader->sheets());
        for($i=0; $i<$sheetCount; $i++){
            $Reader->ChangeSheet(($i));

            foreach($Reader as $Row){
                $username = "";
                if(isset($Row[0])){
                    $username = mysqli_real_escape_string($conn, $Row[0]);
                }
                $email = "";
                if(isset($Row[1])){
                    $email = mysqli_real_escape_string($conn, $Row[1]);
                }
                $token = "";
                if(isset($Row[2])){
                    $token = mysqli_real_escape_string($conn, $Row[2]);
                }
                $password = "";
                if(isset($Row[3])){
                    $password = md5(mysqli_real_escape_string($conn, $Row[3]));
                }
                $country = "";
                if(isset($Row[4])){
                    $country = mysqli_real_escape_string($conn, $Row[4]);
                }
                $state = "";
                if(isset($Row[5])){
                    $state = mysqli_real_escape_string($conn, $Row[5]);
                }
                $photo = "";
                if(isset($Row[6])){
                    $photo = mysqli_real_escape_string($conn, $Row[6]);
                }
                $address = "";
                if(isset($Row[7])){
                    $address = mysqli_real_escape_string($conn, $Row[7]);
                }
                $city = "";
                if(isset($Row[8])){
                    $city = mysqli_real_escape_string($conn, $Row[8]);
                }
                $zip = "";
                if(isset($Row[9])){
                    $zip = mysqli_real_escape_string($conn, $Row[9]);
                }
                

                if (!empty($username)) {
                    $existingUserQuery = "SELECT * FROM users WHERE username = '".$username."'";
                    $existingUserResult = mysqli_query($conn, $existingUserQuery);
                
                    if (mysqli_num_rows($existingUserResult) > 0) {
                        // Username already exists, update the existing record
                        $updateQuery = "UPDATE users SET email = '".$email."', password = '".$password."', country = '".$country."', state = '".$state."', address = '".$address."', city = '".$city."', zip = '".$zip."' WHERE username = '".$username."'";
                        $result = mysqli_query($conn, $updateQuery);
                        
                        if ($result) {
                            $_SESSION['success_message'] = "User data updated";
                            header("location: user.php");
                        } else {
                            $_SESSION['error_message'] = "Problem updating user data";
                        }
                    } else {
                        // Username doesn't exist, insert a new record
                        $insertQuery = "INSERT INTO users(username, email, password, country, state, address, city, zip) VALUES ('".$username."', '".$email."', '".$password."', '".$country."', '".$state."', '".$address."', '".$city."', '".$zip."')";
                        $result = mysqli_query($conn, $insertQuery);
                        
                        if ($result) {
                            $_SESSION['success_message'] = "New user data inserted";
                            header("location: user.php");
                        } else {
                            $_SESSION['error_message'] = "Problem inserting new user data";
                        }
                    }
                }
                
            }
        }
    }
    else{
        $_SESSION['error_message'] = "Invalid file type";
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
        <h3>Add User Here!</h3>
        <hr>

        <!-- success message -->
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

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="photo">Import</label>
                <input type="file" name="file" class="form-control" accept=".xls,.xlsx">
            </div>
             <button type="submit" name="import" class="btn btn-primary mb-5">Import</button>
        </form>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script src="ajax_function.js"></script>


</body>

</html>