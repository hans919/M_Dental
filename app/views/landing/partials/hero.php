    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    Your Smile,<br>
                    <span class="gradient-text">Our Priority</span>
                </h1>
                <p class="hero-subtitle">
                    Professional dental care with compassion and excellence. 
                    Schedule your appointment today and experience the difference.
                </p>
                <div class="hero-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'patient'): ?>
                            <a href="<?php echo APP_URL; ?>/public/patient_dashboard/book" class="btn btn-primary btn-lg">
                                <i data-lucide="calendar-plus"></i>
                                Book Appointment
                            </a>
                        <?php else: ?>
                            <a href="<?php echo APP_URL; ?>/public/home" class="btn btn-primary btn-lg">
                                <i data-lucide="layout-dashboard"></i>
                                Go to Dashboard
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo APP_URL; ?>/public/auth/register" class="btn btn-primary btn-lg">
                            <i data-lucide="calendar-plus"></i>
                            Book Appointment
                        </a>
                    <?php endif; ?>
                    <a href="#services" class="btn btn-outline-white btn-lg">
                        <i data-lucide="info"></i>
                        Learn More
                    </a>
                </div>
                <div class="hero-features">
                    <div class="feature-item">
                        <i data-lucide="shield-check"></i>
                        <span>Licensed Dentists</span>
                    </div>
                    <div class="feature-item">
                        <i data-lucide="clock"></i>
                        <span>Flexible Hours</span>
                    </div>
                    <div class="feature-item">
                        <i data-lucide="heart"></i>
                        <span>Patient-Centered Care</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-card">
                    <div class="card-stats">
                        <div class="stat-item">
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Happy Patients</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">15+</div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
