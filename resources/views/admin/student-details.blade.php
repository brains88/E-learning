@include('layout.header')


<style>
/* General Styles */
/* General Styles */
body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
    display: flex; /* Flexbox layout for sidebar and content */
    flex-direction: row; /* Sidebar and main content should align horizontally */
    overflow-x: hidden; /* Prevent horizontal scroll */
}

#adminnavbar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    background-color: #2C2B5E;
    color: white;
    z-index: 1000; /* Ensures sidebar stays above other elements */
    overflow-y: auto; /* Scrollable if content exceeds height */
    padding: 15px;
    box-sizing: border-box; /* Ensures padding doesn't affect width */
}

.main-content {
    margin-left: 340px !important; /* Adjust based on the sidebar width */
    padding: 20px;
    transition: all 0.3s ease-in-out;
    width: calc(100% - 250px); /* Ensure full width after sidebar */
    box-sizing: border-box;
}

/* Header */
.header {
    background-color: #2C2B5E;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    left: 250px; /* Start after the sidebar */
    width: calc(100% - 250px); /* Adjust for sidebar width */
    z-index: 999;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

.content {
    margin-top: 80px; /* Space below fixed header */
}

/* Card Styling */
.card {
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    background-color: white;
}

.card-body {
    padding: 15px;
}

.card h4, .card h5 {
    color: #2C2B5E;
    font-weight: bold;
}

.card p, .card ul {
    margin: 0;
}

.card ul {
    padding-left: 20px;
    list-style: none;
}

.card ul li {
    margin-bottom: 5px;
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.card ul li:last-child {
    border-bottom: none;
}

.btn-secondary {
    background-color: #2C2B5E;
    border: none;
    color: white;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .main-content {
        margin-left: 0 !important; /* Remove sidebar margin for small screens */
        width: 100%; /* Ensure content takes full width */
    }

    .header {
        left: 0; /* Adjust header to fit small screen */
        width: 100%; /* Full width for the header */
    }
}



</style>

@include('layout.adminnavbar')

<div class="header">
    <h4>Student Details</h4>
    <div class="profile">
        <span>Admin</span>
    </div>
</div>


<div class="main-content mt-5">
    <div class="content mt-5">
        <h2>Student Details</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="card-title">{{ $student->name }}</h4>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($student->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">Enrolled Courses</h3>
                    <ul class="list-group">
                        @foreach($courses as $course)
                            <li class="list-group-item">
                                {{ $loop->iteration }}. {{ $course->title }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        >


        <div class="card mb-3">
            <div class="card-body">
                <h3>Quiz Answers</h3>
                <ul class="list-group">
                    @foreach($student->answers as $answer)
                        <li class="list-group-item">
                            <strong>Answer:</strong> {{ $answer->answer }} <br>
                            <strong>Course:</strong> {{ $answer->course->title ?? 'N/A' }} <br>
                            <strong>Question:</strong> {{ $answer->question->text ?? 'N/A' }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Messages</h4>
                @if($student->messages->isEmpty())
                    <p>No messages found.</p>
                @else
                    <ul>
                        @foreach($student->messages as $message)
                            <li>
                                <strong>Message:</strong> {{ $message->message }} <br>
                                <strong>Reply:</strong> {{ $message->is_admin_reply ? 'Yes' : 'No' }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

@include('layout.userfooter')
