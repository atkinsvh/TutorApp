<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor GoodVibez Life - Premium Tutoring Platform</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <h1>Tutor GoodVibez Life</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="pricing.php">Pricing</a></li>
                <li><a href="become-a-tutor.php">Become a Tutor</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="btn btn-primary">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Premium Tutoring for Academic Excellence</h1>
                <p>Connect with expert tutors, track your progress, and achieve your academic goals with personalized learning experiences.</p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-primary btn-large">Get Started</a>
                    <a href="become-a-tutor.php" class="btn btn-secondary btn-large">Become a Tutor</a>
                </div>
            </div>
        </section>

        <section class="features">
            <h2>Why Choose Tutor GoodVibez Life?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Expert Tutors</h3>
                    <p>Connect with qualified, vetted tutors who are passionate about helping you succeed.</p>
                </div>
                <div class="feature-card">
                    <h3>Personalized Learning</h3>
                    <p>Custom learning plans tailored to your unique needs and academic goals.</p>
                </div>
                <div class="feature-card">
                    <h3>Progress Tracking</h3>
                    <p>Monitor your improvement with detailed analytics and performance insights.</p>
                </div>
                <div class="feature-card">
                    <h3>AI-Powered Tools</h3>
                    <p>Access intelligent tutoring assistants and automated assignment grading.</p>
                </div>
            </div>
        </section>

        <section class="cta">
            <h2>Ready to Start Your Learning Journey?</h2>
            <p>Join thousands of students and tutors on our premium platform.</p>
            <a href="register.php" class="btn btn-primary btn-large">Create Free Account</a>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 Tutor GoodVibez Life. All rights reserved.</p>
            <div class="footer-links">
                <a href="pricing.php">Pricing</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
