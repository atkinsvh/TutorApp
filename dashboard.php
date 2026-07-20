<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user role and redirect to appropriate dashboard
$role = $_SESSION['role'] ?? 'student';

switch ($role) {
    case 'tutor':
        header("Location: tutor/dashboard.php");
        break;
    case 'parent':
        header("Location: parent/dashboard.php");
        break;
    case 'admin':
        header("Location: admin/dashboard.php");
        break;
    case 'student':
    default:
        header("Location: student/dashboard.php");
        break;
}
exit();
