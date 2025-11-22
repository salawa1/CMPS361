<!DOCTYPE html>
<html>
    <head>
        <title>App Login</title>
        <style>
        body { background: #209bb0 !important; }
        </style>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
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

        <!-- Metrics Button -->
        <button type="button" id="metricsBtn">View Metrics</button>

        <!-- Password Prompt -->
        <div id="metricsPrompt" class="metrics-popup" style="display:none;">
            <label for="metricsPassword">Enter Metrics Password</label>
            <input type="password" id="metricsPassword" placeholder="Password">

            <div id="metricsError" style="display:none; color:#c62828; font-size:14px; margin-top:5px;">
                Incorrect password.
            </div>

            <button id="metricsSubmit">Submit</button>
        </div>

        </div>

        <script>
            const metricsBtn = document.getElementById('metricsBtn');
            const metricsPrompt = document.getElementById('metricsPrompt');
            const metricsSubmit = document.getElementById('metricsSubmit');
            const metricsPassword = document.getElementById('metricsPassword');
            const metricsError = document.getElementById('metricsError');

            metricsBtn.onclick = () => {
                metricsPrompt.style.display = 'flex';
                metricsPassword.focus();
            };

            metricsSubmit.onclick = () => {
                if (metricsPassword.value === 'admin1') {
                    window.location.href = 'metrics.php';
                } else {
                    metricsError.style.display = 'block';
                }
            };
        </script>
    </body>
</html>

<?php
require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/helper.php';

if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = bin2hex(random_bytes(16));
}

$currentSessionId = $_SESSION['session_id'];
$currentUserId = $_SESSION['user_id'] ?? null;

updateSession($pdo, $currentSessionId, $currentUserId);
logPageView($pdo, $currentSessionId, $currentUserId);
?>