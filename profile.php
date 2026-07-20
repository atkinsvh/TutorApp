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
    <title>Profile - Tutor GoodVibez Life</title>
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
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="settings.php">Settings</a></li>
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
                <a href="profile.php" class="active">Profile</a>
                <a href="subjects.php">My Subjects</a>
                <a href="assignments.php">Assignments</a>
                <a href="messages.php">Messages</a>
                <a href="calendar.php">Calendar</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <h2>My Profile</h2>
            
            <div class="profile-card">
                <h3>Personal Information</h3>
                <form action="api/profile.php" method="POST" class="profile-form">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="John" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="Student" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="john@example.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="(555) 123-4567">
                    </div>
                    
                    <div class="form-group">
                        <label for="grade_level">Grade Level</label>
                        <select id="grade_level" name="grade_level">
                            <option value="9">9th Grade</option>
                            <option value="10">10th Grade</option>
                            <option value="11" selected>11th Grade</option>
                            <option value="12">12th Grade</option>
                            <option value="college">College</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
            
            <div class="profile-card">
                <h3>Academic Goals</h3>
                <p>Track your learning objectives and academic milestones.</p>
                <div class="goals-list">
                    <div class="goal-item">
                        <span class="goal-title">Improve Math Score</span>
                        <span class="goal-progress">75%</span>
                    </div>
                    <div class="goal-item">
                        <span class="goal-title">Complete Physics Course</span>
                        <span class="goal-progress">60%</span>
                    </div>
                </div>
                <button class="btn btn-secondary">Add New Goal</button>
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
