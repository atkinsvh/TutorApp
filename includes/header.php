<?php
/**
 * Tutor GoodVibez Life - Header Include
 * 
 * Common header for all pages.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Premium tutoring platform connecting students with expert tutors'; ?>">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo getAppUrl('css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php if (isset($extraStyles)): ?>
        <?php echo $extraStyles; ?>
    <?php endif; ?>
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="<?php echo getAppUrl('index.php'); ?>">
                    <h1><?php echo APP_NAME; ?></h1>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="<?php echo getAppUrl('index.php'); ?>" <?php echo $currentPage === 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
                <li><a href="<?php echo getAppUrl('subjects.php'); ?>" <?php echo $currentPage === 'subjects.php' ? 'class="active"' : ''; ?>>Subjects</a></li>
                <li><a href="<?php echo getAppUrl('pricing.php'); ?>" <?php echo $currentPage === 'pricing.php' ? 'class="active"' : ''; ?>>Pricing</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo getAppUrl('dashboard.php'); ?>">Dashboard</a></li>
                    <li><a href="<?php echo getAppUrl('logout.php'); ?>">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo getAppUrl('login.php'); ?>" <?php echo $currentPage === 'login.php' ? 'class="active"' : ''; ?>>Login</a></li>
                    <li><a href="<?php echo getAppUrl('register.php'); ?>" class="btn btn-primary" <?php echo $currentPage === 'register.php' ? 'class="active"' : ''; ?>>Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <?php
    // Display flash messages
    $flashMessages = getFlashMessages();
    if (!empty($flashMessages)):
    ?>
    <div class="flash-messages">
        <?php foreach ($flashMessages as $msg): ?>
            <div class="notification notification-<?php echo $msg['type']; ?>">
                <?php echo $msg['message']; ?>
                <button class="notification-close">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <main>
