<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - Tutor GoodVibez Life</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="dashboard.php"><h1>Tutor GoodVibez Life</h1></a>
            </div>
            <ul class="nav-links">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="assignments.php" class="active">Assignments</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <div class="dashboard-sidebar">
            <div class="user-profile">
                <div class="avatar">JS</div>
                <h3>John Student</h3>
                <p>Student</p>
            </div>
            <nav class="dashboard-nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="profile.php">Profile</a>
                <a href="subjects.php">My Subjects</a>
                <a href="assignments.php" class="active">Assignments</a>
                <a href="messages.php">Messages</a>
                <a href="calendar.php">Calendar</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <div class="page-header">
                <h2>My Assignments</h2>
                <button class="btn btn-primary">View All</button>
            </div>
            
            <div class="assignments-filter">
                <button class="filter-btn active">All</button>
                <button class="filter-btn">Pending</button>
                <button class="filter-btn">In Progress</button>
                <button class="filter-btn">Completed</button>
            </div>
            
            <div class="assignments-list">
                <div class="assignment-card">
                    <div class="assignment-status pending">Pending</div>
                    <h3>Algebra Worksheet #5</h3>
                    <p>Mathematics - Quadratic Equations</p>
                    <div class="assignment-meta">
                        <span>Due: Jan 25, 2026</span>
                        <span>Tutor: Dr. Smith</span>
                    </div>
                    <button class="btn btn-secondary">Start Assignment</button>
                </div>
                
                <div class="assignment-card">
                    <div class="assignment-status in-progress">In Progress</div>
                    <h3>Biology Lab Report</h3>
                    <p>Biology - Cell Division</p>
                    <div class="assignment-meta">
                        <span>Due: Jan 28, 2026</span>
                        <span>Tutor: Prof. Johnson</span>
                    </div>
                    <button class="btn btn-primary">Continue</button>
                </div>
                
                <div class="assignment-card">
                    <div class="assignment-status completed">Completed</div>
                    <h3>English Essay</h3>
                    <p>English - Literary Analysis</p>
                    <div class="assignment-meta">
                        <span>Submitted: Jan 20, 2026</span>
                        <span>Grade: A</span>
                    </div>
                    <button class="btn btn-secondary">View Feedback</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 Tutor GoodVibez Life. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
