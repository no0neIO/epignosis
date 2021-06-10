<?php
require 'layout/header.php';
require_once './includes/dbhandler.inc.php';
require_once './includes/functions.inc.php';
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
?>

        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h1>User Properties</h1>
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == 'emptyinput') {
                            echo '<p class="alert alert-danger">Fill in all fields!</p>';
                        } elseif ($_GET['error'] == 'emailexists') {
                            echo '<p class="alert alert-danger">Email exists!</p>';
                        } elseif ($_GET['error'] == 'invalidemail') {
                            echo '<p class="alert alert-danger">Invalid email!</p>';
                        } elseif ($_GET['error'] == 'pwdsdontmatch') {
                            echo '<p class="alert alert-danger">Passwords do not much!</p>';
                        } elseif ($_GET['error'] == 'none') {
                            echo '<p class="alert alert-success">You succesfully created a user!</p>';
                        } elseif ($_GET['error'] == 'stmtfailed') {
                            echo '<p class="alert alert-danger">Oops! There was an error. Try again later.</p>';
                        }
                    }
                    if (isset($_GET['email'])) {
                        $usersFirstName = $_GET['firstname'];
                        $usersLastName = $_GET['lastname'];
                        $usersEmail = $_GET['email'];
                        $usersType = $_GET['type'];
                    }

                    ?>
                    <form action="includes/update_user.inc.php" method="post">
                        <div class="form-group">
                            <label for="first-name" class="control-label">First Name</label>
                            <input type="text" name="first-name" id="first-name" class="form-control" value="<?php echo isset($usersFirstName) ? $usersFirstName : ''  ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="Last Name" class="control-label">Last Name</label>
                            <input type="text" name="last-name" id="last-name" class="form-control" required value="<?php echo isset($usersLastName) ? $usersLastName : ''  ?>">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control" required value="<?php echo isset($usersEmail) ? $usersEmail : ''  ?>">
                        </div>
                        <div class="form-group">
                            <label for="user-type" class="control-label">User-type</label>
                            <select id="user-type" name="user-type">
                                <option label="admin">Admin</option>
                                <option label="user">User</option>
                            </select>
                        </div>
                        <button name="submit" type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-user"></span>
                            Update User
                        </button>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
} else {
    echo "<h1>You don't have access on this page</h1>";
}
?>




<?php require 'layout/footer.php'; ?>