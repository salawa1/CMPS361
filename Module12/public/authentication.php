<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include './functions/activity_log.php';
include './functions/track_activity.php';

// Database config
$host = 'localhost';
$db = 'authentication';
$db_user = 'postgres';
$db_pass = 'Amat1966';
$port = '5432';

// Postgres connection
$conn = pg_connect("host=$host port=$port dbname=$db user=$db_user password=$db_pass");

// Validate connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get user info
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Make sure values exist
if (empty($username) || empty($password)) {
    die("Username and password are required.");
}

// SQL Query (fetch user)
$sql = "SELECT * FROM users WHERE username = $1";
$result = pg_query_params($conn, $sql, [$username]);

if (!$result) {
    die("Query error: " . pg_last_error());
}

if (pg_num_rows($result) > 0) {
    // Verify password
    $check_sql = "SELECT (password = crypt($1, password)) AS match FROM users WHERE username = $2";
    $check_result = pg_query_params($conn, $check_sql, [$password, $username]);

    if (!$check_result) {
        die("Password check failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($check_result);

    // PHPStan correction
    if (is_array($row) && isset($row['match']) && $row['match'] === 't') {
        $_SESSION['username'] = $username;
        logActivity($username, 'login', 'Logged in successfully');
        header("Location: welcome.php");
        exit;
    } else {
        logActivity($username, 'login', 'Log in failed');
        echo "
        <html>
        <head><link rel='stylesheet' href='css/authentication.css'></head>
        <body>
            <div class='auth-container'>
                <div class='error-box'>
                    <h3>Invalid Password</h3>
                    <p>Please try again.</p>
                    <a href='login.php' class='btn'>Back to Login</a>
                </div>
            </div>
        </body>
        </html>";
    }
} else {
    echo "
    <html>
    <head><link rel='stylesheet' href='css/authentication.css'></head>
    <body>
        <div class='auth-container'>
            <div class='error-box'>
                <h3>Invalid Username</h3>
                <p>The username you entered does not exist.</p>
                <a href='login.php' class='btn'>Back to Login</a>
            </div>
        </div>
    </body>
    </html>";
}

pg_close($conn);
?>