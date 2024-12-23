<style>

    /* Style the search form */
   /* Style the search form */
   #searchForm {
        display: none;
        position: absolute;
        top: 80px; /* Adjust for positioning below the navbar */
        left: 50%; /* Center horizontally */
        transform: translateX(-50%); /* Adjust centering */
        background: rgba(255, 255, 255, 0.8); /* Transparent white background */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 5px;
        z-index: 1000;
        backdrop-filter: blur(5px); /* Adds a blur effect for a modern look */
        text-align: center;
        width: 60%; /* Default width for larger screens */
    }

    #searchForm input {
        width: 80%; /* Adjust input width */
        padding: 10px;
        margin-bottom: 10px; /* Space below input field */
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 14px;
    }

    #searchForm button {
        padding: 8px 15px;
        background: #007bff; /* Button background color */
        color: white;
        border: none;
        border-radius: 3px;
        font-size: 14px;
        cursor: pointer;
        background-color:#ec1c23;
    }

    #searchForm button:hover {
        background: #0056b3; /* Darker blue on hover */
    }

/* Flexbox setup for the navbar */
.navbar {
    display: flex;
    align-items: center; /* Vertically center the items */
    justify-content: space-between; /* Distribute items evenly */
    list-style-type: none; /* Remove default list styling */
    padding: 0;
    margin: 0;
}

/* Styling for individual navbar items */
.navbar-item {
    margin-right: 15px; /* Space between the items */
}

/* Profile image styling for navbar */
.navbar-profile-img {
    width: 40px;            /* Set width */
    height: 40px;           /* Set height */
    object-fit: cover;      /* Ensure image doesn't get distorted */
    border-radius: 50%;     /* Make it circular */
    margin-top: 5px;        /* Add some space from top (optional) */
}


    /* Responsive Styling */
    @media (max-width: 767px) {
        #searchForm {
            top: 120px; /* Adjust for positioning below the navbar */
            width: 90%; /* Increase width for mobile */
        }

        #searchForm input {
            width: 100%; /* Full width input on mobile */
        }

        #searchForm button {
            width: 100%; /* Full width button on mobile */
            background-color:#ec1c23;
        }

        .header-top-left h2 {
            text-align: center; /* Center alignment for mobile */
            font-size: 22px;
            font-weight: 600;
        }
        .header-top-right ul li a {
            font-size: 17px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
        }
    }
</style>

<header class="top">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Left Section -->
                <div class="col-md-8 col-sm-8">
                    <div class="header-top-left">
                        <h2 class="text-uppercase">E-Learning</h2>
                    </div>
                </div>
                <!-- Right Section -->
                <div class="col-md-4 col-sm-4">
                    <div class="header-top-right text-md-end text-center">
                    <ul class="navbar">
                         <!-- Other authenticated user links -->
                         <li class="navbar-item"><a href="{{ route('home') }}"  class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                            <li class="navbar-item"><a href="{{ route('courses') }}"  class="{{ request()->routeIs('courses') ? 'active' : '' }}">Courses</a></li>
                        @if(auth()->check()) <!-- Check if the user is authenticated -->
                            <li class="navbar-item">
                                <!-- Profile Image that redirects to dashboard -->
                                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
                                    <img class="navbar-profile-img" 
                                        src="{{ auth()->user()->image ? asset('storage/profile_images/' . auth()->user()->image) : 'https://via.placeholder.com/40' }}" 
                                        alt="Profile Picture" />
                                </a>

                            </li>
                        @else
                            <!-- Login link if not authenticated -->
                            <li class="navbar-item"><a href="{{ route('login') }}"  class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a></li>
                        @endif
                        <!-- Search Icon
                        <li class="navbar-item">
                            <i class="fa fa-search" onclick="toggleSearch()" style="cursor: pointer;"></i>
                        </li>
                         -->
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<!-- Hidden Search Form -->
<div id="searchForm">
    <form action="#" method="GET">
        <input type="search" placeholder="Search here..." name="search" />
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<script>
    function toggleSearch() {
        const searchForm = document.getElementById('searchForm');
        if (searchForm.style.display === 'none' || !searchForm.style.display) {
            searchForm.style.display = 'block';
        } else {
            searchForm.style.display = 'none';
        }
    }


</script>
