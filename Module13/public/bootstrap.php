<?php
    session_start();

    if(!isset($_SESSION['session_id'])) {
        $_SESSION['session_id'] = bin2hex(random_bytes(16));
    }

    $currentSessionId = $_SESSION['session_id'];
    $currentUserId = $_SESSION['user_id'] ?? null;

?>