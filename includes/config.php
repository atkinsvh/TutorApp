<?php
/**
 * Tutor GoodVibez Life - Configuration
 * 
 * Main configuration file for the application.
 */

// Environment
define('APP_ENV', 'development'); // Change to 'production' for live site
define('APP_DEBUG', true); // Set to false in production

// Application
define('APP_NAME', 'Tutor GoodVibez Life');
define('APP_URL', 'https://tutor.goodvibez.life');
define('APP_VERSION', '1.0.0');

// Security
define('SESSION_TIMEOUT', 3600); // 1 hour
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutes
define('PASSWORD_MIN_LENGTH', 8);

// File Upload
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_DOCUMENT_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
define('UPLOAD_PATH', __DIR__ . '/../uploads/');

// Email
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', ''); // Set in production
define('SMTP_PASSWORD', ''); // Set in production
define('FROM_EMAIL', 'noreply@goodvibez.life');
define('FROM_NAME', 'Tutor GoodVibez Life');

// Tutor Settings
define('MIN_TUTOR_RATE', 20);
define('MAX_TUTOR_RATE', 200);
define('DEFAULT_COMMISSION_RATE', 15);
define('TUTOR_APPLICATION_FEE', 25);

// Subscription Settings
define('TRIAL_PERIOD_DAYS', 7);
define('CANCELATION_GRACE_PERIOD', 30);

// Display errors based on environment
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/error.log');
}

// Timezone
date_default_timezone_set('America/New_York');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

/**
 * Get application URL
 * 
 * @param string $path Optional path to append
 * @return string Full URL
 */
function getAppUrl($path = '') {
    $baseUrl = APP_URL;
    if (!empty($path)) {
        $baseUrl .= '/' . ltrim($path, '/');
    }
    return $baseUrl;
}

/**
 * Check if application is in production
 * 
 * @return bool True if in production
 */
function isProduction() {
    return APP_ENV === 'production';
}

/**
 * Get a configuration value with a default fallback
 * 
 * @param string $key Configuration key
 * @param mixed $default Default value
 * @return mixed Configuration value
 */
function getConfig($key, $default = null) {
    $config = [
        'app_name' => APP_NAME,
        'app_url' => APP_URL,
        'app_version' => APP_VERSION,
        'min_tutor_rate' => MIN_TUTOR_RATE,
        'max_tutor_rate' => MAX_TUTOR_RATE,
        'default_commission' => DEFAULT_COMMISSION_RATE,
        'tutor_application_fee' => TUTOR_APPLICATION_FEE,
    ];
    
    return $config[$key] ?? $default;
}
