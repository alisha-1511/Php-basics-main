<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Php Login System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>

            <?php
            if (isset($_SESSION['loggedin'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user.php">Users</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php } ?>


        </ul>

        <?php
        if (isset($_SESSION['loggedin'])) {
            ?>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <!-- <img src="<?php echo $_SESSION['photo'] ?>" alt="User Photo" class="rounded-circle"
                                width="50" height="50"> -->
                            <?php echo "Welcome " . $_SESSION['username'] ?>
                        </a>
                    </li>
                </ul>
            </div>
        <?php } ?>
        
    </div>
</nav>