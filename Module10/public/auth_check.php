<?php
//Authentication verification
if (empty($_SESSION['user_id'])) {
    header('Location: /login.php?redirect=' . urldecode(($_SERVER['REQUEST_URL'])));
    exit;
}
?>