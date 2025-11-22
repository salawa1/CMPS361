<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/welcome.css">
    <script src="js/botMessaging.js" defer></script>

    <style>
        body { background: #209bb0 !important; }

        .chat-wrapper {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: none;
        }

        .chat-wrapper .chat-container {
            width: 350px;
            background: #f0f0f0;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .chat-wrapper h1 {
            margin: 0 0 10px 0;
            font-size: 20px;
            text-align: center;
            color: #000;
        }

        .chat-wrapper #chatbot {
            background: #d3d3d3;
            height: 350px;
            border-radius: 12px;
            padding: 12px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chat-wrapper #messages > div {
            margin-bottom: 12px;
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 10px;
        }

        .chat-wrapper .user-message {
            background: #209bb0;
            align-self: flex-end;
            color: white;
        }

        .chat-wrapper .bot-message {
            background: #ffffff;
            align-self: flex-start;
            color: #209bb0;
        }

        .chat-wrapper form {
            display: flex;
            margin-top: 15px;
        }

        .chat-wrapper form input {
            flex: 1;
            padding: 12px;
            border-radius: 10px 0 0 10px;
            border: none;
            outline: none;
            background: #d3d3d3;
            color: #000;
        }

        .chat-wrapper form button {
            background: #209bb0 !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            font-weight: bold;
        }

        .chat-wrapper form button:hover {
            background: #1b8597 !important;
        }
    </style>

    <script>
        // Show chatbot after 5 seconds
        window.addEventListener("load", function () {
            setTimeout(function () {
                document.querySelector(".chat-wrapper").style.display = "block";
            }, 5000);
        });
    </script>
</head>

<body>
<div class="welcome-container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

    <div class="button-group">
        <a href="viewProduct.php" class="btn btn-primary">View Products</a>
        <a href="addProduct.php" class="btn btn-secondary">Add Products</a>
    </div>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

<!-- Chatbot -->
<div class="chat-wrapper">
    <div class="chat-container">
        <h1>DJ Rex</h1>

        <div id="chatbot">
            <div id="messages">
                <div class="bot-message">
                    <strong>DJ Rex:</strong> Welcome! Ask me anything about our record collection!
                </div>
            </div>

            <div id="typing-indicator" class="typing hidden">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>

        <form id="chat-form" method="POST">
            <input type="text" name="user_input" id="user_input"
                placeholder="Ask me something about our collection" required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

</body>
</html>