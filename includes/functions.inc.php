<?php

function emptyInputSignUp($first_name, $last_name, $email, $password, $confirm_password, $user_type)
{
    $result;

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password) || empty($user_type)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidEmail($email)
{
    $result;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function pwdMatch($password, $confirm_password)
{
    $result;

    if ($password !== $confirm_password) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    // if not errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../create_user.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $first_name, $last_name, $email, $password, $user_type)
{
    $sql = "INSERT INTO  users (usersFirstName, usersLastName, usersEmail, usersPassword, usersType) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    // if not errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../create_user.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $hashedPassword, $user_type);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../create_user.php?error=none");
    exit();
}

function emptyInputLogIn($email, $password)
{
    $result;

    if (empty($email) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}


function loginAdmin($conn, $email, $password)
{
    $emailExists = emailExists($conn, $email);

    if ($emailExists === false) {
        header("location: ../admin.php?error=wrongemail");
        exit();
    } else {
        $usersType = $emailExists['usersType'];
        $passHashed = $emailExists['usersPassword'];
        $checkPass = password_verify($password, $passHashed);

        if ($usersType === "Admin" && $checkPass) {
            session_start();
            $_SESSION["role"] = "admin";
            $_SESSION["name"] = $emailExists['usersFirstName'] . ' ' . $emailExists['usersLastName'];
            header("location: ../admin.php?error=none");
            exit();
        } elseif ($usersType === "Admin" && !$checkPass) {
            header("location: ../admin.php?error=wrongpass");
            exit();
        } elseif ($usersType !== "Admin") {
            header("location: ../admin.php?error=notadmin");
            exit();
        }
    }
}


function loginUser($conn, $email, $password)
{
    $emailExists = emailExists($conn, $email);

    if ($emailExists === false) {
        header("location: ../index.php?error=wrongemail");
        exit();
    } else {
        $usersType = $emailExists['usersType'];
        $passHashed = $emailExists['usersPassword'];
        $usersId = $emailExists['usersId'];
        $usersEmail = $email;
        // $usersFirstName = $emailExists['usersFirstName'];
        // $usersLastName = $emailExists['usersLastName'];
        $checkPass = password_verify($password, $passHashed);

        if ($usersType === "User" && $checkPass) {
            session_start();
            $_SESSION["role"] = "User";
            $_SESSION["name"] = $emailExists['usersFirstName'] . ' ' . $emailExists['usersLastName'];
            $_SESSION["usersid"] = $usersId;
            $_SESSION["email"] = $usersEmail;

            header("location: ../index.php?error=none");
            exit();
        } elseif ($usersType === "User" && !$checkPass) {
            header("location: ../index.php?error=wrongpass");
            exit();
        } elseif ($usersType !== "User") {
            header("location: ../index.php?error=notuser");
            exit();
        }
    }
}


function getUsers($conn)
{
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function emptyInputUpdateUser($first_name, $last_name, $email, $user_type)
{
    $result;

    if (empty($first_name) || empty($last_name) || empty($email) || empty($user_type)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function updateUser($conn, $first_name, $last_name, $email, $user_type)
{
    $sql = "INSERT INTO  users (usersFirstName, usersLastName, usersEmail, usersPassword, usersType) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    // if not errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../create_user.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $user_type);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../create_user.php?error=none");
    exit();
}

function emptyInputSubmission($vacation_start, $vacation_end, $vacation_reason)
{
    $result;

    if (empty($vacation_start) || empty($vacation_end) || empty($vacation_reason)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function wrongDates($vacation_start, $vacation_end)
{
    $diff = daysRequested($vacation_start, $vacation_end);
    if ($diff < 1)
        $result = true;
    else
        $result = false;

    return $result;
}

function daysRequested($vacation_start, $vacation_end)
{
    $diff = strtotime($vacation_end) - strtotime($vacation_start);
    $diff = ceil($diff / 86400);

    return $diff;
}


function createSubmission($conn, $vacation_start, $vacation_end, $vacation_reason)
{
    $sql = "INSERT INTO requests (usersId, submission_date, date_from, date_to, reason, stat) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    // if not errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../submit_request.php?error=stmtfailed");
        exit();
    }

    session_start();
    $usersId = $_SESSION["usersid"];
    $usersName = $_SESSION["name"];
    $users_Email = $_SESSION["email"];
    $submissionDate = date('Y-m-d');
    $stat = 'pending';
    mysqli_stmt_bind_param($stmt, "ssssss", $usersId, $submissionDate, $vacation_start, $vacation_end, $vacation_reason, $stat);
    mysqli_stmt_execute($stmt);

    //get requestId
    $requestId = $conn->insert_id;

    mysqli_stmt_close($stmt);

    sendEmail(
        $vacation_start,
        $vacation_end,
        $vacation_reason,
        $usersId,
        $usersName,
        $requestId,
        $users_Email
    );

    header("location: ../index.php?error=none");
    exit();
}

function sendEmail(
    $vacation_start,
    $vacation_end,
    $vacation_reason,
    $usersId,
    $usersName,
    $requestId,
    $users_Email
) {
    $to_email = "epignosisjim@gmail.com";
    $subject = "Vacation Request";

    $body = "Dear supervisor, employee $usersName requested for some time off, starting on <br />
    <b> $vacation_start </b> and ending on <b> $vacation_end </b>, stating the reason: <br />
    <b> $vacation_reason </b> <br />
    Click on one of the below links to approve or reject the application: <br />
    <b> <a href='http://localhost/epignosis/includes/application_approval.inc.php?status=approved&requestid=$requestId&email=$users_Email'>Approve</a> - <a href='http://localhost/epignosis/includes/application_approval.inc.php?status=rejected&requestid=$requestId&email=$users_Email'>Reject</a> </b>
    ";

    $headers = "MIME-Version: 1.0\r\n";
    //Set the content-type to html
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($to_email, $subject, $body, $headers)) {
        echo "Email successfully sent to $to_email...";
    } else {
        echo "Email sending failed...";
    }
}


function getRequests($conn, $usersId)
{
    $sql = "SELECT * FROM requests where usersId=$usersId ORDER BY submission_date DESC;";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function applicationApproval($conn, $status, $request_id, $email)
{
    $sql = "UPDATE requests SET stat=? WHERE requestId=?";
    $stmt = mysqli_stmt_init($conn);
    // if not errors
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../indexl.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sd", $status, $request_id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    sendEmailToUser($conn, $status, $email, $request_id);

    header("location: ../application_approval.php");
    exit();
}


function sendEmailToUser($conn, $status, $email, $request_id)
{
    $to_email = $email;
    $subject = "About your vacation";

    $sql = "SELECT * FROM requests where requestId = $request_id";
    $result = mysqli_query($conn, "SELECT submission_date FROM requests WHERE requestId=$request_id");
    $row = mysqli_fetch_assoc($result);
    $sub_date = $row['submission_date'];

    $body = "Dear employee, your supervisor has <b> $status </b> your application <br />
    submitted on <b> $sub_date </b>.";

    $headers = "MIME-Version: 1.0\r\n";
    //Set the content-type to html
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if (mail($to_email, $subject, $body, $headers)) {
        echo "Email successfully sent to $to_email...";
    } else {
        echo "Email sending failed...";
    }
}
