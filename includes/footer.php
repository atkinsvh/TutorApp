    </main>
    
    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
            <div class="footer-links">
                <a href="<?php echo getAppUrl('pricing.php'); ?>">Pricing</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo getAppUrl('js/main.js'); ?>"></script>
    <?php if (isset($extraScripts)): ?>
        <?php echo $extraScripts; ?>
    <?php endif; ?>
</body>
</html>
