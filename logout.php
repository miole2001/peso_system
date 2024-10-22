<?php
// To display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Start the session
include("./database/connection.php");


$userEmail = $_SESSION['email']; // User's email
$userType = $_SESSION['userType']; // 'admin' or 'user'

// Determine the appropriate log table
if ($userType === 'peso_admin') {
    $logTable = 'admin_logs';
} else {
    $logTable = 'user_logs';
}

// Create the SQL statement for logging
$sql = "INSERT INTO $logTable (email, action_type, userType) VALUES ('$userEmail', 'logout', '$userType')";

// Execute the query using the logs connection
$connForLogs->query($sql);

// Optionally check for errors in the log query
if ($connForLogs->error) {
    error_log("Log query failed: " . $connForLogs->error);
}

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("location: index.php");
exit();
?>