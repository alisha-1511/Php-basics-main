<?php

session_start();




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
    
    <?php  include("includes/nav.php"); ?>
    </div>

    <div class="container mt-4">
        <div class="card">
            <h5 class="card-header">Enter Your New Password</h5>
            <div class="card-body">

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

                <form action="password-reset-code.php" method="post">
                    <input type="hidden" name="password_token"
                        value="<?php if (isset($_GET['token'])) {
                            echo $_GET['token'];
                        } ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email"
                            value="<?php if (isset($_GET['email'])) {
                                echo $_GET['email'];
                            } ?>" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter email" readonly>

                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="inputPassword4">New Password</label>
                            <input type="password" class="form-control" name="new_password" id="inputPassword4"
                                placeholder="Enter New Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" id="inputPassword"
                                placeholder="Confirm Password">
                        </div>

                    </div>
                    <button type="submit" name="password_update" class="btn btn-success">Update Password</button>
                </form>
            </div>
        </div>
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