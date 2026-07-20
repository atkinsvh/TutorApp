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
    <title>Messages - Tutor GoodVibez Life</title>
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
                <li><a href="messages.php" class="active">Messages</a></li>
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
                <a href="messages.php" class="active">Messages</a>
                <a href="calendar.php">Calendar</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <div class="page-header">
                <h2>Messages</h2>
                <button class="btn btn-primary">New Message</button>
            </div>
            
            <div class="messages-container">
                <div class="messages-sidebar">
                    <div class="message-thread active">
                        <div class="thread-avatar">DS</div>
                        <div class="thread-info">
                            <h4>Dr. Smith</h4>
                            <p>Mathematics Tutor</p>
                            <span class="thread-time">2 hours ago</span>
                        </div>
                    </div>
                    
                    <div class="message-thread">
                        <div class="thread-avatar">PJ</div>
                        <div class="thread-info">
                            <h4>Prof. Johnson</h4>
                            <p>Biology Tutor</p>
                            <span class="thread-time">1 day ago</span>
                        </div>
                    </div>
                    
                    <div class="message-thread">
                        <div class="thread-avatar">MS</div>
                        <div class="thread-info">
                            <h4>Mrs. Sarah</h4>
                            <p>English Tutor</p>
                            <span class="thread-time">3 days ago</span>
                        </div>
                    </div>
                </div>
                
                <div class="messages-main">
                    <div class="message-header">
                        <h3>Dr. Smith</h3>
                        <span>Mathematics Tutor</span>
                    </div>
                    
                    <div class="message-list">
                        <div class="message sent">
                            <p>Hi Dr. Smith, I have a question about the quadratic formula from today's lesson.</p>
                            <span class="message-time">2:30 PM</span>
                        </div>
                        
                        <div class="message received">
                            <p>Of course! What specifically would you like me to clarify?</p>
                            <span class="message-time">2:45 PM</span>
                        </div>
                        
                        <div class="message sent">
                            <p>I'm confused about when to use the discriminant to determine the number of solutions.</p>
                            <span class="message-time">3:00 PM</span>
                        </div>
                        
                        <div class="message received">
                            <p>Great question! The discriminant (b²-4ac) tells us: if it's positive, we have 2 real solutions; if zero, 1 real solution; if negative, no real solutions (complex instead).</p>
                            <span class="message-time">3:15 PM</span>
                        </div>
                        
                        <div class="message sent">
                            <p>That makes sense! Thank you so much for explaining.</p>
                            <span class="message-time">3:20 PM</span>
                        </div>
                    </div>
                    
                    <div class="message-input">
                        <input type="text" placeholder="Type your message...">
                        <button class="btn btn-primary">Send</button>
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
