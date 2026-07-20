<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Application - Tutor GoodVibez Life</title>
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
                <li><a href="become-a-tutor.php">Become a Tutor</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="auth-container">
        <div class="auth-card application-card">
            <h2>Tutor Application</h2>
            <p class="auth-subtitle">Apply to join our premium tutoring network</p>
            
            <form action="api/tutor-application.php" method="POST" class="auth-form">
                <input type="hidden" name="action" value="submit_application">
                
                <h3 class="form-section">Personal Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                
                <h3 class="form-section">Teaching Experience</h3>
                
                <div class="form-group">
                    <label for="subjects">Subjects You Teach</label>
                    <select id="subjects" name="subjects[]" multiple required>
                        <option value="math">Mathematics</option>
                        <option value="physics">Physics</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="biology">Biology</option>
                        <option value="english">English</option>
                        <option value="history">History</option>
                        <option value="computer_science">Computer Science</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="experience">Years of Experience</label>
                    <select id="experience" name="experience" required>
                        <option value="1-3">1-3 years</option>
                        <option value="3-5">3-5 years</option>
                        <option value="5-10">5-10 years</option>
                        <option value="10+">10+ years</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="education">Highest Education Level</label>
                    <select id="education" name="education" required>
                        <option value="bachelors">Bachelor's Degree</option>
                        <option value="masters">Master's Degree</option>
                        <option value="phd">Ph.D.</option>
                        <option value="other">Other Professional Qualification</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="bio">Professional Bio</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Tell us about your teaching experience and qualifications..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="hourly_rate">Desired Hourly Rate ($)</label>
                    <input type="number" id="hourly_rate" name="hourly_rate" min="20" max="200" value="50" required>
                    <small class="form-help">Premium tutors typically charge $50-$150/hour</small>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required> 
                        I agree to the <a href="#">Tutor Terms of Service</a> and <a href="#">Background Check Authorization</a>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Submit Application</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 Tutor GoodVibez Life. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
