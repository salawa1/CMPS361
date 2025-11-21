const form = document.getElementById('chat-form');
const messages = document.getElementById('messages');
const typing = document.getElementById('typing-indicator');

function scrollToBottom() {
    const chatbox = document.getElementById('chatbot');
    chatbox.scrollTop = chatbox.scrollHeight;
}

// Scroll after initial welcome message
scrollToBottom();

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const userInput = document.getElementById('user_input').value;

    // Add user's message
    messages.insertAdjacentHTML(
        'beforeend',
        `<div class="user-message"><strong>You:</strong> ${userInput}</div>`
    );

    scrollToBottom();

    // Send POST to backend
    const response = await fetch('conn.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ user_input: userInput })
    });

    const botResponse = await response.text();

    // Hide typing dots
    typing.classList.add("hidden");

    // Add bot message
    messages.insertAdjacentHTML(
        'beforeend',
        `<div class="bot-message"><strong>DJ Rex:</strong> ${botResponse}</div>`
    );

    scrollToBottom();

    form.reset();

});