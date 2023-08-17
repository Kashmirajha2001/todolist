<?php
include 'dbconnect.php';

if (isset($_COOKIE['remember_me_token'])) {
    $token = $_COOKIE['remember_me_token'];

    // Check the token in the database
    $checkTokenSql = "SELECT `username` FROM `users` WHERE `remember_me_token` = $token";
    $checkTokenStmt = mysqli_prepare($connection, $checkTokenSql);
    mysqli_stmt_bind_param($checkTokenStmt, "s", $token);
    mysqli_stmt_execute($checkTokenStmt);
    mysqli_stmt_store_result($checkTokenStmt);

    if (mysqli_stmt_num_rows($checkTokenStmt) === 1) {
        mysqli_stmt_bind_result($checkTokenStmt, $username);
        mysqli_stmt_fetch($checkTokenStmt);

        // Log in the user
        session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;

        header("location: home.php");
        exit();
    }
}

// If token is invalid or not present, redirect to the login page
header("location: index.php");
exit();
?>
