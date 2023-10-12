<select type="text" name="state" class="form-control" id="state">
    <option value="">Select State</option>

<?php
include("config.php");

$cid = $_POST['counid'];
$q = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$cid' ");
while($state = mysqli_fetch_assoc($q))
{
    ?>
    <option value="<?php echo $state['id'] ?>"><?php echo $state['state'] ?></option>
    <?php
}

?>
</select>