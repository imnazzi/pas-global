<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php $isEdit = !empty($admin); ?>
<div class="container mt-4">
    <h3><?php echo $isEdit ? htmlspecialchars(t('edit_admin')) : htmlspecialchars(t('create_admin')); ?></h3>
    <form method="post" action="api/admins_save.php">
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?php echo (int)$admin['id']; ?>" /><?php endif; ?>

        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars(t('email')); ?></label>
            <input name="email" class="form-control" required value="<?php echo $isEdit ? htmlspecialchars($admin['email']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars(t('password_optional')); ?></label>
            <input name="password" type="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label"><?php echo htmlspecialchars(t('role')); ?></label>
            <select name="role" class="form-control">
                <option value="sub" <?php if ($isEdit && $admin['role']==='sub') echo 'selected'; ?>><?php echo htmlspecialchars(t('sub_admin')); ?></option>
                <option value="master" <?php if ($isEdit && $admin['role']==='master') echo 'selected'; ?>><?php echo htmlspecialchars(t('master_admin')); ?></option>
            </select>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="active" class="form-check-input" id="activeCheck" <?php if (!$isEdit || $admin['is_active']) echo 'checked'; ?> value="1">
            <label class="form-check-label" for="activeCheck"><?php echo htmlspecialchars(t('active')); ?></label>
        </div>
        <button class="btn btn-primary"><?php echo $isEdit ? htmlspecialchars(t('save_changes')) : htmlspecialchars(t('create_admin')); ?></button>
    </form>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>