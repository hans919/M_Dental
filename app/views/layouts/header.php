<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? 'Dental Clinic System'; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/style.css?v=<?php echo time(); ?>">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="app-container">
        <?php require_once '../app/views/layouts/sidebar.php'; ?>
        
        <div class="main-wrapper">
            <?php require_once '../app/views/layouts/topbar.php'; ?>
            
            <main class="main-content">
