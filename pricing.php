<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing - Tutor GoodVibez Life</title>
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
                <li><a href="subjects.php">Subjects</a></li>
                <li><a href="pricing.php" class="active">Pricing</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="btn btn-primary">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="pricing-hero">
            <h1>Premium Tutoring Plans</h1>
            <p>Invest in your academic success with our flexible pricing options</p>
        </section>

        <section class="pricing-section">
            <div class="pricing-toggle">
                <span class="active">Monthly</span>
                <label class="toggle">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
                <span>Annual (Save 20%)</span>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3>Basic</h3>
                    <div class="price">
                        <span class="amount">$29</span>
                        <span class="period">/month</span>
                    </div>
                    <ul class="features">
                        <li>2 tutoring sessions/month</li>
                        <li>Basic progress tracking</li>
                        <li>Email support</li>
                        <li>Access to study materials</li>
                    </ul>
                    <a href="register.php" class="btn btn-secondary btn-full">Get Started</a>
                </div>
                
                <div class="pricing-card featured">
                    <div class="featured-badge">Most Popular</div>
                    <h3>Premium</h3>
                    <div class="price">
                        <span class="amount">$79</span>
                        <span class="period">/month</span>
                    </div>
                    <ul class="features">
                        <li>8 tutoring sessions/month</li>
                        <li>Advanced progress tracking</li>
                        <li>Priority support</li>
                        <li>AI tutor access</li>
                        <li>Custom study plans</li>
                        <li>Assignment feedback</li>
                    </ul>
                    <a href="register.php" class="btn btn-primary btn-full">Get Started</a>
                </div>
                
                <div class="pricing-card">
                    <h3>Elite</h3>
                    <div class="price">
                        <span class="amount">$149</span>
                        <span class="period">/month</span>
                    </div>
                    <ul class="features">
                        <li>Unlimited tutoring sessions</li>
                        <li>Comprehensive analytics</li>
                        <li>24/7 support</li>
                        <li>Full AI tutor suite</li>
                        <li>Personalized learning paths</li>
                        <li>Parent dashboard access</li>
                        <li>Exam preparation</li>
                    </ul>
                    <a href="register.php" class="btn btn-secondary btn-full">Get Started</a>
                </div>
            </div>
        </section>

        <section class="pricing-faq">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3>Can I change plans anytime?</h3>
                    <p>Yes! You can upgrade or downgrade your plan at any time. Changes take effect at the start of your next billing cycle.</p>
                </div>
                <div class="faq-item">
                    <h3>Is there a free trial?</h3>
                    <p>We offer a 7-day free trial for our Premium plan. No credit card required to start.</p>
                </div>
                <div class="faq-item">
                    <h3>What payment methods do you accept?</h3>
                    <p>We accept all major credit cards, PayPal, and bank transfers for annual plans.</p>
                </div>
                <div class="faq-item">
                    <h3>Can I cancel anytime?</h3>
                    <p>Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your billing period.</p>
                </div>
            </div>
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
