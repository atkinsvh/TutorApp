<?php
/**
 * Tutor GoodVibez Life - Admin Dashboard
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Require admin role
requireRole(ROLE_ADMIN);

$currentUser = getCurrentUser();
$userId = getCurrentUserId();

// Get platform statistics
$totalUsers = fetchOne("SELECT COUNT(*) as count FROM users")['count'];
$totalStudents = fetchOne("SELECT COUNT(*) as count FROM users WHERE role = 'student'")['count'];
$totalTutors = fetchOne("SELECT COUNT(*) as count FROM users WHERE role = 'tutor'")['count'];
$totalParents = fetchOne("SELECT COUNT(*) as count FROM users WHERE role = 'parent'")['count'];
$pendingApplications = fetchOne("SELECT COUNT(*) as count FROM tutor_profiles WHERE application_status = 'pending'")['count'];
$totalAssignments = fetchOne("SELECT COUNT(*) as count FROM assignments")['count'];

// Get recent tutor applications
$recentApplications = fetchAll(
    "SELECT tp.*, CONCAT(u.first_name, ' ', u.last_name) as applicant_name, u.email
     FROM tutor_profiles tp
     JOIN users u ON tp.user_id = u.id
     WHERE tp.application_status = 'pending'
     ORDER BY tp.application_date DESC
     LIMIT 5"
);

// Get recent activity
$recentActivity = fetchAll(
    "SELECT al.*, CONCAT(u.first_name, ' ', u.last_name) as user_name
     FROM activity_log al
     LEFT JOIN users u ON al.user_id = u.id
     ORDER BY al.created_at DESC
     LIMIT 10"
);

$pageTitle = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo APP_NAME; ?></title>
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
                <li><a href="../admin/settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <?php require_once __DIR__ . '/../includes/navigation.php'; ?>
        
        <div class="dashboard-main">
            <div id="warmWelcome" 
                 data-user-role="admin" 
                 data-user-name="<?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>">
            </div>
            
            <div class="admin-stats">
                <div class="stat-card">
                    <h4>Total Users</h4>
                    <p class="stat-value"><?php echo number_format($totalUsers); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Students</h4>
                    <p class="stat-value"><?php echo number_format($totalStudents); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Tutors</h4>
                    <p class="stat-value"><?php echo number_format($totalTutors); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Parents</h4>
                    <p class="stat-value"><?php echo number_format($totalParents); ?></p>
                </div>
                <div class="stat-card warning">
                    <h4>Pending Applications</h4>
                    <p class="stat-value"><?php echo number_format($pendingApplications); ?></p>
                    <?php if ($pendingApplications > 0): ?>
                        <a href="../admin/tutor-applications.php" class="btn btn-small">Review</a>
                    <?php endif; ?>
                </div>
                <div class="stat-card">
                    <h4>Total Assignments</h4>
                    <p class="stat-value"><?php echo number_format($totalAssignments); ?></p>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>Pending Tutor Applications</h3>
                    <?php if (!empty($recentApplications)): ?>
                        <ul class="application-list">
                            <?php foreach ($recentApplications as $app): ?>
                                <li class="application-item">
                                    <div class="applicant-info">
                                        <h4><?php echo htmlspecialchars($app['applicant_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($app['email']); ?></p>
                                        <p class="application-date">Applied: <?php echo timeAgo($app['application_date']); ?></p>
                                    </div>
                                    <a href="../admin/tutor-applications.php?id=<?php echo $app['user_id']; ?>" class="btn btn-small">Review</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="empty-state">No pending applications.</p>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Recent Activity</h3>
                    <?php if (!empty($recentActivity)): ?>
                        <ul class="activity-list">
                            <?php foreach ($recentActivity as $activity): ?>
                                <li class="activity-item">
                                    <span class="activity-action"><?php echo htmlspecialchars($activity['action']); ?></span>
                                    <span class="activity-user"><?php echo htmlspecialchars($activity['user_name'] ?? 'System'); ?></span>
                                    <span class="activity-time"><?php echo timeAgo($activity['created_at']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="empty-state">No recent activity.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="quick-actions">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="../admin/users.php" class="btn btn-primary">Manage Users</a>
                    <a href="../admin/tutor-applications.php" class="btn btn-secondary">Review Applications</a>
                    <a href="../admin/subjects.php" class="btn btn-secondary">Manage Subjects</a>
                    <a href="../admin/pricing.php" class="btn btn-secondary">Manage Pricing</a>
                    <a href="../admin/settings.php" class="btn btn-secondary">Settings</a>
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
