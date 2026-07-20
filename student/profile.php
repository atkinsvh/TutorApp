<?php
/**
 * Tutor GoodVibez Life - Student Profile
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

// Get enrolled subjects
$enrolledSubjects = fetchAll(
    "SELECT s.name, ss.current_level, ss.target_level, ss.priority
     FROM student_subjects ss
     JOIN subjects s ON ss.subject_id = s.id
     WHERE ss.student_user_id = ?",
    [$userId]
);

// Get assigned tutor
$assignedTutor = fetchOne(
    "SELECT u.first_name, u.last_name, tp.bio, tp.hourly_rate, tp.experience_years
     FROM tutor_student_links tsl
     JOIN users u ON tsl.tutor_user_id = u.id
     LEFT JOIN tutor_profiles tp ON u.id = tp.user_id
     WHERE tsl.student_user_id = ? AND tsl.status = 'active'",
    [$userId]
);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!checkCSRFToken()) {
        setFlashMessage('error', 'Invalid security token.');
        redirect('profile.php');
    }
    
    // Update user data
    $firstName = sanitizePost('first_name');
    $lastName = sanitizePost('last_name');
    $email = sanitizePost('email');
    $phone = sanitizePost('phone');
    $gradeLevel = sanitizePost('grade_level');
    $schoolName = sanitizePost('school_name');
    $graduationYear = sanitizePost('graduation_year');
    $goals = sanitizePost('goals');
    
    // Update users table
    updateRecord('users', [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'phone' => $phone,
    ], 'id = ?', [$userId]);
    
    // Update or insert student profile
    if ($studentProfile) {
        updateRecord('student_profiles', [
            'grade_level' => $gradeLevel,
            'school_name' => $schoolName,
            'graduation_year' => $graduationYear,
            'goals' => $goals,
        ], 'user_id = ?', [$userId]);
    } else {
        insertRecord('student_profiles', [
            'user_id' => $userId,
            'grade_level' => $gradeLevel,
            'school_name' => $schoolName,
            'graduation_year' => $graduationYear,
            'goals' => $goals,
        ]);
    }
    
    setFlashMessage('success', 'Profile updated successfully.');
    redirect('profile.php');
}

// Get grade levels for dropdown
$gradeLevels = fetchAll("SELECT * FROM grade_levels ORDER BY sort_order ASC");

$pageTitle = 'My Profile';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo APP_NAME; ?></title>
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
                <li><a href="../dashboard.php">Dashboard</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="../settings.php">Settings</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <?php require_once __DIR__ . '/../includes/navigation.php'; ?>
        
        <div class="dashboard-main">
            <h2>My Profile</h2>
            
            <div class="profile-container">
                <div class="profile-card">
                    <h3>Personal Information</h3>
                    <form action="profile.php" method="POST" class="profile-form">
                        <?php echo getCSRFTokenField(); ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" 
                                       value="<?php echo htmlspecialchars($currentUser['first_name'] ?? ''); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" 
                                       value="<?php echo htmlspecialchars($currentUser['last_name'] ?? ''); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($currentUser['email'] ?? ''); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($currentUser['phone'] ?? ''); ?>">
                        </div>
                        
                        <h3 class="form-section">Academic Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="grade_level">Grade Level</label>
                                <select id="grade_level" name="grade_level">
                                    <option value="">Select Grade Level</option>
                                    <?php foreach ($gradeLevels as $level): ?>
                                        <option value="<?php echo $level['id']; ?>" 
                                                <?php echo ($studentProfile['grade_level'] ?? '') == $level['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($level['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="graduation_year">Graduation Year</label>
                                <input type="number" id="graduation_year" name="graduation_year" 
                                       value="<?php echo htmlspecialchars($studentProfile['graduation_year'] ?? ''); ?>"
                                       min="2024" max="2035">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="school_name">School Name</label>
                            <input type="text" id="school_name" name="school_name" 
                                   value="<?php echo htmlspecialchars($studentProfile['school_name'] ?? ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="goals">Academic Goals</label>
                            <textarea id="goals" name="goals" rows="4" 
                                      placeholder="Describe your academic goals and what you want to achieve..."><?php echo htmlspecialchars($studentProfile['goals'] ?? ''); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
                
                <div class="profile-sidebar">
                    <div class="profile-card">
                        <h3>My Tutor</h3>
                        <?php if ($assignedTutor): ?>
                            <div class="tutor-profile">
                                <div class="avatar large">
                                    <?php echo getInitials($assignedTutor['first_name'], $assignedTutor['last_name']); ?>
                                </div>
                                <h4><?php echo htmlspecialchars($assignedTutor['first_name'] . ' ' . $assignedTutor['last_name']); ?></h4>
                                <p class="tutor-rate"><?php echo formatCurrency($assignedTutor['hourly_rate']); ?>/hour</p>
                                <p class="tutor-experience"><?php echo $assignedTutor['experience_years']; ?> years experience</p>
                                <p class="tutor-bio"><?php echo htmlspecialchars($assignedTutor['bio'] ?? 'No bio available.'); ?></p>
                                <a href="../messages.php?tutor=<?php echo $assignedTutor['user_id'] ?? ''; ?>" class="btn btn-secondary">Message Tutor</a>
                            </div>
                        <?php else: ?>
                            <p class="empty-state">No tutor assigned yet.</p>
                            <a href="subjects.php" class="btn btn-primary">Find a Tutor</a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="profile-card">
                        <h3>My Subjects</h3>
                        <?php if (!empty($enrolledSubjects)): ?>
                            <ul class="subject-list">
                                <?php foreach ($enrolledSubjects as $subject): ?>
                                    <li class="subject-item">
                                        <span class="subject-name"><?php echo htmlspecialchars($subject['name']); ?></span>
                                        <span class="subject-level"><?php echo htmlspecialchars($subject['current_level'] ?? 'Beginner'); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="empty-state">No subjects enrolled yet.</p>
                        <?php endif; ?>
                        <a href="subjects.php" class="btn btn-secondary">Browse Subjects</a>
                    </div>
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
</body>
</html>
