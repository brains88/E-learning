@include('layout.header')

<body>
    @include('layout.navbar')

    <!-- Courses Area Start -->
    <div class="courses-area two pt-150 pb-150 text-center" style="margin-bottom: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <img src="assets/img/icon/section1.png" alt="section-title">
                        <h2>COURSES WE OFFER</h2>
                    </div>
                </div>
            </div>

            @if($courses->count() > 0)
            <div class="row">
                @foreach($courses as $course)
                <div class="col-lg-4 col-md-6 pb-5">
                    <div class="single-course" id="courseCard{{ $course->id }}">
                        <div class="course-content">
                            <h3><a href="javascript:void(0)" data-toggle="modal" data-target="#courseModal{{ $course->id }}">{{ $course->title }}</a></h3>
                            <p>{{ Str::limit($course->description, 100) }}</p>
                            <form action="javascript:void(0)" method="POST" id="enrollForm{{ $course->id }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                @auth
                                <button class="default-btn" id="enrollButton{{ $course->id }}" type="submit">Enroll Now</button>
                                <div class="spinner-border text-primary d-none" id="spinner{{ $course->id }}" role="status" style="width: 24px; height: 24px;">
                                    <span class="sr-only" style="color:#000">Loading...</span>
                                </div>
                                @endauth
                                @guest
                            <!-- If the user is not authenticated -->
                            <button class="default-btn" onclick="window.location.href='{{ route('login') }}'">Enroll Now</button>
                            @endguest
                            </form>
                            <div id="message{{ $course->id }}" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-warning text-white" role="alert">
                <div class="section-title">
                    <h3>No courses available at the moment.</h3>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Courses Area End -->

    <!-- Modal for Course Details -->
    @foreach($courses as $course)
    <div class="modal fade" id="courseModal{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseModalLabel{{ $course->id }}">{{ $course->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ $course->description }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @include('layout.footer')

    <script>
    @foreach($courses as $course)
document.getElementById('enrollForm{{ $course->id }}').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the form from submitting

    let button = document.getElementById('enrollButton{{ $course->id }}');
    let spinner = document.getElementById('spinner{{ $course->id }}');
    let messageBox = document.getElementById('message{{ $course->id }}');

    button.classList.add('d-none'); // Hide the Enroll button
    spinner.classList.remove('d-none'); // Show the spinner

    // Send AJAX request
    fetch("{{ route('enroll', $course->id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            course_id: {{ $course->id }}
        })
    })
    .then(response => {
        return response.json().then(data => {
            if (!response.ok) {
                // Handle validation or server errors
                throw data;
            }
            return data;
        });
    })
    .then(data => {
        // Display success message
        messageBox.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
    })
    .catch(error => {
        // Display dynamic error message if provided, otherwise show default message
        let errorMessage = error.message || 'An error occurred while enrolling.';
        messageBox.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
    })
    .finally(() => {
        // Reset button and spinner visibility
        button.classList.remove('d-none');
        spinner.classList.add('d-none');
    });
});
@endforeach
</script>

</body>
