<?php
/**
 * Tutor GoodVibez Life - Parent Dashboard
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Require parent role
requireRole(ROLE_PARENT);

$currentUser = getCurrentUser();
$userId = getCurrentUserId();

// Get linked students
$linkedStudents = fetchAll(
    "SELECT u.id, u.first_name, u.last_name, psl.relationship_type
     FROM parent_student_links psl
     JOIN users u ON psl.student_user_id = u.id
     WHERE psl.parent_user_id = ? AND psl.is_verified = 1
     ORDER BY u.first_name ASC",
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

$pageTitle = 'Parent Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard - <?php echo APP_NAME; ?></title>
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
                 data-user-role="parent" 
                 data-user-name="<?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>">
            </div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card full-width">
                    <h3>My Students</h3>
                    <?php if (!empty($linkedStudents)): ?>
                        <div class="students-overview">
                            <?php foreach ($linkedStudents as $student): ?>
                                <div class="student-card">
                                    <div class="avatar"><?php echo getInitials($student['first_name'], $student['last_name']); ?></div>
                                    <div class="student-info">
                                        <h4><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h4>
                                        <p class="relationship"><?php echo ucfirst($student['relationship_type']); ?></p>
                                        <a href="../parent/students.php?id=<?php echo $student['id']; ?>" class="btn btn-secondary">View Progress</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="empty-state">No students linked to your account yet.</p>
                        <p>Contact support to link your student's account.</p>
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
                        <a href="../parent/messages.php" class="btn btn-secondary">View All</a>
                    <?php else: ?>
                        <p class="empty-state">No messages yet.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Quick Links</h3>
                    <ul class="quick-links">
                        <li><a href="../parent/assignments.php">View Assignments</a></li>
                        <li><a href="../parent/calendar.php">Calendar</a></li>
                        <li><a href="../parent/statistics.php">Progress Statistics</a></li>
                        <li><a href="../parent/payments.php">Payment Status</a></li>
                    </ul>
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
