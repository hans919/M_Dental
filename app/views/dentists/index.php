<?php require_once '../app/views/layouts/header.php'; ?>

<div class="header">
    <h1>Dentists</h1>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Dentist List</h2>
        <p class="card-description">Active dental professionals</p>
    </div>
    <div class="card-content">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>License Number</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['dentists'])): ?>
                        <?php foreach ($data['dentists'] as $dentist): ?>
                            <tr>
                                <td>Dr. <?php echo $dentist->first_name . ' ' . $dentist->last_name; ?></td>
                                <td><?php echo $dentist->specialization; ?></td>
                                <td><?php echo $dentist->license_number; ?></td>
                                <td><?php echo $dentist->phone; ?></td>
                                <td><?php echo $dentist->email; ?></td>
                                <td>
                                    <a href="<?php echo APP_URL; ?>/public/dentist/detail/<?php echo $dentist->id; ?>" class="btn btn-sm btn-outline">View Profile</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No dentists found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
