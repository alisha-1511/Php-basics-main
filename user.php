<?php include("config.php");

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM users where id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $_SESSION['success_message'] = "Deleted Successfully!";
        header("location:user.php");
    } else {
        $_SESSION['error_message'] = "Cannot Delete!";
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

    <a href="adduser.php"><button type="button" class="btn btn-primary my-5 ml-5">Add User</button></a>

    <div class="container">

        
    </div>


    <div class="table-container ml-5 mr-5 mt-5">
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Address</th>
                    <th scope="col">City</th>
                    <th scope="col">Zip</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT u.id, u.username, u.email, c.country_name AS country, s.state AS state, u.photo, u.address, u.city, u.zip 
                FROM users u
                INNER JOIN countries c ON u.country = c.id
                INNER JOIN states s ON u.state = s.id ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $username = $row['username'];
                        $email = $row['email'];
                        $country = $row['country'];
                        $state = $row['state'];
                        $photos = explode(',', $row['photo']);
                        $address = $row['address'];
                        $city = $row['city'];
                        $zip = $row['zip'];
                        echo '<tr>
                <th scope="row">' . $id . '</th>
                <td>' . $username . '</td>
                <td>' . $email . '</td>
                <td>' . $country . '</td>
                <td>' . $state . '</td>
                <td>';
                        foreach ($photos as $photoPath) {
                            echo '<img src="' . $photoPath . '" height="20" width="20" alt="User Photo">&nbsp;';
                        }
                        echo '</td>
                <td>' . $address . '</td>
                <td>' . $city . '</td>
                <td>' . $zip . '</td>
                <td>
                <a href="update.php?updateid=' . $id . '"><button type="button" class="btn btn-primary">Edit</button></a>
                <a href="?deleteid=' . $id . '"><button type="button" class="btn btn-danger">Delete</button></a>
                </td>
              </tr>';
                    }
                }
                ?>
            </tbody>
        </table>
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