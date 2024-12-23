@include('layout.header')

<style>
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: row;
    min-height: 100vh;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Sidebar */
.sidebar {
    flex: 0 0 250px;
    background-color: #2C2B5E;
    color: #fff;
    height: 100vh;
    overflow-y: auto;
    padding: 20px;
}

/* Main Content Area */
.main-content {
    flex: 1;
    padding: 20px;
}

.quizzes-dashboard {
    padding: 20px;
    color: #2C2B5E;
    background-color: #f4f7fc;
}

/* Responsive Quizzes Grid */
.quizzes-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Adjusts to available space */
    gap: 20px;
    width: 100%;
    box-sizing: border-box;
    padding: 0 10px;
    margin: 0 auto;
}

/* Quiz Card */
.quiz-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.quiz-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.quiz-card-header {
    height: 150px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 10px;
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.quiz-card-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.quiz-card-body p {
    font-size: 14px;
    color: #6c757d;
    margin: 0;
}

.quiz-meta {
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.start-quiz-btn {
    background-color: #2C2B5E;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.start-quiz-btn:hover {
    background-color: #44429d;
}


    .header .profile {
      display: flex;
      align-items: center;
    }

    .header .profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 28px;
        margin: 0;
    }

 

   
</style>

<body>
    @include('layout.adminnavbar') <!-- Sidebar included here -->
    <div class="main-content">
        <div class="header">
            <h1>My Quizzes</h1>
            <div class="profile">
                <img src="{{ $user->image ? asset('storage/profile_images/' . $user->image) : 'https://via.placeholder.com/40' }}" alt="Profile Picture">
                <span style="color:#2C2B5E;">John Doe</span>
            </div>
        </div>
 
<!-- Display Success or Error Messages -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <div class="quizzes-container">
    @if (!empty($courses) && count($courses) > 0)
        @foreach ($courses as $course)
            <div class="quiz-card">
                <div class="quiz-card-header" style="background-image: url('{{ $course->course_image ? asset('assets/img/course/' . $course->course_image) : 'https://via.placeholder.com/250x150' }}')">
                    <h3>{{ $course->title }}</h3>
                </div>
                <div class="quiz-card-body">
                    <p>{{ $course->description }}</p>
                    <div class="quiz-meta">
                        <span>{{ !empty($course->questions) ? $course->questions->count() : 0 }} Questions</span>
                    </div>
                    @php
                    // Check if the user has already submitted an answer for this course
                    $hasSubmitted = \App\Models\Answer::where('user_id', auth()->user()->id)
                        ->where('course_id', $course->id)
                        ->exists();
                    @endphp

                    @if ($hasSubmitted)
                        <!-- Show "Submitted" if user has already submitted -->
                        <button class="btn" disabled>Submitted</button>
                    @else
                        <!-- Show Start Quiz Button if user hasn't submitted -->
                        <button class="btn start-quiz-btn" data-bs-toggle="modal" data-bs-target="#quizModal-{{ $course->id }}">
                            Start Quiz
                        </button>
                    @endif
                </div>
            </div>

           <!-- Modal for Quiz -->
<div class="modal fade" id="quizModal-{{ $course->id }}" tabindex="-1" aria-labelledby="quizModalLabel-{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quizModalLabel-{{ $course->id }}">{{ $course->title }} Quiz</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (!empty($course->questions) && $course->questions->count() > 0)
                    <form action="{{ route('user.quizzes.submit', $course->id) }}" method="POST" id="quiz-form-{{ $course->id }}">
                        @csrf
                        @foreach ($course->questions as $question)
                            <div class="mb-3">
                                <p><strong>{{ $loop->iteration }}. {{ $question->question_text }}</strong></p>
                                @if ($question->options)
                                    @foreach (json_decode($question->options) as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" id="option-{{ $question->id }}-{{ $loop->index }}">
                                            <label class="form-check-label" for="option-{{ $question->id }}-{{ $loop->index }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <input type="text" name="answers[{{ $question->id }}]" class="form-control" placeholder="Your answer">
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary" id="submit-quiz-{{ $course->id }}">
                            Submit Quiz
                            <span id="spinner-{{ $course->id }}" class="spinner-border spinner-border-sm text-light" style="display: none;" role="status"></span>
                        </button>
                    </form>
                    <!-- Message Container -->
                    <div id="message-container"></div> <!-- Success or error messages will appear here -->
                @else
                    <p>No questions available for this quiz.</p>
                @endif
            </div>
        </div>
    </div>
</div>


        @endforeach <!-- This was missing -->
    @else
        <p>No courses available.</p>
    @endif
</div>


    @include('layout.userfooter')


    <script>
document.querySelectorAll('.start-quiz-btn').forEach(button => {
    button.addEventListener('click', function () {
        const courseId = this.getAttribute('data-bs-target').split('-')[1]; // Get course ID from data-bs-target
        const form = document.querySelector(`#quiz-form-${courseId}`);
        const messageContainer = document.getElementById('message-container');
        const submitButton = form.querySelector('button[type="submit"]');
        const spinner = document.getElementById(`spinner-${courseId}`); // Get the spinner element

        const formData = new FormData(form);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content); // Add CSRF token manually

        console.log("Form Data:", Object.fromEntries(formData.entries())); // Log the form data

        // Show the spinner and disable the submit button
        spinner.style.display = 'inline-block'; // Show spinner
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...'; // Change button text to indicate submission

        fetch(`/quizzes/submit/${courseId}`, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json()) // Convert the response to JSON
        .then(data => {
            console.log("Response data:", data); // Log the response data
            if (data.message) {
                // Display the success message in the message container
                messageContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            }
            spinner.style.display = 'none'; // Hide spinner
            submitButton.disabled = true;
            submitButton.textContent = 'Submitted';
        })
        .catch(error => {
            console.error("Error occurred:", error); // Log the error to debug
            messageContainer.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
            spinner.style.display = 'none'; // Hide spinner
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Quiz';
        });
    });
});

</script>
