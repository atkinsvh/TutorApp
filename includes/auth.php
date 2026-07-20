<?php
/**
 * Tutor GoodVibez Life - Authentication Functions
 * 
 * Handles user authentication, registration, and session management.
 */

session_start();

require_once __DIR__ . '/database.php';

/**
 * Hash a password
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify a password against a hash
 * 
 * @param string $password Plain text password
 * @param string $hash Hashed password
 * @return bool True if password matches
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Register a new user
 * 
 * @param array $userData User data (email, password, first_name, last_name, role)
 * @return int|false User ID on success, false on failure
 */
function registerUser($userData) {
    // Check if email already exists
    if (recordExists('users', 'email = ?', [$userData['email']])) {
        return false;
    }
    
    // Hash the password
    $userData['password_hash'] = hashPassword($userData['password']);
    unset($userData['password']);
    
    // Add timestamps
    $userData['created_at'] = date('Y-m-d H:i:s');
    $userData['updated_at'] = date('Y-m-d H:i:s');
    
    // Insert user
    $userId = insertRecord('users', $userData);
    
    // Create role-specific profile
    if ($userId) {
        createProfile($userId, $userData['role']);
    }
    
    return $userId;
}

/**
 * Create role-specific profile
 * 
 * @param int $userId User ID
 * @param string $role User role
 * @return bool Success status
 */
function createProfile($userId, $role) {
    switch ($role) {
        case 'student':
            return insertRecord('student_profiles', ['user_id' => $userId]) !== false;
            
        case 'tutor':
            return insertRecord('tutor_profiles', ['user_id' => $userId]) !== false;
            
        case 'parent':
            return insertRecord('parent_profiles', ['user_id' => $userId]) !== false;
            
        case 'admin':
            // Admin doesn't need a special profile
            return true;
            
        default:
            return false;
    }
}

/**
 * Login a user
 * 
 * @param string $email User email
 * @param string $password User password
 * @return array|false User data on success, false on failure
 */
function loginUser($email, $password) {
    // Get user by email
    $user = fetchOne("SELECT * FROM users WHERE email = ? AND is_active = 1", [$email]);
    
    if (!$user) {
        return false;
    }
    
    // Verify password
    if (!verifyPassword($password, $user['password_hash'])) {
        return false;
    }
    
    // Update last login
    updateRecord('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user['id']]);
    
    // Set session data
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['logged_in'] = true;
    
    // Remove sensitive data
    unset($user['password_hash']);
    unset($user['reset_token']);
    unset($user['reset_token_expires']);
    
    return $user;
}

/**
 * Logout the current user
 */
function logoutUser() {
    session_unset();
    session_destroy();
    
    // Start a new session for any flash messages
    session_start();
}

/**
 * Check if user is logged in
 * 
 * @return bool True if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

/**
 * Get current user ID
 * 
 * @return int|null User ID or null if not logged in
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user role
 * 
 * @return string|null User role or null if not logged in
 */
function getCurrentUserRole() {
    return $_SESSION['role'] ?? null;
}

/**
 * Get current user data
 * 
 * @return array|null User data or null if not logged in
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    $userId = getCurrentUserId();
    $user = fetchOne("SELECT * FROM users WHERE id = ?", [$userId]);
    
    if ($user) {
        unset($user['password_hash']);
        unset($user['reset_token']);
        unset($user['reset_token_expires']);
    }
    
    return $user;
}

/**
 * Require user to be logged in
 * 
 * @param string $redirectUrl URL to redirect to if not logged in
 */
function requireLogin($redirectUrl = 'login.php') {
    if (!isLoggedIn()) {
        header("Location: {$redirectUrl}");
        exit();
    }
}

/**
 * Require user to have specific role
 * 
 * @param string|array $roles Allowed roles
 * @param string $redirectUrl URL to redirect to if not authorized
 */
function requireRole($roles, $redirectUrl = 'dashboard.php') {
    requireLogin();
    
    if (!is_array($roles)) {
        $roles = [$roles];
    }
    
    $currentRole = getCurrentUserRole();
    
    if (!in_array($currentRole, $roles)) {
        header("Location: {$redirectUrl}");
        exit();
    }
}

/**
 * Generate a random token
 * 
 * @param int $length Token length
 * @return string Random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Create a password reset token
 * 
 * @param string $email User email
 * @return string|false Reset token or false if user not found
 */
function createResetToken($email) {
    $user = fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
    
    if (!$user) {
        return false;
    }
    
    $token = generateToken();
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    updateRecord('users', [
        'reset_token' => $token,
        'reset_token_expires' => $expires
    ], 'id = ?', [$user['id']]);
    
    return $token;
}

/**
 * Reset password using token
 * 
 * @param string $token Reset token
 * @param string $newPassword New password
 * @return bool Success status
 */
function resetPassword($token, $newPassword) {
    $user = fetchOne("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires > NOW()", [$token]);
    
    if (!$user) {
        return false;
    }
    
    $hashedPassword = hashPassword($newPassword);
    
    updateRecord('users', [
        'password_hash' => $hashedPassword,
        'reset_token' => null,
        'reset_token_expires' => null
    ], 'id = ?', [$user['id']]);
    
    return true;
}

/**
 * Change user password
 * 
 * @param int $userId User ID
 * @param string $currentPassword Current password
 * @param string $newPassword New password
 * @return bool Success status
 */
function changePassword($userId, $currentPassword, $newPassword) {
    $user = fetchOne("SELECT password_hash FROM users WHERE id = ?", [$userId]);
    
    if (!$user || !verifyPassword($currentPassword, $user['password_hash'])) {
        return false;
    }
    
    $hashedPassword = hashPassword($newPassword);
    
    updateRecord('users', [
        'password_hash' => $hashedPassword
    ], 'id = ?', [$userId]);
    
    return true;
}

/**
 * Send a notification email
 * 
 * @param string $to Recipient email
 * @param string $subject Email subject
 * @param string $body Email body
 * @return bool Success status
 */
function sendNotificationEmail($to, $subject, $body) {
    // In production, use a proper email library (PHPMailer, Swift Mailer, etc.)
    $headers = "From: Tutor GoodVibez Life <noreply@goodvibez.life>\r\n";
    $headers .= "Reply-To: support@goodvibez.life\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($to, $subject, $body, $headers);
}

/**
 * Set a flash message
 * 
 * @param string $type Message type (success, error, info, warning)
 * @param string $message Message text
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash messages
 * 
 * @return array Array of flash messages
 */
function getFlashMessages() {
    $messages = $_SESSION['flash_messages'] ?? [];
    unset($_SESSION['flash_messages']);
    return $messages;
}
