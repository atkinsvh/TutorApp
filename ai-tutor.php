<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Tutor - Tutor GoodVibez Life</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="index.php"><h1>Tutor GoodVibez Life</h1></a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="btn btn-primary">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <main class="page-container">
        <div class="coming-soon">
            <div class="coming-soon-icon">🤖</div>
            <h1>AI Tutor</h1>
            <p class="coming-soon-subtitle">Intelligent tutoring assistance coming soon!</p>
            
            <div class="coming-soon-features">
                <h3>What to Expect:</h3>
                <ul>
                    <li>24/7 AI-powered tutoring assistance</li>
                    <li>Personalized learning recommendations</li>
                    <li>Instant feedback on practice problems</li>
                    <li>Step-by-step problem solving guides</li>
                    <li>Adaptive learning paths</li>
                </ul>
            </div>
            
            <div class="coming-soon-cta">
                <p>Be the first to know when we launch!</p>
                <form class="notify-form">
                    <input type="email" placeholder="Enter your email">
                    <button type="submit" class="btn btn-primary">Notify Me</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 Tutor GoodVibez Life. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
