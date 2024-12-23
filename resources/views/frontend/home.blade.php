@include('layout.header')
<body>
@include('layout.navbar')
    <!-- Background Area Start -->
    <section id="slider-container" class="slider-area two"> 
    <div class="slider-owl owl-theme owl-carousel"> 
        <!-- Start Single Slide -->
        <div class="single-slide item" style="background-image: url(assets/img/slider/slider2.jpg)">
            <div class="slider-content-area">  
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1"> 
                            <div class="slide-content-wrapper">
                                <div class="slide-content text-center">
                                    <h2>Learn Anytime, Anywhere</h2>
                                    <p>Discover interactive courses and quizzes designed to help you achieve your goals. Start your personalized education today!</p>
                                    <a class="default-btn" href="{{route('register')}}">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->

        <!-- Start Single Slide -->
        <div class="single-slide item" style="background-image: url(assets/img/slider/slider3.jpg)">
            <div class="slider-content-area">   
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1"> 
                            <div class="slide-content-wrapper">
                                <div class="slide-content text-center">
                                    <h2>Empower Your Learning Journey</h2>
                                    <p>Access a world of knowledge at your fingertips. Engage with real-time feedback and track your progress seamlessly.</p>
                                    <a class="default-btn" href="{{route('register')}}">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->

        <!-- Start Single Slide -->
        <div class="single-slide item" style="background-image: url(assets/img/slider/slider1.jpg)">
            <div class="slider-content-area">  
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1"> 
                            <div class="slide-content-wrapper">
                                <div class="slide-content text-center">
                                    <h2>Join Our Community</h2>
                                    <p>Connect with learners worldwide. Together, let's make education engaging and transformative.</p>
                                    <a class="default-btn" href="{{route('register')}}">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
</section>

		<!-- Background Area End -->
        <!-- Service Start -->
        <div class="service-area two pt-150 pb-150">
    <div class="container">
        <div class="row text-center">
            <!-- Single Service -->
            <div class="col-md-4">
                <div class="single-service">
                    <h3><a >Expert Instructors</a></h3>
                    <p>Learn from highly qualified teachers who are passionate about your success and well-versed in their subjects.</p>
                </div>
            </div>
            <!-- Single Service -->
            <div class="col-md-4">
                <div class="single-service">
                    <h3><a >Interactive Courses</a></h3>
                    <p>Engage with interactive quizzes, videos, and real-time feedback to enhance your learning experience.</p>
                </div>
            </div>
            <!-- Single Service -->
            <div class="col-md-4">
                <div class="single-service">
                    <h3><a>Track Your Progress</a></h3>
                    <p>Monitor your achievements and receive personalized recommendations to stay on the path to success.</p>
                </div>
            </div>
        </div>
        </div>
    </div>
        <!-- Service End -->
        <!-- About Start -->
        <div class="about-area pb-155">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="about-content">
                            <h2>WELCOME TO <span class="text-uppercase">E-Learning</span></h2>
                            <p>I must explain to you how all this mistaken idea of denouncing pleure and prsing pain was born and I will give you a complete account of the system, and expound the actual teachings  the master-builder of humanit happiness</p>
                            <p class="hidden-sm">I must explain to you how all this mistaken idea of denouncing pleure and prsing pain was born and I will give you a complete account of the system</p>
                            <a class="default-btn" href="{{route('courses')}}">view courses</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="about-img">
                            <img src="assets/img/about/about.png" alt="about">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
        <!-- Courses Area Start -->
        <div class="courses-area two pt-150 pb-150 text-center">
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
                        <div class="course-img">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#courseModal{{ $course->id }}">
                                <img src="{{ asset('storage/courses/images/' . $course->course_image) }}" alt="course" style="height:200px; object-fit:cover;">
                                <div class="course-hover">
                                    <i class="fa fa-link"></i>
                                </div>
                            </a>
                        </div>
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
        </section>
        <!-- Notice End -->
        <!-- Event Area Start -->
        <div class="event-area two text-center pt-100 pb-145">
            <div class="container">
                <div class="row">
                     <div class="col-12">
                        <div class="section-title">
                            <img src="assets/img/icon/section.png" alt="section-title">
                            <h2>UPCOMMING EVENTS</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-event mb-35">
                            <div class="event-img">
                                <a href="event-details.html"><img src="assets/img/event/event1.jpg" alt="event"></a>
                            </div>
                            <div class="event-content text-start">
                                <h3>20 June 2022</h3>
                                <h4><a href="event-details.html">ADVANCE PHP WORKSHOP</a></h4>
                                <ul>
                                    <li><i class="fa fa-clock-o"></i>9.00 AM - 4.45 PM</li>
                                    <li><i class="fa fa-map-marker"></i>New Yourk City</li>
                                </ul>
                                <div class="event-content-right">
                                    <a class="default-btn" href="event-details.html">join now</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-event mb-35 mb-md-0">
                            <div class="event-img">
                                <a href="event-details.html"><img src="assets/img/event/event3.jpg" alt="event"></a>
                            </div>
                            <div class="event-content text-start">
                                <h3>16 June 2022</h3>
                                <h4><a href="event-details.html">learning english history</a></h4>
                                <ul>
                                    <li><i class="fa fa-clock-o"></i>9.00 AM - 4.45 PM</li>
                                    <li><i class="fa fa-map-marker"></i>New Yourk City</li>
                                </ul>
                                <div class="event-content-right">
                                    <a class="default-btn" href="event-details.html">join now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-event mb-35">
                            <div class="event-img">
                                <a href="event-details.html"><img src="assets/img/event/event2.jpg" alt="event"></a>
                            </div>
                            <div class="event-content text-start">
                                <h3>18 June 2022</h3>
                                <h4><a href="event-details.html">DIGITAL MARKETING ANALYSIS</a></h4>
                                <ul>
                                    <li><i class="fa fa-clock-o"></i>9.00 AM - 4.45 PM</li>
                                    <li><i class="fa fa-map-marker"></i>New Yourk City</li>
                                </ul>
                                <div class="event-content-right">
                                    <a class="default-btn" href="event-details.html">join now</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-event">
                            <div class="event-img">
                                <a href="event-details.html"><img src="assets/img/event/event3.jpg" alt="event"></a>
                            </div>
                            <div class="event-content text-start">
                                <h3>14 June 2022</h3>
                                <h4><a href="event-details.html">UI & UX DESIGNER MEETUP</a></h4>
                                <ul>
                                    <li><i class="fa fa-clock-o"></i>9.00 AM - 4.45 PM</li>
                                    <li><i class="fa fa-map-marker"></i>New Yourk City</li>
                                </ul>
                                <div class="event-content-right">
                                    <a class="default-btn" href="event-details.html">join now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Area End -->
         @include('layout.footer')
         
         <script>
                $(document).ready(function() {
    $(".slider-owl").owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 5000, // 5 seconds
        autoplayHoverPause: true,
        items: 1
    });
});


// For script for Courses Card
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