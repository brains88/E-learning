@include('layout.header')
<body>
@include('layout.navbar')
<!-- Banner Area Start -->
<div class="banner-area-wrapper">
            <div class="banner-area text-center">	
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="banner-content-wrapper">
                                <div class="banner-content">
                                    <h2>Create Account</h2> 
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
		<!-- Banner Area End -->
        <!-- Login start -->
        <div class="login-area mt-5 mb-4">
            <div class="container">
                <div class="row">
                <div class="col-md-6 text-center">
                    <img src="assets/img/slider/slider1.jpg" alt="login Image" style="width:100%; height:100%; object-fit:cover">
                </div>
                    <div class="col-md-6 text-center">
                        <div class="login">
                            <div class="login-form-container"  style="background-color:#ec1c23 !important; color:white">
                                <div class="login-text">
                                    <h2 class="text-white">Create Account</h2>
                                    <span>Please the form below.</span>
                                </div>
                                <div class="login-form">
                                <form id="createAccountForm" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="name" placeholder="Full Name" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                <input type="text" name="country" placeholder="Country" required>
                                <input type="file" name="profile_image" required class="form-control">
                                <div class="button-box">
                                    <button type="submit" class="default-btn" style="color:#fff; border-color:#fff;">
                                        <span id="spinner" class="spinner-border spinner-border-sm d-none"></span> Register
                                    </button>
                                    <!-- Alert Placeholder -->
                                    <div id="alertContainer" class="mt-3"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             
        </div>
        <!-- Login end --> 
        @include('layout.footer')

<script>
document.getElementById('createAccountForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const spinner = document.getElementById('spinner');
    const alertContainer = document.getElementById('alertContainer');

    spinner.classList.remove('d-none');
    alertContainer.innerHTML = '';

    fetch("{{ route('register.store') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.classList.add('d-none');

        if (data.success) {
            // Show success message
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

            // Redirect to login page
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 2000);
        } else {
            // Show error messages
            if (data.errors) {
                alertContainer.innerHTML = data.errors.map(error => `<div class="alert alert-danger">${error}</div>`).join('');
            } else {
                alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        }
    })
    .catch(error => {
        spinner.classList.add('d-none');
        alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
    });
});


</script>
</body>