<html>
<head>
    <title>DJ Rex ChatBot</title>

    <link rel="stylesheet" href="css/chatbot.css">
    <script src="js/botMessaging.js" defer></script>
</head>

<body>
    <div class="chat-container">
        <h1>DJ Rex</h1>

        <div id="chatbot">
            <div id="messages">
                <!-- Welcome message -->
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
</body>
</html>