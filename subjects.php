<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects - Tutor GoodVibez Life</title>
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
        <h1>Available Subjects</h1>
        <p class="page-subtitle">Explore our comprehensive range of tutoring subjects</p>
        
        <div class="subjects-grid">
            <div class="subject-card">
                <div class="subject-icon">📐</div>
                <h3>Mathematics</h3>
                <p>Algebra, Geometry, Calculus, Statistics</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
            </div>
            
            <div class="subject-card">
                <div class="subject-icon">🔬</div>
                <h3>Science</h3>
                <p>Physics, Chemistry, Biology</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
            </div>
            
            <div class="subject-card">
                <div class="subject-icon">📚</div>
                <h3>English</h3>
                <p>Reading, Writing, Grammar, Literature</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
            </div>
            
            <div class="subject-card">
                <div class="subject-icon">🌍</div>
                <h3>Social Studies</h3>
                <p>History, Geography, Economics</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
            </div>
            
            <div class="subject-card">
                <div class="subject-icon">💻</div>
                <h3>Computer Science</h3>
                <p>Programming, Web Development, Data Science</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
            </div>
            
            <div class="subject-card">
                <div class="subject-icon">🎨</div>
                <h3>Creative Arts</h3>
                <p>Art, Music, Design</p>
                <a href="register.php" class="btn btn-secondary">Start Learning</a>
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
