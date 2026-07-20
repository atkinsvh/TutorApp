<?php
/**
 * Tutor GoodVibez Life - Role Definitions
 * 
 * Defines user roles and their permissions.
 */

// Role constants
define('ROLE_STUDENT', 'student');
define('ROLE_TUTOR', 'tutor');
define('ROLE_PARENT', 'parent');
define('ROLE_ADMIN', 'admin');

// Role hierarchy (higher number = more permissions)
define('ROLE_HIERARCHY', [
    ROLE_STUDENT => 1,
    ROLE_PARENT => 2,
    ROLE_TUTOR => 3,
    ROLE_ADMIN => 4,
]);

// Role permissions
define('ROLE_PERMISSIONS', [
    ROLE_STUDENT => [
        'view_own_profile',
        'edit_own_profile',
        'view_own_assignments',
        'submit_assignments',
        'view_own_messages',
        'send_messages',
        'view_own_calendar',
        'view_own_statistics',
        'view_subjects',
        'search_tutors',
    ],
    ROLE_TUTOR => [
        'view_own_profile',
        'edit_own_profile',
        'manage_own_students',
        'create_assignments',
        'grade_assignments',
        'view_own_messages',
        'send_messages',
        'view_own_calendar',
        'manage_calendar',
        'view_own_payments',
        'invite_students',
        'view_subjects',
        'manage_own_subjects',
    ],
    ROLE_PARENT => [
        'view_own_profile',
        'edit_own_profile',
        'view_linked_students',
        'view_student_progress',
        'view_student_assignments',
        'view_student_messages',
        'view_student_calendar',
        'view_student_payments',
        'message_tutors',
    ],
    ROLE_ADMIN => [
        'manage_all_users',
        'manage_tutor_applications',
        'manage_subjects',
        'manage_grade_levels',
        'manage_pricing',
        'manage_payments',
        'manage_payouts',
        'manage_ai_settings',
        'view_activity_logs',
        'view_reports',
        'manage_settings',
        'disable_accounts',
        'change_user_roles',
    ],
]);

/**
 * Check if a user has a specific permission
 * 
 * @param string $role User role
 * @param string $permission Permission to check
 * @return bool True if user has permission
 */
function hasPermission($role, $permission) {
    if (!isset(ROLE_PERMISSIONS[$role])) {
        return false;
    }
    
    return in_array($permission, ROLE_PERMISSIONS[$role]);
}

/**
 * Check if current user has a specific permission
 * 
 * @param string $permission Permission to check
 * @return bool True if user has permission
 */
function currentUserHasPermission($permission) {
    $role = getCurrentUserRole();
    return hasPermission($role, $permission);
}

/**
 * Get role display name
 * 
 * @param string $role Role identifier
 * @return string Display name
 */
function getRoleDisplayName($role) {
    $names = [
        ROLE_STUDENT => 'Student',
        ROLE_TUTOR => 'Tutor',
        ROLE_PARENT => 'Parent',
        ROLE_ADMIN => 'Admin',
    ];
    
    return $names[$role] ?? ucfirst($role);
}

/**
 * Get role hierarchy level
 * 
 * @param string $role Role identifier
 * @return int Hierarchy level
 */
function getRoleHierarchy($role) {
    return ROLE_HIERARCHY[$role] ?? 0;
}

/**
 * Check if role A has higher or equal privileges than role B
 * 
 * @param string $roleA Role to check
 * @param string $roleB Reference role
 * @return bool True if roleA >= roleB
 */
function hasHigherOrEqualRole($roleA, $roleB) {
    return getRoleHierarchy($roleA) >= getRoleHierarchy($roleB);
}

/**
 * Get all available roles
 * 
 * @return array Array of role identifiers
 */
function getAllRoles() {
    return array_keys(ROLE_HIERARCHY);
}

/**
 * Get student-specific permissions
 * 
 * @return array Array of permissions
 */
function getStudentPermissions() {
    return ROLE_PERMISSIONS[ROLE_STUDENT] ?? [];
}

/**
 * Get tutor-specific permissions
 * 
 * @return array Array of permissions
 */
function getTutorPermissions() {
    return ROLE_PERMISSIONS[ROLE_TUTOR] ?? [];
}

/**
 * Get parent-specific permissions
 * 
 * @return array Array of permissions
 */
function getParentPermissions() {
    return ROLE_PERMISSIONS[ROLE_PARENT] ?? [];
}

/**
 * Get admin-specific permissions
 * 
 * @return array Array of permissions
 */
function getAdminPermissions() {
    return ROLE_PERMISSIONS[ROLE_ADMIN] ?? [];
}
