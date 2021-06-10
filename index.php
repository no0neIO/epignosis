<?php
require 'layout/header.php';
require_once './includes/dbhandler.inc.php';
require_once './includes/functions.inc.php';
if (isset($_SESSION["usersid"]))
    $usersId = $_SESSION["usersid"];
if (isset($_SESSION["name"]))
    $usersName = $_SESSION["name"];
?>

<?php
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "User") {
?>
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h1>Welcome, <?php echo $_SESSION["name"]; ?></h1>
                    <form action="./submit_request.php" method="post">
                        <button type="submit" class="btn btn-primary">
                            Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>

    <?php
        $requests = getRequests($conn, $usersId);
        echo '<div class="container">
                <div class="row">
                    <div class="col-xs-6">';

        echo "<h2>Past Requests:<h2>";
        echo "<ul class='requests'>";
        while ($request = mysqli_fetch_assoc($requests)) {
            $dateSubmitted = $request['submission_date'];
            $vacation_start = $request['date_from'];
            $vacation_end = $request['date_to'];
            $status = $request['stat'];
            $days_requested = daysRequested($vacation_start, $vacation_end);
            echo '<li>Date Submitted: ' . "$dateSubmitted" . '</li>';
            echo '<li>Dates requested: ' . "$vacation_start - $vacation_end" . '</li>';
            echo '<li>Days Requested: ' . "$days_requested" . '</li>';
            echo '<li>Status: ' . "$status" . '</li>';
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
                <h1>User Log in</h1>
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 'notuser') {
                        echo '<p class="alert alert-danger">You are not a User! Admin log in <a href="./admin.php">here</a> </p>';
                    } elseif ($_GET['error'] == 'wrongpass') {
                        echo '<p class="alert alert-danger">Wrong password!</p>';
                    } elseif ($_GET['error'] == 'wrongemail') {
                        echo '<p class="alert alert-danger">Wrong email!</p>';
                    }
                }
                ?>
                <form action="includes/login.user.inc.php" method="post">
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



<hr>

<?php require 'layout/footer.php'; ?>