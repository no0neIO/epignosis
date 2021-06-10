<?php
require 'layout/header.php';
require_once './includes/dbhandler.inc.php';
require_once './includes/functions.inc.php';
?>

<?php
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
?>
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h1>Welcome, <?php echo $_SESSION["name"]; ?></h1>
                    <form action="./create_user.php" method="post">
                        <button type="submit" class="btn btn-primary">
                            Create User
                        </button>
                    </form>
                </div>
            </div>
        </div>

    <?php
        $users = getUsers($conn);
        echo '<div class="container">
                <div class="row">
                    <div class="col-xs-6">';

        echo "<h2>Users:<h2>";
        echo "<ul class='users'>";
        while ($user = mysqli_fetch_assoc($users)) {
            $usersFirstName = $user['usersFirstName'];
            $usersLastName = $user['usersLastName'];
            $usersFullName = $usersFirstName . ' ' . $usersLastName;
            $usersEmail = $user['usersEmail'];
            $usersType = $user['usersType'];
            echo '<li><a href = "./user_properties.php?email=' . $usersEmail . '&firstname=' . $usersFirstName . '&lastname=' . $usersLastName . '&type=' . $usersType . '  ">Full Name: ' . $usersFullName . " - Email: " . $usersEmail . " - Users Type: " . $usersType . '</a></li>';
            echo "<hr>";
        }
        echo "</ul>";

        echo '  </div>
            </div>
        </div>';
    }
} else {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h1>Admin Log in</h1>
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'notadmin') {
                        echo '<p class="alert alert-danger">You are not an Admin! User log in <a href="./">here</a> </p>';
                    } elseif ($_GET['error'] == 'wrongpass') {
                        echo '<p class="alert alert-danger">Wrong password!</p>';
                    } elseif ($_GET['error'] == 'wrongemail') {
                        echo '<p class="alert alert-danger">Wrong email!</p>';
                    }
                }
                ?>
                <form action="includes/login.inc.php" method="post">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">
                        Log in
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php
}
?>


<?php require 'layout/footer.php'; ?>