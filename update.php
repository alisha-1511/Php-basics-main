<?php
include "update_action.php";

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
        <h3>Update Here!</h3>
        <hr>



        <form action="" method="post" enctype="multipart/form-data">
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
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Username</label>
                    <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Username"
                        value="<?php echo $username; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Email"
                        value="<?php echo $email; ?>">
                </div>
            </div>



            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCity">Country</label>
                    <select type="text" name="country" class="form-control" id="country">
                        <option value="">Select Country</option>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM countries");
                        while ($country = mysqli_fetch_assoc($q)) {
                            $selected = ($country['id'] == $selectedCountryName) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $country['id'] ?>" <?php echo $selected ?>><?php echo $country['country_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputCity">State</label>
                    <select type="text" name="state" class="form-control" id="state">
                        <option value="">Select State</option>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$selectedCountryName'");
                        while ($state = mysqli_fetch_assoc($q)) {
                            $selected = ($state['id'] == $selectedStateName) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $state['id'] ?>" <?php echo $selected ?>><?php echo $state['state'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="photoEdit">Upload image</label>
                <input type="file" name="photoEdit[]" class="form-control" id="photoEdit" multiple>
            </div>

            <!-- Display current photos -->
            <div class="container mb-3">
                <div class="current-photos">
                    <?php
                    foreach ($photos as $photoPath) {
                        echo '<img src="' . $photoPath . '" alt="User Photo" width="30" style="margin-right: 10px;">';
                    }
                    ?>
                </div>
            </div>



            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St"
                    value="<?php echo $address; ?>">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" name="city" class="form-control" id="inputCity" value="<?php echo $city; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label for="inputZip">Zip</label>
                    <input type="text" name="zip" class="form-control" id="inputZip" value="<?php echo $zip; ?>">
                </div>

            </div>

            <button type="submit" name="submit" class="btn btn-primary mb-5">Update</button>
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