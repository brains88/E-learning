@include('layout.header')

<style>
    .container {
        margin-left:250px !important; /* Adjust for sidebar width */
        margin-top: 20px;
        padding-right: 15px; /* Prevent horizontal overflow */
        overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* To avoid horizontal scrolling */
    body {
        overflow-x: hidden;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            margin-left: 0 !important; /* Remove sidebar margin for small screens */
            width: 100%; /* Ensure content takes full width */
        }
    }

    /* Adjust for modal dialogs */
    .modal-dialog {
        max-width: 90%;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

@include('layout.adminnavbar')

<!-- Page Header -->
<div class="header">
    <h4>Courses</h4>
    <div class="profile">
        <span>Admin</span>
    </div>
</div>

<!-- Main Content -->
<div class="container mt-4">
    <h2>Manage Courses</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Create Course Button -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#courseModal">Create New Course</button>

    <!-- Course Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="font-weight:bold">Course Title</th>
                    <th style="font-weight:bold">Description</th>
                    <th style="font-weight:bold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ Str::limit($course->description, 50) }}</td>
                        <td>
                            <!-- View Button -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewCourseModal" 
                                    data-id="{{ $course->id }}" data-title="{{ $course->title }}" 
                                    data-description="{{ $course->description }}">View</button>

                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#courseModal" 
                                    data-id="{{ $course->id }}" data-title="{{ $course->title }}" 
                                    data-description="{{ $course->description }}" data-action="edit">Edit</button>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- View Course Modal -->
<div class="modal fade" id="viewCourseModal" tabindex="-1" role="dialog" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCourseModalLabel">View Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="mb-4">Title:</strong> <span id="courseTitle"></span><br>
                <strong class="mb-4">Description:</strong> <span id="courseDescription"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create/Edit Course Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="courseModalLabel">Create New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Course Form -->
                <form id="createCourseForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.courses.store') }}">
                    @csrf
                    <div class="row">
                        <!-- Left Column: Course Details -->
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="title">Course Title</label>
                                <input type="text" name="title" class="form-control" id="title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="course_image">Course Image</label>
                                <input type="file" name="course_image" class="form-control-file" id="course_image">
                            </div>
                            <div class="form-group">
                                <label for="video">Course Video</label>
                                <input type="file" name="video" class="form-control-file" id="video">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="active">Active</option>
                                    <option value="paused">Paused</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column: Quiz Details -->
                        <div class="col-12 col-md-6">
                            <p>Fill Quiz Area or leave blank and edit later.</p>

                            <!-- Quiz Question -->
                            <div class="form-group">
                                <label for="question">Enter Quiz Question</label>
                                <textarea name="question" class="form-control" id="question" rows="3"></textarea>
                            </div>

                            <!-- Quiz Answer -->
                            <div class="form-group">
                                <label for="answer">Enter Quiz Answer</label>
                                <textarea name="answer" class="form-control" id="answer" rows="2"></textarea>
                            </div>

                            <!-- Quiz Options (for multiple-choice)
                            <div class="form-group">
                                <label for="options">Enter Quiz Options (comma separated)</label>
                                <input type="text" name="options" class="form-control" id="options" placeholder="Option 1, Option 2, Option 3, Option 4">
                            </div>
                             -->
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Create Course</button>
                </form>

                <!-- Edit Course Form (Hidden by default) -->
                <form id="editCourseForm" method="POST" enctype="multipart/form-data" style="display:none">
                    @csrf
                    @method('Post')
                    <div class="row">
                        <!-- Left Column: Course Details -->
                        <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="edit_title">Course Title</label>
                        <input type="text" name="title" class="form-control" id="edit_title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea name="description" class="form-control" id="edit_description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_course_image">Course Image</label>
                        <input type="file" name="course_image" class="form-control-file" id="edit_course_image">
                    </div>
                    <div class="form-group">
                        <label for="edit_video">Course Video</label>
                        <input type="file" name="video" class="form-control-file" id="edit_video">
                    </div>
                    <div class="form-group">
                        <label for="edit_status">Status</label>
                        <select name="status" class="form-control" id="edit_status" required>
                            <option value="active">Active</option>
                            <option value="paused">Paused</option>
                        </select>
                    </div>
                    </div>
                    <!-- Right Column: Quiz Details -->
                    <div class="col-12 col-md-6">
                            <p>Fill Quiz Area or leave blank and edit later.</p>

                            <!-- Quiz Question -->
                            <div class="form-group">
                                <label for="question">Enter Quiz Question</label>
                                <textarea name="question" class="form-control" id="question" rows="3"></textarea>
                            </div>

                            <!-- Quiz Answer -->
                            <div class="form-group">
                                <label for="answer">Enter Quiz Answer</label>
                                <textarea name="answer" class="form-control" id="answer" rows="2"></textarea>
                            </div>

                            <!-- Quiz Options (for multiple-choice)
                            <div class="form-group">
                                <label for="options">Enter Quiz Options (comma separated)</label>
                                <input type="text" name="options" class="form-control" id="options" placeholder="Option 1, Option 2, Option 3, Option 4">
                            </div>
                             -->
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning mt-4 w-100">Update Course</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('layout.userfooter')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Populate view modal with course details
    $('#viewCourseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var courseTitle = button.data('title');
        var courseDescription = button.data('description');

        var modal = $(this);
        modal.find('#courseTitle').text(courseTitle);
        modal.find('#courseDescription').text(courseDescription);
    });

    // Open Edit/Create modal with appropriate data
    $('#courseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var action = button.data('action');
        
        var modal = $(this);
        if (action === 'edit') {
            var courseId = button.data('id');
            var courseTitle = button.data('title');
            var courseDescription = button.data('description');
            var courseStatus = button.data('status');

            modal.find('.modal-title').text('Edit Course');
            modal.find('#createCourseForm').hide();
            modal.find('#editCourseForm').show();
            modal.find('#edit_title').val(courseTitle);
            modal.find('#edit_description').val(courseDescription);
            modal.find('#edit_status').val(courseStatus);
            modal.find('form#editCourseForm').attr('action', '/admin/courses/update/' + courseId);
        } else {
            modal.find('.modal-title').text('Create New Course');
            modal.find('#createCourseForm').show();
            modal.find('#editCourseForm').hide();
            modal.find('form#editCourseForm').attr('action', '');
        }
    });

    // Reset modal form after submission or closure
    $('#courseModal').on('hidden.bs.modal', function () {
        var modal = $(this);
        modal.find('form').trigger('reset'); // Reset the form fields
    });
</script>
