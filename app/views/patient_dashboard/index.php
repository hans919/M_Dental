<?php require_once 'partials/header.php'; ?>

<?php require_once 'partials/navigation.php'; ?>

<main class="patient-main">
    <?php require_once 'partials/topbar.php'; ?>
    
    <div class="patient-content">
        <?php require_once 'partials/overview.php'; ?>
        
        <div class="dashboard-grid">
            <div class="dashboard-col-main">
                <?php require_once 'partials/appointments.php'; ?>
            </div>
            
            <div class="dashboard-col-side">
                <?php require_once 'partials/quick-actions.php'; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once 'partials/footer.php'; ?>
