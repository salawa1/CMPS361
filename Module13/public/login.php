<!DOCTYPE html>
<html>
    <head>
        <title>App Login</title>
        <style>
        body { background: #209bb0 !important; }
        </style>
    </head>
    <body>
        <link rel="stylesheet" href="css/login.css">
        <div class="login-container">

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="authentication.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required><br>

            <button type="submit">Login</button>
        </form>
        </div> 
    </body>
</html>
<?php
?>