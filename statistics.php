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
    <title>Statistics - Tutor GoodVibez Life</title>
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
                <li><a href="statistics.php" class="active">Statistics</a></li>
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
                <a href="assignments.php">Assignments</a>
                <a href="messages.php">Messages</a>
                <a href="calendar.php">Calendar</a>
                <a href="statistics.php" class="active">Statistics</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <h2>My Statistics</h2>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Overall Performance</h3>
                    <div class="stat-value">85%</div>
                    <p>Average Grade</p>
                </div>
                
                <div class="stat-card">
                    <h3>Assignments Completed</h3>
                    <div class="stat-value">24</div>
                    <p>This Semester</p>
                </div>
                
                <div class="stat-card">
                    <h3>Study Hours</h3>
                    <div class="stat-value">48</div>
                    <p>Total Hours</p>
                </div>
                
                <div class="stat-card">
                    <h3>Tutoring Sessions</h3>
                    <div class="stat-value">12</div>
                    <p>This Month</p>
                </div>
            </div>
            
            <div class="performance-chart">
                <h3>Subject Performance</h3>
                <div class="chart-bars">
                    <div class="chart-item">
                        <span class="subject">Mathematics</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 90%">90%</div>
                        </div>
                    </div>
                    <div class="chart-item">
                        <span class="subject">Biology</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 82%">82%</div>
                        </div>
                    </div>
                    <div class="chart-item">
                        <span class="subject">English</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 88%">88%</div>
                        </div>
                    </div>
                    <div class="chart-item">
                        <span class="subject">Physics</span>
                        <div class="bar-container">
                            <div class="bar" style="width: 78%">78%</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <span class="activity-icon">📝</span>
                        <div class="activity-details">
                            <p>Completed Algebra Worksheet #4</p>
                            <span class="activity-time">2 days ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <span class="activity-icon">🎓</span>
                        <div class="activity-details">
                            <p>Attended Biology Tutoring Session</p>
                            <span class="activity-time">3 days ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <span class="activity-icon">📊</span>
                        <div class="activity-details">
                            <p>Received grade for English Essay</p>
                            <span class="activity-time">5 days ago</span>
                        </div>
                    </div>
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
