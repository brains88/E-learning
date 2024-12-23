@include('layout.header')
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }

    /* General Styles */
    .dashboard {
      display: flex;
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
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

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 20px;
      margin-bottom: 20px;
    }

    .card {
      background-color: #f1f3f5;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #555;
    }

    /* New Sections */
    .courses,
    .messages,
    .announcements {
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 15px;
      color: #333;
    }

    .courses .course,
    .messages .message,
    .announcements .announcement {
      display: flex;
      align-items: center;
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 15px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .courses .course img,
    .messages .message img,
    .announcements .announcement img {
      width: 60px;
      height: 60px;
      border-radius: 5px;
      margin-right: 15px;
    }

    .courses .course .info,
    .messages .message .info,
    .announcements .announcement .info {
      flex: 1;
    }

    .footer {
      text-align: center;
      padding: 15px;
      font-size: 14px;
      color: #aaa;
    }


  </style>

<body>
  <div class="dashboard">
    @include('layout.sidebar')

    <div class="main-content" id="main-content">
      <div class="header">
        <h1>Welcome Back, {{ $user->name }}!</h1>
        <div class="profile">
          <img src="{{ $user->image ? asset('storage/profile_images/'. $user->image) : 'https://via.placeholder.com/40' }}" alt="Profile Picture">
          <span>{{ $user->name }}</span>
        </div>
      </div>

      <div class="cards">
        <div class="card">
          <h3>{{ $coursesEnrolled }}</h3>
          <p>Courses Enrolled</p>
        </div>
        <div class="card">
          <h3>{{ $totalQuestions }}</h3>
          <p>Total Quiz</p>
        </div>
        <div class="card">
          <h3>{{ $totalAnswers }}</h3>
          <p>Quizzes Completed</p>
        </div>
        <div class="card">
          <h3>{{ $totalMessages }}</h3>
          <p>Messages</p>
        </div>
      </div>

      <div class="courses">
        <h2 class="section-title">Ongoing Courses</h2>
        @forelse($ongoingCourses as $course)
          <div class="course">
            <img src="https://via.placeholder.com/60" alt="Course">
            <div class="info">
              <h4>{{ $course->title }}</h4>
              <p>Progress: {{ $course->pivot->progress_percentage ?? 'NA' }}%</p>
            </div>
          </div>
        @empty
          <p>No ongoing courses.</p>
        @endforelse
      </div>

      <div class="messages">
        <h2 class="section-title">Recent Messages</h2>
        <div class="message">
          <img src="https://via.placeholder.com/60" alt="Message">
          <div class="info">
            <h4>Instructor: Jane Doe</h4>
            <p>Your assignment feedback is ready!</p>
          </div>
        </div>
      </div>

      <div class="announcements">
        <h2 class="section-title">Latest Announcements</h2>
        <div class="announcement">
          <img src="https://via.placeholder.com/60" alt="Announcement">
          <div class="info">
            <h4>System Update</h4>
            <p>New features have been added to the platform.</p>
          </div>
        </div>
      </div>

      <div class="footer">
        &copy; 2024 E-Learn Platform
      </div>
    </div>
  </div>

  @include('layout.userfooter')
</body>

</html>
