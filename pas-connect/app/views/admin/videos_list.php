<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="container mt-4">
    <h3><?php echo htmlspecialchars(t('manage_videos')); ?></h3>
    <div class="mb-3"><a href="?page=admin_videos_create" class="btn btn-sm btn-primary"><?php echo htmlspecialchars(t('upload_video')); ?></a></div>
    <?php $videos = 
        (function(){ $pdo = getPDO(); $stmt=$pdo->prepare('SELECT v.*, a.email as uploader_email FROM videos v LEFT JOIN admins a ON v.uploader_admin_id=a.id ORDER BY created_at DESC'); $stmt->execute(); return $stmt->fetchAll(); })();
    ?>
    <?php if (empty($videos)): ?><div class="alert alert-secondary"><?php echo htmlspecialchars(t('no_videos')); ?></div><?php else: ?>
    
    <div class="row">
        <?php foreach ($videos as $v): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <?php if (!empty($v['thumbnail'])): ?><img src="uploads/videos/<?php echo htmlspecialchars($v['thumbnail']); ?>" class="card-img-top" alt="">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($v['title']); ?></h5>
                    <p class="small text-muted">By <?php echo htmlspecialchars($v['uploader_email']); ?></p>
                    <p><?php echo htmlspecialchars(substr($v['description'],0,120)); ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="?page=videos_view&id=<?php echo (int)$v['id']; ?>" class="btn btn-sm btn-outline-primary"><?php echo htmlspecialchars(t('view')); ?></a>
                        <form method="post" action="api/videos_delete.php" onsubmit="return confirm(<?php echo json_encode(t('delete_video_confirm')); ?>);">
                            <input type="hidden" name="id" value="<?php echo (int)$v['id']; ?>">
                            <button class="btn btn-sm btn-danger"><?php echo htmlspecialchars(t('delete')); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>