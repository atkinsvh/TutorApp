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
    <title>Calendar - Tutor GoodVibez Life</title>
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
                <li><a href="calendar.php" class="active">Calendar</a></li>
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
                <a href="calendar.php" class="active">Calendar</a>
                <a href="settings.php">Settings</a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <div class="page-header">
                <h2>Calendar</h2>
                <button class="btn btn-primary">Add Event</button>
            </div>
            
            <div class="calendar-container">
                <div class="calendar-header">
                    <button class="btn btn-secondary">Previous</button>
                    <h3>January 2026</h3>
                    <button class="btn btn-secondary">Next</button>
                </div>
                
                <div class="calendar-grid">
                    <div class="calendar-day-header">Sun</div>
                    <div class="calendar-day-header">Mon</div>
                    <div class="calendar-day-header">Tue</div>
                    <div class="calendar-day-header">Wed</div>
                    <div class="calendar-day-header">Thu</div>
                    <div class="calendar-day-header">Fri</div>
                    <div class="calendar-day-header">Sat</div>
                    
                    <div class="calendar-day">28</div>
                    <div class="calendar-day">29</div>
                    <div class="calendar-day">30</div>
                    <div class="calendar-day">31</div>
                    <div class="calendar-day">1</div>
                    <div class="calendar-day">2</div>
                    <div class="calendar-day">3</div>
                    
                    <div class="calendar-day">4</div>
                    <div class="calendar-day">5</div>
                    <div class="calendar-day">6</div>
                    <div class="calendar-day">7</div>
                    <div class="calendar-day">8</div>
                    <div class="calendar-day">9</div>
                    <div class="calendar-day">10</div>
                    
                    <div class="calendar-day">11</div>
                    <div class="calendar-day">12</div>
                    <div class="calendar-day">13</div>
                    <div class="calendar-day">14</div>
                    <div class="calendar-day">15</div>
                    <div class="calendar-day">16</div>
                    <div class="calendar-day">17</div>
                    
                    <div class="calendar-day">18</div>
                    <div class="calendar-day current">19</div>
                    <div class="calendar-day">20</div>
                    <div class="calendar-day has-event">21</div>
                    <div class="calendar-day">22</div>
                    <div class="calendar-day">23</div>
                    <div class="calendar-day">24</div>
                    
                    <div class="calendar-day has-event">25</div>
                    <div class="calendar-day">26</div>
                    <div class="calendar-day">27</div>
                    <div class="calendar-day has-event">28</div>
                    <div class="calendar-day">29</div>
                    <div class="calendar-day">30</div>
                    <div class="calendar-day">31</div>
                </div>
            </div>
            
            <div class="upcoming-events">
                <h3>Upcoming Events</h3>
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">21</span>
                        <span class="month">Jan</span>
                    </div>
                    <div class="event-details">
                        <h4>Math Tutoring Session</h4>
                        <p>3:00 PM - 4:00 PM with Dr. Smith</p>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">25</span>
                        <span class="month">Jan</span>
                    </div>
                    <div class="event-details">
                        <h4>Algebra Assignment Due</h4>
                        <p>Worksheet #5 - Quadratic Equations</p>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">28</span>
                        <span class="month">Jan</span>
                    </div>
                    <div class="event-details">
                        <h4>Biology Lab Report Due</h4>
                        <p>Cell Division Experiment</p>
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
