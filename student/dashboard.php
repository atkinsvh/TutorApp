<?php
/**
 * Tutor GoodVibez Life - Student Dashboard
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Require student role
requireRole(ROLE_STUDENT);

$currentUser = getCurrentUser();
$userId = getCurrentUserId();

// Get student profile
$studentProfile = fetchOne("SELECT * FROM student_profiles WHERE user_id = ?", [$userId]);

// Get upcoming assignments
$upcomingAssignments = fetchAll(
    "SELECT a.*, s.name as subject_name 
     FROM assignments a 
     LEFT JOIN subjects s ON a.subject_id = s.id 
     WHERE a.student_user_id = ? AND a.status IN ('assigned', 'in_progress')
     ORDER BY a.due_date ASC 
     LIMIT 5",
    [$userId]
);

// Get recent messages
$recentMessages = fetchAll(
    "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) as sender_name
     FROM messages m
     JOIN users u ON m.sender_user_id = u.id
     WHERE m.receiver_user_id = ?
     ORDER BY m.created_at DESC
     LIMIT 5",
    [$userId]
);

// Get upcoming calendar events
$upcomingEvents = fetchAll(
    "SELECT * FROM calendar_events 
     WHERE user_id = ? AND start_time >= NOW()
     ORDER BY start_time ASC
     LIMIT 5",
    [$userId]
);

// Get assigned tutor
$assignedTutor = fetchOne(
    "SELECT u.first_name, u.last_name, tp.bio, tp.hourly_rate
     FROM tutor_student_links tsl
     JOIN users u ON tsl.tutor_user_id = u.id
     LEFT JOIN tutor_profiles tp ON u.id = tp.user_id
     WHERE tsl.student_user_id = ? AND tsl.status = 'active'",
    [$userId]
);

$pageTitle = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="../dashboard.php"><h1><?php echo APP_NAME; ?></h1></a>
            </div>
            <ul class="nav-links">
                <li><a href="../dashboard.php" class="active">Dashboard</a></li>
                <li><a href="../messages.php">Messages</a></li>
                <li><a href="../settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <?php require_once __DIR__ . '/../includes/navigation.php'; ?>
        
        <div class="dashboard-main">
            <div id="warmWelcome" 
                 data-user-role="student" 
                 data-user-name="<?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>">
            </div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Tutor</h3>
                    <?php if ($assignedTutor): ?>
                        <div class="tutor-info">
                            <div class="avatar"><?php echo getInitials($assignedTutor['first_name'], $assignedTutor['last_name']); ?></div>
                            <div class="tutor-details">
                                <h4><?php echo htmlspecialchars($assignedTutor['first_name'] . ' ' . $assignedTutor['last_name']); ?></h4>
                                <p><?php echo htmlspecialchars($assignedTutor['bio'] ?? 'No bio available'); ?></p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="empty-state">No tutor assigned yet.</p>
                        <a href="../subjects.php" class="btn btn-secondary">Find a Tutor</a>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Upcoming Assignments</h3>
                    <?php if (!empty($upcomingAssignments)): ?>
                        <ul class="assignment-list">
                            <?php foreach ($upcomingAssignments as $assignment): ?>
                                <li class="assignment-item">
                                    <span class="assignment-title"><?php echo htmlspecialchars($assignment['title']); ?></span>
                                    <span class="assignment-subject"><?php echo htmlspecialchars($assignment['subject_name'] ?? 'General'); ?></span>
                                    <span class="assignment-due">Due: <?php echo formatDate($assignment['due_date']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../assignments.php" class="btn btn-secondary">View All</a>
                    <?php else: ?>
                        <p class="empty-state">No upcoming assignments.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Upcoming Events</h3>
                    <?php if (!empty($upcomingEvents)): ?>
                        <ul class="event-list">
                            <?php foreach ($upcomingEvents as $event): ?>
                                <li class="event-item">
                                    <span class="event-title"><?php echo htmlspecialchars($event['title']); ?></span>
                                    <span class="event-time"><?php echo formatDateTime($event['start_time']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../calendar.php" class="btn btn-secondary">View Calendar</a>
                    <?php else: ?>
                        <p class="empty-state">No upcoming events.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Recent Messages</h3>
                    <?php if (!empty($recentMessages)): ?>
                        <ul class="message-list">
                            <?php foreach ($recentMessages as $message): ?>
                                <li class="message-item">
                                    <span class="message-sender"><?php echo htmlspecialchars($message['sender_name']); ?></span>
                                    <span class="message-preview"><?php echo truncate($message['message_text'], 50); ?></span>
                                    <span class="message-time"><?php echo timeAgo($message['created_at']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../messages.php" class="btn btn-secondary">View All</a>
                    <?php else: ?>
                        <p class="empty-state">No messages yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="../assignments.php" class="btn btn-primary">View Assignments</a>
                    <a href="../ai-tutor.php" class="btn btn-secondary">AI Tutor</a>
                    <a href="../messages.php" class="btn btn-secondary">Send Message</a>
                    <a href="../study-planner.php" class="btn btn-secondary">Study Planner</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="../js/main.js"></script>
    <script src="../js/welcome.js"></script>
</body>
</html>
