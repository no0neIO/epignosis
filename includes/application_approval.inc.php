<?php
require_once './dbhandler.inc.php';
require_once './functions.inc.php';
?>

<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <h1>Application approval</h1>
            <?php
            if (isset($_GET['status']) && (isset($_GET['requestid']) && (isset($_GET['email'])))) {
                $status = $_GET['status'];
                $request_id = $_GET['requestid'];
                $email = $_GET['email'];
                applicationApproval($conn, $status, $request_id, $email);
            }
            // if (isset($_GET['error'])) {
            //     if ($_GET['error'] == 'none') {
            //         echo '<p class="alert alert-success">Status successfully changed.</p>';
            //     }
            // }
            ?>
        </div>
    </div>
</div>



<hr>