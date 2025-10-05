<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php require_once __DIR__ . '/partials/navigation.php'; ?>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; max-width: 400px; background: hsl(142, 76%, 36% / 0.95); color: white; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 1rem; animation: slideIn 0.3s ease;">
        <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
        <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; max-width: 400px; background: hsl(0, 84%, 60% / 0.95); color: white; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 1rem; animation: slideIn 0.3s ease;">
        <i data-lucide="alert-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
        <div><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/partials/hero.php'; ?>

<?php require_once __DIR__ . '/partials/services.php'; ?>

<?php require_once __DIR__ . '/partials/about.php'; ?>

<?php require_once __DIR__ . '/partials/contact.php'; ?>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

