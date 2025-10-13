<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database Configuration
$host = 'localhost';
$db = 'authentication';
$db_user = 'postgres';
$db_pass = 'Amat1966';
$port = '5432';

// Connect to Postgres
$conn = pg_connect("host=$host port=$port dbname=$db user=$db_user password=$db_pass");

// Validate connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get user info
$username = $_POST['username'];
$password = $_POST['password'];

// Make sure values exist
if (empty($username) || empty($password)) {
    die("Username and password are required.");
}

// SQL Query (fetch user)
$sql = "SELECT * FROM users WHERE username = $1";
$result = pg_query_params($conn, $sql, array($username));

if (!$result) {
    die("Query error: " . pg_last_error());
}

if (pg_num_rows($result) > 0) {
    // Verify password using PostgreSQL crypt() check
    $check_sql = "SELECT (password = crypt($1, password)) AS match FROM users WHERE username = $2";
    $check_result = pg_query_params($conn, $check_sql, array($password, $username));

    if (!$check_result) {
        die("Password check failed: " . pg_last_error());
    }

    $row = pg_fetch_assoc($check_result);

    if ($row['match'] === 't') {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        echo "<h3>Invalid password. Please try again.</h3>";
        echo "<a href='login.php'>Back to Login</a>";
    }
} else {
    echo "<h3>Invalid username. Please try again.</h3>";
    echo "<a href='login.php'>Back to Login</a>";
}

pg_close($conn);
?>