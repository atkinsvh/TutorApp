<?php
/**
 * Tutor GoodVibez Life - Navigation Include
 * 
 * Role-based navigation sidebar.
 */

$currentPage = basename($_SERVER['PHP_SELF']);
$currentUser = getCurrentUser();
$role = getCurrentUserRole();

// Define navigation items for each role
$navigation = [
    'student' => [
        ['url' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => '📊'],
        ['url' => 'profile.php', 'label' => 'Profile', 'icon' => '👤'],
        ['url' => 'subjects.php', 'label' => 'My Subjects', 'icon' => '📚'],
        ['url' => 'assignments.php', 'label' => 'Assignments', 'icon' => '📝'],
        ['url' => 'ai-tutor.php', 'label' => 'AI Tutor', 'icon' => '🤖'],
        ['url' => 'ai-assignment-board.php', 'label' => 'AI Assignments', 'icon' => '📋'],
        ['url' => 'messages.php', 'label' => 'Messages', 'icon' => '✉️'],
        ['url' => 'calendar.php', 'label' => 'Calendar', 'icon' => '📅'],
        ['url' => 'study-planner.php', 'label' => 'Study Planner', 'icon' => '🎯'],
        ['url' => 'statistics.php', 'label' => 'Statistics', 'icon' => '📈'],
        ['url' => 'settings.php', 'label' => 'Settings', 'icon' => '⚙️'],
    ],
    'tutor' => [
        ['url' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => '📊'],
        ['url' => 'profile.php', 'label' => 'Profile', 'icon' => '👤'],
        ['url' => 'students.php', 'label' => 'Students', 'icon' => '👥'],
        ['url' => 'invite-students.php', 'label' => 'Invite Students', 'icon' => '📨'],
        ['url' => 'subjects.php', 'label' => 'Subjects', 'icon' => '📚'],
        ['url' => 'assignments.php', 'label' => 'Assignments', 'icon' => '📝'],
        ['url' => 'ai-assistant.php', 'label' => 'AI Assistant', 'icon' => '🤖'],
        ['url' => 'ai-assignment-board.php', 'label' => 'AI Assignments', 'icon' => '📋'],
        ['url' => 'messages.php', 'label' => 'Messages', 'icon' => '✉️'],
        ['url' => 'calendar.php', 'label' => 'Calendar', 'icon' => '📅'],
        ['url' => 'payments.php', 'label' => 'Payments', 'icon' => '💰'],
        ['url' => 'payouts.php', 'label' => 'Payouts', 'icon' => '🏦'],
        ['url' => 'settings.php', 'label' => 'Settings', 'icon' => '⚙️'],
    ],
    'parent' => [
        ['url' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => '📊'],
        ['url' => 'students.php', 'label' => 'My Students', 'icon' => '👨‍👩‍👧'],
        ['url' => 'assignments.php', 'label' => 'Assignments', 'icon' => '📝'],
        ['url' => 'calendar.php', 'label' => 'Calendar', 'icon' => '📅'],
        ['url' => 'statistics.php', 'label' => 'Statistics', 'icon' => '📈'],
        ['url' => 'messages.php', 'label' => 'Messages', 'icon' => '✉️'],
        ['url' => 'payments.php', 'label' => 'Payments', 'icon' => '💰'],
        ['url' => 'settings.php', 'label' => 'Settings', 'icon' => '⚙️'],
    ],
    'admin' => [
        ['url' => 'dashboard.php', 'label' => 'Dashboard', 'icon' => '📊'],
        ['url' => 'users.php', 'label' => 'Users', 'icon' => '👥'],
        ['url' => 'tutor-applications.php', 'label' => 'Tutor Applications', 'icon' => '📋'],
        ['url' => 'tutors.php', 'label' => 'Tutors', 'icon' => '👨‍🏫'],
        ['url' => 'students.php', 'label' => 'Students', 'icon' => '🎓'],
        ['url' => 'parents.php', 'label' => 'Parents', 'icon' => '👨‍👩‍👧'],
        ['url' => 'subjects.php', 'label' => 'Subjects', 'icon' => '📚'],
        ['url' => 'grade-levels.php', 'label' => 'Grade Levels', 'icon' => '📊'],
        ['url' => 'pricing.php', 'label' => 'Pricing', 'icon' => '💰'],
        ['url' => 'payments.php', 'label' => 'Payments', 'icon' => '💳'],
        ['url' => 'payouts.php', 'label' => 'Payouts', 'icon' => '🏦'],
        ['url' => 'ai-settings.php', 'label' => 'AI Settings', 'icon' => '🤖'],
        ['url' => 'ai-assignment-board.php', 'label' => 'AI Assignments', 'icon' => '📋'],
        ['url' => 'activity.php', 'label' => 'Activity Log', 'icon' => '📜'],
        ['url' => 'reports.php', 'label' => 'Reports', 'icon' => '📈'],
        ['url' => 'settings.php', 'label' => 'Settings', 'icon' => '⚙️'],
    ],
];

$navItems = $navigation[$role] ?? $navigation['student'];

// Get user initials for avatar
$initials = getInitials($currentUser['first_name'] ?? '', $currentUser['last_name'] ?? '');
$displayName = trim(($currentUser['first_name'] ?? '') . ' ' . ($currentUser['last_name'] ?? ''));
$roleDisplay = getRoleDisplayName($role);
?>

<aside class="dashboard-sidebar">
    <div class="user-profile">
        <div class="avatar"><?php echo $initials; ?></div>
        <h3><?php echo $displayName ?: 'User'; ?></h3>
        <p><?php echo $roleDisplay; ?></p>
    </div>
    
    <nav class="dashboard-nav">
        <?php foreach ($navItems as $item): ?>
            <a href="<?php echo getAppUrl($item['url']); ?>" 
               class="<?php echo $currentPage === $item['url'] ? 'active' : ''; ?>">
                <span class="nav-icon"><?php echo $item['icon']; ?></span>
                <?php echo $item['label']; ?>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
