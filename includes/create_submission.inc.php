<?php

if (isset($_POST['submit'])) {
    $vacation_start = $_POST['vacation-start'];
    $vacation_end = $_POST['vacation-end'];
    $vacation_reason = $_POST['vacation-reason'];


    require_once 'dbhandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSubmission($vacation_start, $vacation_end, $vacation_reason) !== false) {
        header("location: ../submit_request.php?error=emptyinput");
        exit();
    }

    if (wrongDates($vacation_start, $vacation_end) !== false) {
        header("location: ../submit_request.php?error=wrongdates");
        exit();
    }

    createSubmission($conn, $vacation_start, $vacation_end, $vacation_reason);
} else {
    header("location: ../index.php");
}
