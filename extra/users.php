<?php
include "users_action.php";
// include "config.php";

$id = 0;



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
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <title>php Login form</title>
</head>

<body>
    <!--Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditModal">
  Edit modal
</button> -->

    <!--Edit Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">


                        <input type="hidden" name="idEdit" id="idEdit" value="<?php echo $id; ?>">



                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Username</label>
                                <input type="text" class="form-control" name="username" id="nameEdit"
                                    placeholder="Username" value="<?php echo $username; ?>">
                            </div>

                        </div>

                        <input type="hidden" id="photoEdit" name="old_image">

                        <div class="form-group">
                            <label for="inputAddress">Email</label>
                            <input type="email" name="emailEdit" class="form-control" id="emailEdit"
                                value="<?php echo $email; ?>">
                        </div>

                        


                        <div class="form-group">
                            <label for="photo">Upload/Change Image</label>
                            <input type="file" name="photoEdit[]" class="form-control" multiple>
                        </div>
                        <!-- <div id="existingImages">
                            <?php
                            // foreach ($imagePaths as $imagePath) {
                            //     echo '<img src="' . $imagePath . '" height="50" width="50" />&nbsp;';
                            // }
                            ?>
                        </div> -->
                        <div id="oldImageDiv"></div>



                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" name="addressEdit" class="form-control" id="addressEdit"
                                value="<?php echo $address; ?>">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <input type="text" name="cityEdit" class="form-control" id="cityEdit"
                                    value="<?php echo $city; ?>">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="inputZip">Zip</label>
                                <input type="text" name="zipEdit" class="form-control" id="zipEdit"
                                    value="<?php echo $zip; ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update changes</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <?php include("includes/nav.php"); ?>


    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Updated Successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    ?>
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Deleted Successfully
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";

        $delete = false;
    }
    ?>
    <?php
    if ($error) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> This username is already taken
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    ?>
    <?php
    if ($wrong) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Something went wrong
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    ?>
    <div class="container mt-4">
        <h3>Here is USERS list!!</h3>
        <hr>
        <div class="container" my-10>

            <table class="table" id="myTable">
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
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                        <th style="display:none">Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersData as $row): ?>
                        <tr>
                            <th scope='row'>
                                <?php echo $row['id']; ?>
                            </th>
                            <td>
                                <?php echo $row['username']; ?>
                            </td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['country']; ?>
                            </td>
                            <td>
                                <?php echo $row['state']; ?>
                            </td>
                            <!-- <td>
                                <img src="<?php echo $row['photo']; ?>" height='50' width='50'>
                            </td> -->
                            <td>
                                <?php
                                $imagePaths = explode(',', $row['photo']);
                                foreach ($imagePaths as $imagePath) {
                                    echo "<img src='$imagePath' height='20' width='20'>&nbsp;";
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $row['address']; ?>
                            </td>
                            <td>
                                <?php echo $row['city']; ?>
                            </td>
                            <td>
                                <?php echo $row['zip']; ?>
                            </td>
                            <td>
                                <?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?>
                            </td>

                            <td>
                                <button class='edit btn btn-sm btn-primary' id="<?php echo $row['id']; ?>"
                                    data-photos="<?php echo $row['photo']; ?>">Edit</button>
                                <button class='delete btn btn-sm btn-primary'
                                    id="<?php echo 'd' . $row['id']; ?>">Delete</button>
                            </td>
                            <td style="display:none">
                                <?php echo $row['photo']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>



                </tbody>
            </table>
        </div>
        <hr>

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
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

    <script>

        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach(element => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                username = tr.getElementsByTagName("td")[0].innerText;
                email = tr.getElementsByTagName("td")[1].innerText;
                country = tr.getElementsByTagName("td")[2].innerText;
                state = tr.getElementsByTagName("td")[3].innerText;
                // photo = tr.getElementsByTagName("td")[7].innerText;

                photo = e.target.getAttribute('data-photos');
                address = tr.getElementsByTagName("td")[5].innerText;
                city = tr.getElementsByTagName("td")[6].innerText;
                zip = tr.getElementsByTagName("td")[7].innerText;
                nameEdit.value = username;
                emailEdit.value = email;


                // document.getElementById('oldImageDiv').innerHTML = '<img height="50" width="50" src="' + photo + '">'

                var photoUrls = photo.split(',');
                var imageHTML = '';
                for (var i = 0; i < photoUrls.length; i++) {
                    imageHTML += '<img class="mr-2" height="20" width="20" src="' + photoUrls[i] + '">';
                }
                document.getElementById('oldImageDiv').innerHTML = imageHTML;


                addressEdit.value = address;
                cityEdit.value = city;
                zipEdit.value = zip;
                idEdit.value = e.target.id;
                $('#EditModal').modal('toggle');
            });
        });

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach(element => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                id = e.target.id.substring(1);

                if (confirm("Are you sure you want to delete the user!")) {
                    window.location.href = 'users.php?delete=' + id;
                }

            });
        });
    </script>
</body>

</html>