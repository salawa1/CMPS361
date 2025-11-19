<?php
session_start(); // start session
session_unset();
session_destroy(); // kill the session
header("Location: login.php"); // redirect to login page
exit;
?>