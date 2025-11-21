<?php
    session_start();

    require_once __DIR__ . '/conn.php';
    require_once __DIR__ . '/helper.php';

    //Ensure tracking session ID exists
    if(!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = bin2hex(random_bytes(16));
    }

    $currentSessionId = $_SESSION['session_id'];
    $currentUserId = $_SESSION['user_id'] ?? null;

    updateSession($pdo, $currentSessionId, $currentUserId);
    logPageView($pdo, $currentSessionId, $currentUserId);
?>

<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <center>
            <h1>Welcome to the metrics page</h1>
            <a href="metrics.php">
                <img src="images/metrics.jpg" alt="Metrics">
            </a>
        </center>
</html>
