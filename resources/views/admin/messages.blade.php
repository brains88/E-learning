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

    .messages-dashboard {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .header {
        margin-bottom: 10px;
    }

    .header h1 {
        font-size: 24px;
        color: #2C2B5E;
        margin: 0;
    }

    .header p {
        font-size: 14px;
        color: #6c757d;
    }

    .messages-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 500px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #fff;
    }

    .message-card {
        display: flex;
        align-items: flex-start;
    }

    .user-message,
    .admin-reply {
        padding: 12px;
        border-radius: 16px;
        max-width: 70%;
        font-size: 14px;
        line-height: 1.4;
    }

    .user-message {
        background-color: #d1e7dd;
        color: #2C2B5E;
        align-self: flex-start;
        margin-right: auto;
    }

    .admin-reply {
        background-color: #f1f1f1;
        color: #6c757d;
        align-self: flex-end;
        margin-left: auto;
    }

    .message-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message-form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 12px;
        font-size: 14px;
        resize: none;
    }

    .send-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 14px;
    }

    .send-btn:hover {
        background-color: #0056b3;
    }
</style>

<body>
@include('layout.adminnavbar')

<div class="main-content">
    <div class="messages-dashboard">
        <div class="header">
            <h1>Students Messages</h1>
            <p>Stay connected with students messages and replies.</p>
        </div>
        @foreach($students as $student)
    @foreach($student->messages as $message)
        <div class="message-card">
            <div class="user-message">
                {{ $message->message }}
            </div>
            @if($message->is_admin_reply)
                <div class="admin-reply">
                    {{ $message->reply }}
                </div>
            @else
                <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                    @csrf
                    <textarea name="reply" rows="2" placeholder="Reply to this message..." required></textarea>
                    <button type="submit" class="send-btn">Reply</button>
                </form>
            @endif
        </div>
    @endforeach
@endforeach



</div>
</div>

