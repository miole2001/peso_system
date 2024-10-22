<?php 
    // connection for account
    $connForAccounts = mysqli_connect("localhost", "root", "", "RJE_accounts");

    if ($connForAccounts->connect_error) {
        die("Connection failed: " . $connForAccounts->connect_error);
    }

    // connection for logs
    $connForLogs = mysqli_connect("localhost", "root", "", "RJE_logs");

    if ($connForLogs->connect_error) {
        die("Connection failed: " . $connForLogs->connect_error);
    }

    // connection for posts
    $connForPosts = mysqli_connect("localhost", "root", "", "RJE_posts");

    if ($connForPosts->connect_error) {
        die("Connection failed: " . $connForPosts->connect_error);
    }

    // connection for applicants
    // $connForApplicants = mysqli_connect("localhost", "root", "", "RJE_applicants");

    // if ($connForApplicants->connect_error) {
    //     die("Connection failed: " . $connForApplicants->connect_error);
    // }
?>