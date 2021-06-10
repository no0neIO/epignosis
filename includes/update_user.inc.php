<?php

if (isset($_POST['submit'])) {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $user_type = $_POST['user-type'];

    require_once 'dbhandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputUpdateUser($first_name, $last_name, $email, $user_type) !== false) {
        header("location: ../user_properties.php?error=emptyinput");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../user_properties.php?error=invalidemail");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        header("location: ../user_properties.php?error=emailexists");
        exit();
    }

    updateUser($conn, $first_name, $last_name, $email, $user_type);
} else {
    header("location: ../create_user.php");
}
