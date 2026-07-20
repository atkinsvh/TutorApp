<?php
/**
 * Tutor GoodVibez Life - Tutor Dashboard
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Require tutor role
requireRole(ROLE_TUTOR);

$currentUser = getCurrentUser();
$userId = getCurrentUserId();

// Get tutor profile
$tutorProfile = fetchOne("SELECT * FROM tutor_profiles WHERE user_id = ?", [$userId]);

// Get assigned students
$assignedStudents = fetchAll(
    "SELECT u.id, u.first_name, u.last_name, u.email, tsl.status as link_status
     FROM tutor_student_links tsl
     JOIN users u ON tsl.student_user_id = u.id
     WHERE tsl.tutor_user_id = ? AND tsl.status = 'active'
     ORDER BY u.first_name ASC",
    [$userId]
);

// Get pending assignments to grade
$pendingGrades = fetchAll(
    "SELECT a.title, s.name as subject_name, a.due_date,
            COUNT(asub.id) as submission_count
     FROM assignments a
     LEFT JOIN subjects s ON a.subject_id = s.id
     LEFT JOIN assignment_submissions asub ON a.id = asub.assignment_id
     WHERE a.tutor_user_id = ? AND a.status = 'submitted'
     GROUP BY a.id
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

$pageTitle = 'Tutor Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard - <?php echo APP_NAME; ?></title>
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
                 data-user-role="tutor" 
                 data-user-name="<?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>">
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <h4>Total Students</h4>
                    <p class="stat-value"><?php echo count($assignedStudents); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Pending Reviews</h4>
                    <p class="stat-value"><?php echo count($pendingGrades); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Application Status</h4>
                    <p class="stat-value status-<?php echo $tutorProfile['application_status'] ?? 'pending'; ?>">
                        <?php echo ucfirst($tutorProfile['application_status'] ?? 'pending'); ?>
                    </p>
                </div>
                <div class="stat-card">
                    <h4>Hourly Rate</h4>
                    <p class="stat-value"><?php echo formatCurrency($tutorProfile['hourly_rate'] ?? 0); ?></p>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Students</h3>
                    <?php if (!empty($assignedStudents)): ?>
                        <ul class="student-list">
                            <?php foreach ($assignedStudents as $student): ?>
                                <li class="student-item">
                                    <div class="avatar small"><?php echo getInitials($student['first_name'], $student['last_name']); ?></div>
                                    <div class="student-info">
                                        <h4><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($student['email']); ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../tutor/students.php" class="btn btn-secondary">Manage Students</a>
                    <?php else: ?>
                        <p class="empty-state">No students yet. Start by inviting students!</p>
                        <a href="../tutor/invite-students.php" class="btn btn-primary">Invite Students</a>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Pending Reviews</h3>
                    <?php if (!empty($pendingGrades)): ?>
                        <ul class="assignment-list">
                            <?php foreach ($pendingGrades as $assignment): ?>
                                <li class="assignment-item">
                                    <span class="assignment-title"><?php echo htmlspecialchars($assignment['title']); ?></span>
                                    <span class="assignment-subject"><?php echo htmlspecialchars($assignment['subject_name'] ?? 'General'); ?></span>
                                    <span class="assignment-submissions"><?php echo $assignment['submission_count']; ?> submission(s)</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../tutor/submissions.php" class="btn btn-secondary">Review All</a>
                    <?php else: ?>
                        <p class="empty-state">No assignments to review.</p>
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
                        <a href="../tutor/calendar.php" class="btn btn-secondary">View Calendar</a>
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
                        <a href="../tutor/messages.php" class="btn btn-secondary">View All</a>
                    <?php else: ?>
                        <p class="empty-state">No messages yet.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="../tutor/create-assignment.php" class="btn btn-primary">Create Assignment</a>
                    <a href="../tutor/invite-students.php" class="btn btn-secondary">Invite Students</a>
                    <a href="../tutor/profile.php" class="btn btn-secondary">Edit Profile</a>
                    <a href="../tutor/ai-assistant.php" class="btn btn-secondary">AI Assistant</a>
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
