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
    <title>Settings - Tutor GoodVibez Life</title>
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
                <li><a href="settings.php" class="active">Settings</a></li>
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
                <a href="settings.php" class="active">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <h2>Account Settings</h2>
            
            <div class="settings-section">
                <h3>Notification Preferences</h3>
                <form action="api/settings.php" method="POST">
                    <input type="hidden" name="action" value="update_notifications">
                    
                    <div class="setting-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="email_notifications" checked>
                            Email notifications for new assignments
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="message_notifications" checked>
                            Email notifications for new messages
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="calendar_reminders" checked>
                            Calendar event reminders
                        </label>
                    </div>
                    
                    <div class="setting-item">
                        <label class="checkbox-label">
                            <input type="checkbox" name="marketing_emails">
                            Marketing and promotional emails
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                </form>
            </div>
            
            <div class="settings-section">
                <h3>Change Password</h3>
                <form action="api/auth.php" method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required minlength="8">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_new_password">Confirm New Password</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
            
            <div class="settings-section danger-zone">
                <h3>Danger Zone</h3>
                <p>Once you delete your account, there is no going back. Please be certain.</p>
                <button class="btn btn-danger">Delete Account</button>
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
