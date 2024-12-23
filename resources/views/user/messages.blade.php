@include('layout.header')

<style>
    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        flex: 0 0 250px;
        background-color: #2C2B5E;
        color: #fff;
        height: 100vh;
        padding: 20px;
        overflow-y: auto;
    }

    .main-content {
        flex: 1;
        padding: 20px;
        background-color: #f4f6f9;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

/* General styling for the messaging dashboard */


.header h1 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.header p {
    margin: 5px 0 20px;
    font-size: 14px;
    color: #666;
}

/* Messages container */
.messages-container {
    max-height: 500px;
    overflow-y: auto;
    margin-bottom: 20px;
}

/* Message card with wider layout */
.message-card {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px; /* Add space between message and reply */
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* User messages styling */
.user-message {
    align-self: flex-start;
    background-color: #e1f7d5;
    color: #333;
    padding: 10px 15px;
    border-radius: 10px 10px 10px 0;
    max-width: 80%;
}

/* Admin replies styling */
.admin-reply {
    align-self: flex-end;
    background-color: #d5e1f7;
    color: #333;
    padding: 10px 15px;
    border-radius: 10px 10px 0 10px;
    max-width: 80%;
}

/* Shared styling for message content */
.message-content {
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
}

/* Message form styling */
.message-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#messageInput {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    resize: none;
}

.send-btn {
    align-self: flex-end;
    padding: 8px 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.send-btn:hover {
    background-color: #45a049;
}

</style>

<body>
@include('layout.sidebar')

<div class="main-content">
    <div class="messages-dashboard">
        <div class="header">
            <h1>Messages</h1>
            <p>Stay connected with your messages and replies.</p>
        </div>

        <div class="messages-container" id="messagesContainer">
            @foreach($messages as $message)
                <div class="message-card">
                    <!-- Display user message -->
                    <div class="user-message">
                        <p class="message-content">{{ $message->message }}</p>
                    </div>

                    <!-- Display admin reply if exists -->
                    @if($message->is_admin_reply && $message->reply)
                        <div class="admin-reply">
                            <p class="message-content">{{ $message->reply }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <form id="messageForm" class="message-form">
            @csrf
            <textarea name="message" id="messageInput" rows="3" placeholder="Type your message..." required></textarea>
            <button type="submit" class="send-btn" id="sendBtn">Send</button>
            <span id="statusMessage" style="display:none; font-size: 12px; color: gray;">Sending...</span>
        </form>
    </div>
</div>


<script>
    document.getElementById('messageForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent form reload

        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const statusMessage = document.getElementById('statusMessage');
        const messagesContainer = document.getElementById('messagesContainer');

        // Show "Sending" spinner
        statusMessage.style.display = 'inline';
        sendBtn.disabled = true;

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('message', messageInput.value);

        fetch("{{ route('user.messages.store') }}", {
            method: 'POST',
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Add new message to the container
                    const newMessage = document.createElement('div');
                    newMessage.classList.add('message-card');
                    newMessage.innerHTML = `<div class="user-message">${data.message}</div>`;
                    messagesContainer.appendChild(newMessage);

                    // Clear input
                    messageInput.value = '';
                } else {
                    alert('Error sending message');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            })
            .finally(() => {
                // Hide "Sending" spinner
                statusMessage.style.display = 'none';
                sendBtn.disabled = false;
            });
    });
</script>
