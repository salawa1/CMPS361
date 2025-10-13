<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>
</body>
</html>