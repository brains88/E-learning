<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>AI Chatbot</title>
    <style>
        /* Chatbot Floating Button */
        #chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #2c2b5e; /* Use primary color */
            color: white;
            padding: 10px 15px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        /* Chatbot Box */
        #chatbot-container {
            display: none;
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 10px;
            z-index: 1000;
        }

        /* Chatbot Messages */
        #chatbot-messages {
            height: 300px;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* User Message */
        .user-message {
            align-self: flex-end;
            background-color: #EC1C23; /* User message color */
            color: white;
            padding: 8px 12px;
            border-radius: 10px 10px 0 10px;
            max-width: 80%;
        }

        /* Bot Message */
        .bot-message {
            align-self: flex-start;
            background-color: #2c2b5e; /* Bot message color */
            color: white;
            padding: 8px 12px;
            border-radius: 10px 10px 10px 0;
            max-width: 80%;
        }

        /* Typing Indicator */
        .typing-indicator {
            align-self: flex-start;
            color: #666;
            font-style: italic;
        }

        /* Input Box */
        #chatbot-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        /* Send Button */
        #send-button {
            margin-top: 10px;
            background: #2c2b5e; /* Primary color */
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        #send-button:hover {
            background: #1a1940; /* Darker shade for hover */
        }
    </style>
</head>
<body>
    <!-- Chatbot Floating Button -->
    <div id="chatbot-icon" onclick="toggleChatbot()">Ask me a question</div>

    <!-- Chatbot Container -->
    <div id="chatbot-container">
        <div id="chatbot-messages"></div>
        <input type="text" id="chatbot-input" placeholder="Type your question...">
        <button id="send-button" onclick="sendMessage()">Send</button>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function toggleChatbot() {
            let chatbot = document.getElementById('chatbot-container');
            chatbot.style.display = (chatbot.style.display === "block") ? "none" : "block";
        }

        function sendMessage() {
    let input = document.getElementById("chatbot-input");
    let message = input.value.trim();
    if (message === "") return;

    let messages = document.getElementById("chatbot-messages");
    messages.innerHTML += `<div class="user-message">${message}</div>`;
    messages.innerHTML += `<div class="typing-indicator">EduNet Bot is typing...</div>`;
    messages.scrollTop = messages.scrollHeight;

    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    axios.post("{{ route('chatbot') }}", { message: message }, {
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        }
    })
    .then(response => {
        messages.querySelector(".typing-indicator").remove();
        messages.innerHTML += `<div class="bot-message">${response.data.reply}</div>`;
        messages.scrollTop = messages.scrollHeight;
    })
    .catch(error => {
        messages.querySelector(".typing-indicator").remove();
        messages.innerHTML += `<div class="bot-message">Error: Unable to process your request.</div>`;
        messages.scrollTop = messages.scrollHeight;
    });

    input.value = "";
}
    </script>
</body>
</html>