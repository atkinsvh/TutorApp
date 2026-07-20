<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Pricing - Tutor GoodVibez Life</title>
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

    <main>
        <section class="pricing-hero">
            <h1>Tutor Plans</h1>
            <p>Choose the plan that fits your tutoring business needs</p>
        </section>

        <section class="pricing-section">
            <div class="pricing-grid">
                <div class="pricing-card">
                    <h3>Starter</h3>
                    <div class="price">
                        <span class="amount">$0</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="price-subtitle">Application fee: $25 one-time</p>
                    <ul class="features">
                        <li>Up to 5 students</li>
                        <li>Basic profile</li>
                        <li>Assignment creation</li>
                        <li>Message students</li>
                        <li>Calendar access</li>
                    </ul>
                    <a href="tutor-application.php" class="btn btn-secondary btn-full">Apply Now</a>
                </div>
                
                <div class="pricing-card featured">
                    <div class="featured-badge">Best Value</div>
                    <h3>Professional</h3>
                    <div class="price">
                        <span class="amount">$39</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="price-subtitle">Application fee waived</p>
                    <ul class="features">
                        <li>Up to 20 students</li>
                        <li>Enhanced profile</li>
                        <li>AI assignment tools</li>
                        <li>Priority listing</li>
                        <li>Payment tracking</li>
                        <li>Student invitations</li>
                    </ul>
                    <a href="tutor-application.php" class="btn btn-primary btn-full">Apply Now</a>
                </div>
                
                <div class="pricing-card">
                    <h3>Enterprise</h3>
                    <div class="price">
                        <span class="amount">$99</span>
                        <span class="period">/month</span>
                    </div>
                    <p class="price-subtitle">Application fee waived</p>
                    <ul class="features">
                        <li>Unlimited students</li>
                        <li>Premium profile badge</li>
                        <li>Full AI suite</li>
                        <li>Top listing placement</li>
                        <li>Advanced analytics</li>
                        <li>Custom branding</li>
                        <li>Priority support</li>
                    </ul>
                    <a href="tutor-application.php" class="btn btn-secondary btn-full">Apply Now</a>
                </div>
            </div>
        </section>

        <section class="pricing-faq">
            <h2>Tutor FAQ</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <h3>How do I get paid?</h3>
                    <p>Payments are processed through our secure platform. You can request payouts weekly via bank transfer or PayPal.</p>
                </div>
                <div class="faq-item">
                    <h3>What commission does the platform take?</h3>
                    <p>Our platform fee is 15% for Starter, 12% for Professional, and 8% for Enterprise tutors.</p>
                </div>
                <div class="faq-item">
                    <h3>Can I bring my own students?</h3>
                    <p>Absolutely! All plans allow you to invite and manage your existing students on the platform.</p>
                </div>
                <div class="faq-item">
                    <h3>Is there a contract?</h3>
                    <p>No long-term contracts. You can cancel your subscription anytime. Monthly billing with no commitment.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 Tutor GoodVibez Life. All rights reserved.</p>
            <div class="footer-links">
                <a href="pricing.php">Student Pricing</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>
</body>
</html>
