    <!-- Footer -->
    <footer class="landing-footer">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-brand">
                    <div class="brand-icon">
                        <i data-lucide="heart-pulse"></i>
                    </div>
                    <span class="brand-name">DentalCare Clinic</span>
                </div>
                <p class="footer-description">
                    Professional dental care with compassion and excellence. 
                    Your smile is our priority.
                </p>
            </div>
            
            <div class="footer-links">
                <div class="link-group">
                    <h4>Quick Links</h4>
                    <a href="#home">Home</a>
                    <a href="#services">Services</a>
                    <a href="#about">About Us</a>
                    <a href="#contact">Contact</a>
                </div>
                
                <div class="link-group">
                    <h4>Services</h4>
                    <a href="#services">General Dentistry</a>
                    <a href="#services">Cosmetic Dentistry</a>
                    <a href="#services">Emergency Care</a>
                    <a href="#services">Orthodontics</a>
                </div>
                
                <div class="link-group">
                    <h4>Patient Portal</h4>
                    <a href="<?php echo APP_URL; ?>/public/auth/login">Login</a>
                    <a href="<?php echo APP_URL; ?>/public/auth/register">Register</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 DentalCare Clinic. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Profile dropdown toggle
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (profileDropdownBtn && profileDropdown) {
            profileDropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('show');
                profileDropdownBtn.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileDropdownBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('show');
                    profileDropdownBtn.classList.remove('active');
                }
            });
        }
        
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.querySelector('.nav-menu');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                    if (navMenu) navMenu.classList.remove('active');
                }
            });
        });
        
        // Active nav link on scroll
        window.addEventListener('scroll', () => {
            let current = '';
            const sections = document.querySelectorAll('section[id]');
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });
            
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
