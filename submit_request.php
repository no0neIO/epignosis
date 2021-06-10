<?php require 'layout/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>Submit a Request</h1>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'emptyinput') {
                    echo '<p class="alert alert-danger">Fill in all fields!</p>';
                } elseif ($_GET['error'] == 'wrongdates') {
                    echo '<p class="alert alert-danger">There was an error with the dates. Please try again.</p>';
                } elseif ($_GET['error'] == 'stmtfailed') {
                    echo '<p class="alert alert-danger">There was an error. Try again later.</p>';
                }
            }
            ?>
            <form action="includes/create_submission.inc.php" method="post">
                <div class="form-group">
                    <label for="vacation-start" class="control-label">Vacation start date</label>
                    <input type="date" id="vacation-start" name="vacation-start" required>
                </div>
                <div class="form-group">
                    <label for="vacation-end" class="control-label">Vacation end date</label>
                    <input type="date" id="vacation-end" name="vacation-end" required>
                </div>
                <div class="form-group">
                    <label for="vacation-reason" class="control-label">Vacation Reason</label>
                    <textarea id="vacation-reason" name="vacation-reason" rows="2" cols="20" required>Vacation reason.</textarea>
                </div>
                <button name="submit" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-envelope"></span>
                    Submit Request
                </button>
            </form>
        </div>
    </div>
</div>



<?php require 'layout/footer.php'; ?>