@include('layout.header')
<style>
  /* General Styles */
  body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
  }
  .header {
    color: #fff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .header h1 {
    font-size: 24px;
    margin: 0;
    color: #2C2B5E;
  }
  .profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .section-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
  }
  .courses-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Always 3 cards per row */
  gap: 20px;
  padding: 20px;
}

.course-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  height: 100%; /* Make all cards consistent */
}

.course-card img {
  width: 100%;
  height: 150px; /* Set a fixed height */
  object-fit: cover; /* Ensure images look good */
}

.course-info {
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.actions {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.actions button {
  flex: 1;
  font-size: 14px; /* Slightly smaller buttons */
}

@media (max-width: 768px) {
  .courses-grid {
    grid-template-columns: repeat(2, 1fr); /* 2 cards per row for medium screens */
  }
}
@media (max-width: 576px) {
  .courses-grid {
    grid-template-columns: 1fr; /* 1 card per row for small screens */
  }
}



</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
@include('layout.sidebar')
<div class="header">
  <h1>My Courses</h1>
  <div class="profile">
    <img src="{{ $user->image ? asset('storage/profile_images/' . $user->image) : 'https://via.placeholder.com/40' }}" alt="Profile Picture">
    <span style="color:#000">{{ $user->name }}</span>
  </div>
</div>
<div class="main-content">
  <h2 class="section-title">Courses Enrolled</h2>
  @if($courses->isEmpty())
  <div class="alert alert-warning">
    You are not enrolled in any courses yet.
  </div>
  @else
  <div class="courses-grid">
  @foreach($courses as $course)
  <div class="course-card">
    <img src="{{ $course->course_image ? asset('storage/courses/images/' . $course->course_image) : 'https://via.placeholder.com/300x200' }}" alt="Course Image">
    <div class="course-info">
      <h3>{{ $course->title }}</h3>
      <p>Status: {{ ucfirst($course->status) }}</p>
      <div class="progress-bar-container">
        <div class="progress-bar {{ strtolower($course->status) }}" style="width: {{ min($course->progress, 100) }}%;"></div>
      </div>
      <div class="actions">
        <button 
          class="btn btn-primary" 
          data-bs-toggle="modal" 
          data-bs-target="#courseVideoModal" 
          data-course-id="{{ $course->id }}">
          Continue
        </button>
        <button 
          class="btn btn-warning" 
          data-bs-toggle="modal" 
          data-bs-target="#detailsModal" 
          data-course-id="{{ $course->id }}">
          Details
        </button>
      </div>
    </div>
  </div>
  @endforeach
</div>
  @endif
</div>


<!-- Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 id="courseTitle">Loading...</h3>
        <p id="courseDescription">Please wait while we fetch the course details.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
        <a id="continueButton" href="#" class="btn btn-primary">Continue</a>
      </div>
    </div>
  </div>
</div>


<!-- Modal For Video -->
<div class="modal fade" id="courseVideoModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Course Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Video Container -->
        <div class="video-container">
          <video id="courseVideo" controls preload="metadata" style="width: 100%; height: auto;">
            <source src="" id="videoSource" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <!-- Course Details -->
        <div id="courseDescription" class="mt-3">
          <h4 id="videoTitle">Loading...</h4>
          <p>Please wait while we load the course content.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('layout.userfooter')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Details Modal Script
  const detailsModal = document.getElementById('detailsModal');
  detailsModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const courseId = button.getAttribute('data-course-id');
    const modalTitle = detailsModal.querySelector('#courseTitle');
    const modalDescription = detailsModal.querySelector('#courseDescription');

    // Show loading placeholders
    modalTitle.textContent = 'Loading...';
    modalDescription.textContent = 'Please wait while we fetch the course details.';

    // Fetch course details
    fetch(`/my-courses/${courseId}`)
      .then(response => response.json())
      .then(data => {
        modalTitle.textContent = data.title;
        modalDescription.textContent = data.description;
      })
      .catch(() => {
        modalTitle.textContent = 'Error';
        modalDescription.textContent = 'Failed to load course details. Please try again.';
      });
  });

  // Video Modal Script
  const courseVideoModal = document.getElementById('courseVideoModal');
  const videoPlayer = document.getElementById('courseVideo');
  const videoSource = document.getElementById('videoSource');
  const videoTitle = courseVideoModal.querySelector('#videoTitle');
  const courseDescription = courseVideoModal.querySelector('#courseDescription');

  courseVideoModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const courseId = button.getAttribute('data-course-id');

    // Reset modal content
    videoTitle.textContent = 'Loading...';
    courseDescription.textContent = 'Please wait while we load the course content.';
    videoSource.src = ''; // Reset video source
    videoPlayer.load(); // Clear previous video

    // Fetch course video data
    fetch(`/my-courses/${courseId}`)
      .then(response => response.json())
      .then(data => {
        videoTitle.textContent = data.title;
        courseDescription.textContent = data.description;
        videoSource.src = `/storage/courses/videos/${data.video}`; // Use your actual asset path structure
        videoPlayer.load(); // Load the new video
      })
      .catch(() => {
        videoTitle.textContent = 'Error';
        courseDescription.textContent = 'Failed to load course content. Please try again.';
      });
  });

  // Pause the video when modal is closed
  courseVideoModal.addEventListener('hide.bs.modal', function () {
    videoPlayer.pause();
  });
});
</script>

</body>
</html>
