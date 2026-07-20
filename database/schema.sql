-- Tutor GoodVibez Life Database Schema
-- Version 1.0
-- Created: 2026-01-19

-- Create database
CREATE DATABASE IF NOT EXISTS tutor_goodvibez_life;
USE tutor_goodvibez_life;

-- Users table (core user accounts)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    role ENUM('student', 'tutor', 'parent', 'admin') NOT NULL DEFAULT 'student',
    phone VARCHAR(20),
    profile_picture VARCHAR(255),
    email_verified TINYINT(1) DEFAULT 0,
    reset_token VARCHAR(255),
    reset_token_expires DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1
);

-- Student profiles
CREATE TABLE student_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    grade_level INT,
    school_name VARCHAR(255),
    graduation_year INT,
    gpa DECIMAL(3,2),
    learning_style ENUM('visual', 'auditory', 'kinesthetic', 'reading') DEFAULT 'visual',
    goals TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tutor profiles
CREATE TABLE tutor_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    bio TEXT,
    hourly_rate DECIMAL(10,2),
    experience_years INT,
    education_level ENUM('bachelors', 'masters', 'phd', 'other'),
    institution VARCHAR(255),
    specialization TEXT,
    availability JSON,
    is_verified TINYINT(1) DEFAULT 0,
    application_status ENUM('pending', 'approved', 'rejected', 'needs_more_info', 'suspended') DEFAULT 'pending',
    application_date TIMESTAMP NULL,
    approval_date TIMESTAMP NULL,
    subscription_plan ENUM('starter', 'professional', 'enterprise') DEFAULT 'starter',
    subscription_status ENUM('active', 'inactive', 'past_due', 'cancelled') DEFAULT 'inactive',
    subscription_expires DATETIME,
    platform_commission DECIMAL(5,2) DEFAULT 15.00,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Parent profiles
CREATE TABLE parent_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    relationship_type ENUM('parent', 'guardian', 'other') DEFAULT 'parent',
    emergency_contact VARCHAR(255),
    emergency_phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Parent-student links
CREATE TABLE parent_student_links (
    id INT PRIMARY KEY AUTO_INCREMENT,
    parent_user_id INT NOT NULL,
    student_user_id INT NOT NULL,
    relationship_type ENUM('parent', 'guardian', 'other') DEFAULT 'parent',
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_link (parent_user_id, student_user_id)
);

-- Tutor-student links
CREATE TABLE tutor_student_links (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tutor_user_id INT NOT NULL,
    student_user_id INT NOT NULL,
    status ENUM('pending', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    invite_token VARCHAR(255),
    invited_by INT,
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (invited_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_link (tutor_user_id, student_user_id)
);

-- Subjects
CREATE TABLE subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Grade levels
CREATE TABLE grade_levels (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
);

-- Tutor subjects (which subjects a tutor teaches)
CREATE TABLE tutor_subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tutor_user_id INT NOT NULL,
    subject_id INT NOT NULL,
    grade_level_ids JSON,
    proficiency_level ENUM('beginner', 'intermediate', 'advanced', 'expert') DEFAULT 'intermediate',
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    UNIQUE KEY unique_tutor_subject (tutor_user_id, subject_id)
);

-- Student subjects (which subjects a student needs help with)
CREATE TABLE student_subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_user_id INT NOT NULL,
    subject_id INT NOT NULL,
    current_level VARCHAR(50),
    target_level VARCHAR(50),
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    UNIQUE KEY unique_student_subject (student_user_id, subject_id)
);

-- Tutor applications
CREATE TABLE tutor_applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    subjects JSON,
    experience_years INT,
    education_level VARCHAR(100),
    institution VARCHAR(255),
    bio TEXT,
    hourly_rate DECIMAL(10,2),
    status ENUM('pending', 'approved', 'rejected', 'needs_more_info') DEFAULT 'pending',
    admin_notes TEXT,
    reviewed_by INT,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
);

-- Assignments
CREATE TABLE assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tutor_user_id INT NOT NULL,
    student_user_id INT NOT NULL,
    subject_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructions TEXT,
    due_date DATETIME,
    max_score INT DEFAULT 100,
    difficulty ENUM('easy', 'medium', 'hard', 'advanced') DEFAULT 'medium',
    status ENUM('draft', 'assigned', 'in_progress', 'submitted', 'reviewed', 'completed') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);

-- Assignment submissions
CREATE TABLE assignment_submissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    assignment_id INT NOT NULL,
    student_user_id INT NOT NULL,
    submission_text TEXT,
    file_path VARCHAR(255),
    score INT,
    feedback TEXT,
    graded_by INT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    graded_at TIMESTAMP NULL,
    status ENUM('submitted', 'graded', 'needs_revision') DEFAULT 'submitted',
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (graded_by) REFERENCES users(id) ON DELETE SET NULL
);

-- AI assignments (placeholder for future AI features)
CREATE TABLE ai_assignments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_user_id INT NOT NULL,
    subject_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content JSON,
    difficulty ENUM('easy', 'medium', 'hard', 'advanced') DEFAULT 'medium',
    status ENUM('draft', 'assigned', 'in_progress', 'submitted', 'reviewed', 'needs_revision', 'completed') DEFAULT 'draft',
    ai_feedback TEXT,
    tutor_feedback TEXT,
    due_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);

-- AI conversations (placeholder for future AI features)
CREATE TABLE ai_conversations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    subject_id INT,
    messages JSON,
    context TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);

-- Messages
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sender_user_id INT NOT NULL,
    receiver_user_id INT NOT NULL,
    subject VARCHAR(255),
    message_text TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    parent_message_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_message_id) REFERENCES messages(id) ON DELETE SET NULL
);

-- Calendar events
CREATE TABLE calendar_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_type ENUM('session', 'assignment', 'exam', 'reminder', 'other') DEFAULT 'other',
    start_time DATETIME NOT NULL,
    end_time DATETIME,
    is_recurring TINYINT(1) DEFAULT 0,
    recurrence_pattern VARCHAR(50),
    reminder_minutes INT DEFAULT 15,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Study sessions
CREATE TABLE study_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_user_id INT NOT NULL,
    subject_id INT,
    tutor_user_id INT,
    title VARCHAR(255),
    description TEXT,
    duration_minutes INT,
    start_time DATETIME,
    end_time DATETIME,
    status ENUM('scheduled', 'in_progress', 'completed', 'cancelled') DEFAULT 'scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Study plans
CREATE TABLE study_plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    goals JSON,
    schedule JSON,
    start_date DATE,
    end_date DATE,
    status ENUM('active', 'completed', 'paused', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Exam dates
CREATE TABLE exam_dates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_user_id INT NOT NULL,
    subject_id INT,
    exam_name VARCHAR(255) NOT NULL,
    exam_date DATE NOT NULL,
    location VARCHAR(255),
    notes TEXT,
    reminder_sent TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);

-- Statistics
CREATE TABLE statistics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    stat_type VARCHAR(50) NOT NULL,
    stat_value DECIMAL(10,2),
    stat_date DATE,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Pricing plans
CREATE TABLE pricing_plans (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price_monthly DECIMAL(10,2),
    price_yearly DECIMAL(10,2),
    features JSON,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subscriptions
CREATE TABLE subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    billing_cycle ENUM('monthly', 'yearly') DEFAULT 'monthly',
    status ENUM('active', 'cancelled', 'past_due', 'trialing') DEFAULT 'active',
    start_date DATE,
    end_date DATE,
    next_billing_date DATE,
    payment_processor_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES pricing_plans(id) ON DELETE CASCADE
);

-- Payments
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    student_user_id INT,
    tutor_user_id INT,
    plan_id INT,
    payment_type ENUM('subscription', 'tutoring', 'application_fee', 'one_time') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_processor VARCHAR(50),
    payment_processor_id VARCHAR(255),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paid_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (plan_id) REFERENCES pricing_plans(id) ON DELETE SET NULL
);

-- Payouts (for tutors)
CREATE TABLE payouts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tutor_user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending',
    payout_method ENUM('bank_transfer', 'paypal') DEFAULT 'bank_transfer',
    payout_details JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Student invites
CREATE TABLE student_invites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tutor_user_id INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    invite_token VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('pending', 'accepted', 'expired') DEFAULT 'pending',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    FOREIGN KEY (tutor_user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    notification_type ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
    is_read TINYINT(1) DEFAULT 0,
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Activity log
CREATE TABLE activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    details JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Admin settings
CREATE TABLE admin_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default data

-- Default grade levels
INSERT INTO grade_levels (name, sort_order) VALUES
('Kindergarten', 1),
('1st Grade', 2),
('2nd Grade', 3),
('3rd Grade', 4),
('4th Grade', 5),
('5th Grade', 6),
('6th Grade', 7),
('7th Grade', 8),
('8th Grade', 9),
('9th Grade', 10),
('10th Grade', 11),
('11th Grade', 12),
('12th Grade', 13),
('College', 14),
('Graduate', 15);

-- Default subjects
INSERT INTO subjects (name, description, category) VALUES
('Mathematics', 'Algebra, Geometry, Calculus, Statistics', 'STEM'),
('Physics', 'Mechanics, Thermodynamics, Electromagnetism', 'STEM'),
('Chemistry', 'General Chemistry, Organic Chemistry, Biochemistry', 'STEM'),
('Biology', 'Cell Biology, Genetics, Ecology', 'STEM'),
('English', 'Reading, Writing, Grammar, Literature', 'Language Arts'),
('History', 'World History, US History, European History', 'Humanities'),
('Geography', 'Physical Geography, Human Geography', 'Humanities'),
('Computer Science', 'Programming, Web Development, Data Science', 'STEM'),
('Foreign Languages', 'Spanish, French, Mandarin, German', 'Languages'),
('Economics', 'Microeconomics, Macroeconomics', 'Social Studies'),
('Psychology', 'Introduction to Psychology, Developmental Psychology', 'Social Studies'),
('Art', 'Drawing, Painting, Digital Art', 'Creative'),
('Music', 'Theory, Performance, Composition', 'Creative');

-- Default pricing plans
INSERT INTO pricing_plans (name, description, price_monthly, price_yearly, features, sort_order) VALUES
('Basic', 'Essential tutoring features', 29.00, 278.40, '{"sessions": 2, "ai_tutor": false, "priority_support": false}', 1),
('Premium', 'Advanced learning tools', 79.00, 758.40, '{"sessions": 8, "ai_tutor": true, "priority_support": true}', 2),
('Elite', 'Complete learning suite', 149.00, 1430.40, {"sessions": "unlimited", "ai_tutor": true, "priority_support": true}', 3);

-- Default admin settings
INSERT INTO admin_settings (setting_key, setting_value, setting_type, description) VALUES
('platform_name', 'Tutor GoodVibez Life', 'string', 'Platform display name'),
('platform_email', 'admin@goodvibez.life', 'string', 'Platform contact email'),
('tutor_application_fee', '25.00', 'number', 'Tutor application fee in USD'),
('default_commission_rate', '15.00', 'number', 'Default platform commission percentage'),
('min_tutor_rate', '20.00', 'number', 'Minimum hourly tutor rate'),
('max_tutor_rate', '200.00', 'number', 'Maximum hourly tutor rate'),
('registration_enabled', 'true', 'boolean', 'Allow new user registrations'),
('tutor_applications_enabled', 'true', 'boolean', 'Allow new tutor applications');

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_active ON users(is_active);
CREATE INDEX idx_student_profiles_user ON student_profiles(user_id);
CREATE INDEX idx_tutor_profiles_user ON tutor_profiles(user_id);
CREATE INDEX idx_tutor_profiles_status ON tutor_profiles(application_status);
CREATE INDEX idx_assignments_tutor ON assignments(tutor_user_id);
CREATE INDEX idx_assignments_student ON assignments(student_user_id);
CREATE INDEX idx_assignments_status ON assignments(status);
CREATE INDEX idx_messages_sender ON messages(sender_user_id);
CREATE INDEX idx_messages_receiver ON messages(receiver_user_id);
CREATE INDEX idx_messages_read ON messages(is_read);
CREATE INDEX idx_calendar_events_user ON calendar_events(user_id);
CREATE INDEX idx_calendar_events_time ON calendar_events(start_time);
CREATE INDEX idx_payments_user ON payments(user_id);
CREATE INDEX idx_payments_status ON payments(status);
CREATE INDEX idx_activity_log_user ON activity_log(user_id);
CREATE INDEX idx_activity_log_action ON activity_log(action);
CREATE INDEX idx_notifications_user ON notifications(user_id);
CREATE INDEX idx_notifications_read ON notifications(is_read);
