@include('layout.header')

<style>
    body {
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: row;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        flex: 0 0 250px;
        background-color: #2C2B5E;
        color: #fff;
        height: 100vh;
        overflow-y: auto;
        padding: 20px;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        padding: 20px;
    }

    .progress-dashboard {
        font-family: 'Inter', sans-serif;
        color: #2C2B5E;
        padding: 20px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 28px;
        margin: 0;
    }

    .header p {
        font-size: 16px;
        color: #6c757d;
        margin-top: 5px;
    }

    .progress-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .progress-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .progress-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .progress-card h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #2C2B5E;
    }

    .progress-bar-container {
        width: 100%;
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
        margin: 15px 0;
        height: 15px;
    }

    .progress-bar {
        height: 100%;
        background-color: #2C2B5E;
        width: 0;
        transition: width 0.5s ease-in-out;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
    }

    .progress-info span {
        font-size: 14px;
        color: #6c757d;
    }

    .start-learning-btn {
        background-color: #2C2B5E;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .start-learning-btn:hover {
        background-color: #44429d;
    }
</style>

<body>
@include('layout.sidebar') <!-- Sidebar included -->
<div class="main-content">
    <div class="progress-dashboard">
        <div class="header">
            <h1>My Progress</h1>
            <p>Track your learning journey and achievements.</p>
        </div>

        <div class="progress-container">
            <!-- Example of Progress Card -->
            <div class="progress-card">
                <h3>Course Title: Web Development Basics</h3>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 75%;"></div>
                </div>
                <div class="progress-info">
                    <span>75% Complete</span>
                    <span>15/20 Lessons</span>
                </div>
                <a href="#" class="start-learning-btn">Continue Learning</a>
            </div>

            <div class="progress-card">
                <h3>Course Title: Advanced JavaScript</h3>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 50%;"></div>
                </div>
                <div class="progress-info">
                    <span>50% Complete</span>
                    <span>10/20 Lessons</span>
                </div>
                <a href="#" class="start-learning-btn">Continue Learning</a>
            </div>

            <div class="progress-card">
                <h3>Course Title: UI/UX Design Fundamentals</h3>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: 90%;"></div>
                </div>
                <div class="progress-info">
                    <span>90% Complete</span>
                    <span>18/20 Lessons</span>
                </div>
                <a href="#" class="start-learning-btn">Continue Learning</a>
            </div>
        </div>
    </div>
</div>
@include('layout.userfooter')
</body>
