<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --gallery-bg: #f8fafc;
        --card-white: #ffffff;
        --brand-emerald: #10b981;
        --text-main: #0f172a;
        --text-sub: #64748b;
    }

    .gallery-wrapper {
        padding: 60px 0 100px;
        background: var(--gallery-bg);
        min-height: 100vh;
    }

    .gallery-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .gallery-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--text-main);
        margin: 0;
    }

    /* Video Card Architecture */
    .video-item {
        background: var(--card-white);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .video-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -6px rgba(0, 0, 0, 0.04);
        border-color: var(--brand-emerald);
    }

    /* Thumbnail Logic */
    .thumb-container {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #000;
    }

    .video-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .video-item:hover .video-thumb {
        transform: scale(1.05);
        opacity: 0.8;
    }

    /* Play Button Overlay */
    .play-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.2);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-item:hover .play-overlay {
        opacity: 1;
    }

    .play-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--brand-emerald);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Card Details */
    .video-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .video-badge {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--brand-emerald);
        background: rgba(16, 185, 129, 0.1);
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 12px;
        width: fit-content;
    }

    .video-item-title {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.4;
        color: var(--text-main);
        margin-bottom: 8px;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .uploader-meta {
        font-size: 0.85rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }

    .uploader-meta i { font-size: 0.75rem; }

</style>

<div class="gallery-wrapper">
    <div class="container">
        
        <header class="gallery-header">
            <div>
                <h1 class="gallery-title"><?php echo htmlspecialchars(t('video_archive')); ?></h1>
                <p class="text-muted mt-2"><?php echo htmlspecialchars(t('video_sub')); ?></p>
            </div>
            <div class="d-none d-md-block">
                <button class="btn btn-outline-dark rounded-pill px-4 fw-bold small">
                    <i class="fas fa-filter me-2"></i> <?php echo htmlspecialchars(t('categories')); ?>
                </button>
            </div>
        </header>

        <?php if (empty($videos)): ?>
            <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                <i class="fas fa-video-slash fa-3x text-muted mb-3 opacity-25"></i>
                <h5 class="text-muted"><?php echo htmlspecialchars(t('no_media')); ?></h5>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($videos as $v): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="video-item">
                        <a href="?page=videos_view&id=<?php echo (int)$v['id']; ?>" class="thumb-container">
                            <?php if (!empty($v['thumbnail'])): ?>
                                <img src="uploads/videos/<?php echo htmlspecialchars($v['thumbnail']); ?>" class="video-thumb" alt="">
                            <?php else: ?>
                                <div class="video-thumb d-flex align-items-center justify-content-center bg-dark">
                                    <i class="fas fa-play text-white opacity-25 fa-2x"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="play-overlay">
                                <div class="play-icon">
                                    <i class="fas fa-play ms-1"></i>
                                </div>
                            </div>
                        </a>

                        <div class="video-info">
                            <span class="video-badge">PAS Academy</span>
                            <a href="?page=videos_view&id=<?php echo (int)$v['id']; ?>" class="video-item-title text-decoration-none">
                                <?php echo htmlspecialchars($v['title']); ?>
                            </a>
                            <div class="uploader-meta">
                                <i class="fas fa-user-circle"></i>
                                <span><?php echo htmlspecialchars($v['uploader_email']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>