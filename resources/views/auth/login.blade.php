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
                            <h2>Login</h2> 
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
                <img src="assets/img/slider/slider1.jpg" alt="login Image" style="width:100%; height:100%">
            </div>
            <div class="col-md-6 text-center">
                <div class="login">
                    <div class="login-form-container" style="background-color:#2c2b5e !important; color:white">
                        <div class="login-text">
                            <h2 class="text-white">Login</h2>
                            <span>Please login using account details below.</span>
                        </div>
                        <div class="login-form">
                            <form id="loginForm">
                                @csrf <!-- CSRF Token -->
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="password" name="password" placeholder="Password" required>
                                <div class="button-box">
                                    <div class="login-toggle-btn">
                                        <input type="checkbox" id="remember">
                                        <label for="remember" class="text-white">Remember me</label>
                                        <a href="#" class="text-white">Forgot Password?</a>
                                    </div>
                                    <button type="submit" class="default-btn" style="color:#fff; border-color:#fff;">
                                        <span id="spinner" class="spinner-border spinner-border-sm d-none"></span> Login
                                    </button>
                                    <!-- Alert container to show error or success messages -->
                                    <div id="alertContainer" class="mt-3"></div>
                                    <div class="mt-2 text-center">
                                        <p class="text-white" style="font-size:18px">Are you new? <a href="{{route('register')}}" style="color:#EC1C23">Signup</a></p>
                                    </div>
                                </div>
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
document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Prevent default form submission

    const form = this;
    const formData = new FormData(form);
    const spinner = document.getElementById('spinner');
    const alertContainer = document.getElementById('alertContainer');

    // Show spinner
    spinner.classList.remove('d-none');

    // Clear previous alert messages
    alertContainer.innerHTML = '';

    // Submit form data via fetch
    fetch("{{ route('login') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Log the data for debugging purposes
        spinner.classList.add('d-none');  // Hide spinner

        if (data.success) {
            // Show success message
            alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;

            // Redirect to dashboard or appropriate page
            setTimeout(() => {
                window.location.href = data.redirect || '/dashboard'; // Redirect to dashboard or provided URL
            }, 2000);
        } else {
            // Show error message
            alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        spinner.classList.add('d-none');  // Hide spinner on error
        console.error(error);  // Log the error to the console for debugging
        alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
    });
});
</script>
</body>
