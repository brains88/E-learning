<style>
/* public/css/dashboard.css */

/* General Styles */
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

.dashboard {
    display: flex;
    min-height: 100vh;
}

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

.sidebar.collapsed {
    transform: translateX(-100%);
}

.sidebar h2 {
    font-size: 22px;
    margin-bottom: 20px;
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar ul li a {
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    display: flex;
    align-items: center;
}

.sidebar ul li a:hover {
    color: #ffc107;
}

.sidebar ul li a i {
    margin-right: 10px;
}

 /* Main Content */
 .main-content {
      flex: 1;
      margin-left: 250px;
      padding: 30px;
      background-color: #fff;
      transition: margin-left 0.3s ease;
    }

    .main-content.collapsed {
      margin-left: 0;
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