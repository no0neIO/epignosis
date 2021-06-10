<?php

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'dbhandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogIn($conn, $email, $password) !== false) {
        header("location: ../admin.php?error=emptyinput");
        exit();
    }

    loginAdmin($conn, $email, $password);
} else {
    header("location: ../admin.php?error=emptyinput");
    exit();
}
