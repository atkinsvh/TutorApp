<?php
/**
 * Tutor GoodVibez Life - CSRF Protection
 * 
 * Handles CSRF token generation and validation.
 */

/**
 * Generate a CSRF token
 * 
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Get the CSRF token field for forms
 * 
 * @return string HTML hidden input field
 */
function getCSRFTokenField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Validate a CSRF token
 * 
 * @param string $token Token to validate
 * @return bool True if token is valid
 */
function validateCSRFToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check CSRF token from form submission
 * 
 * @return bool True if token is valid
 */
function checkCSRFToken() {
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    return validateCSRFToken($token);
}

/**
 * Regenerate CSRF token (call after form submission)
 */
function regenerateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * CSRF middleware - validates token for POST requests
 * 
 * @return bool True if request is valid
 */
function csrfMiddleware() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!checkCSRFToken()) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid CSRF token']);
            exit();
        }
    }
    return true;
}
