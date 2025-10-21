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
    <link rel="stylesheet" href="css/welcome.css">
</head>
<body>
<div class="welcome-container">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
        <div class="button-group">
            <a href="product.php" class="btn btn-primary">View Products</a>
            <a href="addproduct.php" class="btn btn-secondary">Add Products</a>
        </div>

        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
</div>
</body>
</html>