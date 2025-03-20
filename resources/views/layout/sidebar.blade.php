<style>
  /* Sidebar */
  .sidebar {
    background-color: #2C2B5E;
    color: #fff;
    width: 250px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100%;
    transition: transform 0.3s ease;
    z-index: 1000;
  }

  .sidebar h2 {
    font-size: 22px;
    margin-bottom: 30px;
    text-align: center;
  }

  .sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .sidebar ul li {
    margin: 20px 0;
  }

  .sidebar ul li a {
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .sidebar ul li a:hover {
    background-color: #44429d;
    color: #ffc107;
  }

  .sidebar ul li a.active {
    background-color: #ffc107;
    color: #2C2B5E;
    font-weight: bold;
  }

  .sidebar ul li a i {
    margin-right: 10px;
  }

  /* Hamburger */
  .hamburger {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: #2C2B5E;
    color: #fff;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1001;
  }

  /* Main Content */
  .main-content {
    flex: 1;
    margin-left: 250px;
    padding: 30px;
    background-color: #fff;
    transition: margin-left 0.3s ease;
  }

  /* Responsive Design */
  @media screen and (max-width: 768px) {
    .hamburger {
      display: block;
    }

    .sidebar {
      transform: translateX(-100%);
    }

    .main-content {
      margin-left: 0;
    }

    .sidebar.open {
      transform: translateX(0);
    }
  }
</style>

<div class="hamburger" onclick="toggleSidebar()">☰</div>
<div class="sidebar" id="sidebar">
  <h2 class="mt-4">EduNet</h2>
  <ul>
    <li><a href="{{route('user.dashboard')}}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fa fa-home"></i> Dashboard</a></li>
    <li><a href="{{route('user.my-courses')}}" class="{{ request()->routeIs('user.my-courses') ? 'active' : '' }}"><i class="fa fa-book"></i> My Courses</a></li>
    <li><a href="{{route('courses')}}" class="{{ request()->routeIs('courses') ? 'active' : '' }}"><i class="fa fa-book"></i> Enroll for Courses</a></li>
    <li><a href="{{route('user.quizzes')}}" class="{{ request()->routeIs('user.quizzes') ? 'active' : '' }}"><i class="fa fa-check-circle"></i> Quizzes</a></li>
    <!--
    <li><a href="{{route('user.progress')}}" class="{{ request()->routeIs('user.progress') ? 'active' : '' }}"><i class="fa fa-chart-line"></i> Progress</a></li>
    -->
    <li><a href="{{route('user.messages')}}" class="{{ request()->routeIs('user.messages') ? 'active' : '' }}"><i class="fa fa-envelope"></i> Messages</a></li>
    <li><a href="{{route('user.profile')}}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}"><i class="fa fa-user"></i> Profile</a></li>
    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</div>

<script>
  const sidebar = document.getElementById('sidebar');

  function toggleSidebar() {
    sidebar.classList.toggle('open');
  }
</script>
