<?php

if (isset($_POST['submit'])) {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $user_type = $_POST['user-type'];

    require_once 'dbhandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignUp($first_name, $last_name, $email, $password, $confirm_password, $user_type) !== false) {
        header("location: ../create_user.php?error=emptyinput");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../create_user.php?error=invalidemail");
        exit();
    }

    if (pwdMatch($password, $confirm_password) !== false) {
        header("location: ../create_user.php?error=pwdsdontmatch");
        exit();
    }

    if (emailExists($conn, $email) !== false) {
        header("location: ../create_user.php?error=emailexists");
        exit();
    }

    createUser($conn, $first_name, $last_name, $email, $password, $user_type);
} else {
    header("location: ../create_user.php");
}
