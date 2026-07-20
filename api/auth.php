<?php
/**
 * Tutor GoodVibez Life - Authentication API
 * 
 * Handles login, registration, and password reset.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';

// Set content type for JSON responses
header('Content-Type: application/json');

// Get the action
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        handleRegistration();
        break;
    
    case 'login':
        handleLogin();
        break;
    
    case 'logout':
        handleLogout();
        break;
    
    case 'forgot_password':
        handleForgotPassword();
        break;
    
    case 'reset_password':
        handleResetPassword();
        break;
    
    case 'change_password':
        handleChangePassword();
        break;
    
    default:
        sendErrorResponse('Invalid action', 400);
}

/**
 * Handle user registration
 */
function handleRegistration() {
    // Validate CSRF token
    if (!checkCSRFToken()) {
        sendErrorResponse('Invalid security token. Please try again.');
    }
    
    // Get and sanitize input
    $firstName = sanitizePost('first_name');
    $lastName = sanitizePost('last_name');
    $email = sanitizePost('email');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $role = sanitizePost('role');
    
    // Validate input
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        sendErrorResponse('All fields are required.');
    }
    
    if (!validateEmail($email)) {
        sendErrorResponse('Please enter a valid email address.');
    }
    
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        sendErrorResponse('Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long.');
    }
    
    if ($password !== $confirmPassword) {
        sendErrorResponse('Passwords do not match.');
    }
    
    if (!in_array($role, [ROLE_STUDENT, ROLE_PARENT, ROLE_TUTOR])) {
        sendErrorResponse('Invalid role selected.');
    }
    
    // Register user
    $userData = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'password' => $password,
        'role' => $role,
    ];
    
    $userId = registerUser($userData);
    
    if ($userId) {
        // Send welcome email (optional)
        // sendWelcomeEmail($email, $firstName);
        
        sendSuccessResponse(['user_id' => $userId], 'Registration successful! Please log in.');
    } else {
        sendErrorResponse('Email address already registered.');
    }
}

/**
 * Handle user login
 */
function handleLogin() {
    // Validate CSRF token
    if (!checkCSRFToken()) {
        sendErrorResponse('Invalid security token. Please try again.');
    }
    
    // Get input
    $email = sanitizePost('email');
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($email) || empty($password)) {
        sendErrorResponse('Email and password are required.');
    }
    
    // Attempt login
    $user = loginUser($email, $password);
    
    if ($user) {
        // Check for AJAX request
        if (isAjax()) {
            sendSuccessResponse([
                'user_id' => $user['id'],
                'role' => $user['role'],
                'redirect' => getDashboardUrl($user['role']),
            ], 'Login successful!');
        } else {
            // Redirect to dashboard
            redirect(getDashboardUrl($user['role']));
        }
    } else {
        if (isAjax()) {
            sendErrorResponse('Invalid email or password.');
        } else {
            setFlashMessage('error', 'Invalid email or password.');
            redirect('login.php');
        }
    }
}

/**
 * Handle user logout
 */
function handleLogout() {
    logoutUser();
    
    if (isAjax()) {
        sendSuccessResponse(null, 'Logged out successfully.');
    } else {
        redirect('index.php');
    }
}

/**
 * Handle forgot password request
 */
function handleForgotPassword() {
    $email = sanitizePost('email');
    
    if (empty($email)) {
        sendErrorResponse('Email address is required.');
    }
    
    if (!validateEmail($email)) {
        sendErrorResponse('Please enter a valid email address.');
    }
    
    // Create reset token
    $token = createResetToken($email);
    
    if ($token) {
        // In production, send email with reset link
        // $resetUrl = getAppUrl("reset-password.php?token={$token}");
        // sendPasswordResetEmail($email, $resetUrl);
        
        sendSuccessResponse(null, 'If an account exists with that email, a password reset link has been sent.');
    } else {
        // Don't reveal if email exists or not
        sendSuccessResponse(null, 'If an account exists with that email, a password reset link has been sent.');
    }
}

/**
 * Handle password reset
 */
function handleResetPassword() {
    $token = sanitizePost('token');
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($token) || empty($newPassword)) {
        sendErrorResponse('Token and new password are required.');
    }
    
    if (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
        sendErrorResponse('Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long.');
    }
    
    if ($newPassword !== $confirmPassword) {
        sendErrorResponse('Passwords do not match.');
    }
    
    $success = resetPassword($token, $newPassword);
    
    if ($success) {
        sendSuccessResponse(null, 'Password reset successful! Please log in with your new password.');
    } else {
        sendErrorResponse('Invalid or expired reset token.');
    }
}

/**
 * Handle password change
 */
function handleChangePassword() {
    if (!isLoggedIn()) {
        sendErrorResponse('Please log in to change your password.', 401);
    }
    
    // Validate CSRF token
    if (!checkCSRFToken()) {
        sendErrorResponse('Invalid security token. Please try again.');
    }
    
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_new_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword)) {
        sendErrorResponse('All fields are required.');
    }
    
    if (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
        sendErrorResponse('New password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long.');
    }
    
    if ($newPassword !== $confirmPassword) {
        sendErrorResponse('New passwords do not match.');
    }
    
    $userId = getCurrentUserId();
    $success = changePassword($userId, $currentPassword, $newPassword);
    
    if ($success) {
        setFlashMessage('success', 'Password updated successfully.');
        sendSuccessResponse(null, 'Password updated successfully.');
    } else {
        sendErrorResponse('Current password is incorrect.');
    }
}

/**
 * Get dashboard URL based on role
 * 
 * @param string $role User role
 * @return string Dashboard URL
 */
function getDashboardUrl($role) {
    $urls = [
        ROLE_STUDENT => 'student/dashboard.php',
        ROLE_TUTOR => 'tutor/dashboard.php',
        ROLE_PARENT => 'parent/dashboard.php',
        ROLE_ADMIN => 'admin/dashboard.php',
    ];
    
    return getAppUrl($urls[$role] ?? 'dashboard.php');
}
