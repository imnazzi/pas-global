<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="container mt-4">
    <h3><?php echo htmlspecialchars(t('manage_admins')); ?></h3>
    <div class="mb-3"><a href="?page=admin_admins_create" class="btn btn-sm btn-primary"><?php echo htmlspecialchars(t('create_admin')); ?></a></div>
    <?php if (empty($admins)): ?>
        <div class="alert alert-secondary"><?php echo htmlspecialchars(t('no_admins_found')); ?></div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr><th><?php echo htmlspecialchars(t('email')); ?></th><th><?php echo htmlspecialchars(t('role')); ?></th><th><?php echo htmlspecialchars(t('active')); ?></th><th><?php echo htmlspecialchars(t('created')); ?></th><th><?php echo htmlspecialchars(t('actions')); ?></th></tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $a): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($a['email']); ?></td>
                        <td><?php echo htmlspecialchars($a['role']); ?></td>
                        <td><?php echo $a['is_active'] ? htmlspecialchars(t('yes')) : htmlspecialchars(t('no')); ?></td>
                        <td><?php echo htmlspecialchars($a['created_at']); ?></td>
                        <td>
                            <a href="?page=admin_admins_edit&id=<?php echo (int)$a['id']; ?>" class="btn btn-sm btn-outline-light"><?php echo htmlspecialchars(t('edit')); ?></a>
                            <form method="post" action="api/admins_toggle.php" style="display:inline-block; margin-left:6px;">
                                <input type="hidden" name="id" value="<?php echo (int)$a['id']; ?>">
                                <input type="hidden" name="active" value="<?php echo $a['is_active'] ? 0 : 1; ?>">
                                <button class="btn btn-sm btn-warning"><?php echo htmlspecialchars($a['is_active'] ? t('suspend') : t('activate')); ?></button>
                            </form>
                            <form method="post" action="api/admins_delete.php" style="display:inline-block; margin-left:6px;" onsubmit="return confirm(<?php echo json_encode(t('delete_admin_confirm')); ?>);">
                                <input type="hidden" name="id" value="<?php echo (int)$a['id']; ?>">
                                <button class="btn btn-sm btn-danger"><?php echo htmlspecialchars(t('delete')); ?></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>