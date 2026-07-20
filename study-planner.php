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
    <title>Study Planner - Tutor GoodVibez Life</title>
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
                <li><a href="study-planner.php" class="active">Study Planner</a></li>
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
                <a href="study-planner.php" class="active">Study Planner</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <div class="page-header">
                <h2>Study Planner</h2>
                <button class="btn btn-primary">Add Study Session</button>
            </div>
            
            <div class="planner-container">
                <div class="planner-section">
                    <h3>Today's Study Plan</h3>
                    <div class="study-items">
                        <div class="study-item completed">
                            <div class="study-checkbox">
                                <input type="checkbox" checked>
                            </div>
                            <div class="study-content">
                                <h4>Review Algebra Concepts</h4>
                                <p>Quadratic equations review - 30 minutes</p>
                            </div>
                            <span class="study-time">9:00 AM</span>
                        </div>
                        
                        <div class="study-item">
                            <div class="study-checkbox">
                                <input type="checkbox">
                            </div>
                            <div class="study-content">
                                <h4>Biology Lab Preparation</h4>
                                <p>Read lab manual chapters 4-5 - 45 minutes</p>
                            </div>
                            <span class="study-time">2:00 PM</span>
                        </div>
                        
                        <div class="study-item">
                            <div class="study-checkbox">
                                <input type="checkbox">
                            </div>
                            <div class="study-content">
                                <h4>English Essay Outline</h4>
                                <p>Create outline for literary analysis - 30 minutes</p>
                            </div>
                            <span class="study-time">4:30 PM</span>
                        </div>
                    </div>
                </div>
                
                <div class="planner-section">
                    <h3>Weekly Goals</h3>
                    <div class="goals-tracker">
                        <div class="goal">
                            <div class="goal-info">
                                <span class="goal-name">Math Practice</span>
                                <span class="goal-progress">3/5 sessions</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 60%"></div>
                            </div>
                        </div>
                        
                        <div class="goal">
                            <div class="goal-info">
                                <span class="goal-name">Reading Time</span>
                                <span class="goal-progress">2/4 hours</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 50%"></div>
                            </div>
                        </div>
                        
                        <div class="goal">
                            <div class="goal-info">
                                <span class="goal-name">Science Review</span>
                                <span class="goal-progress">1/3 chapters</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress" style="width: 33%"></div>
                            </div>
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
