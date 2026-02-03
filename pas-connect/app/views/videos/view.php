<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --player-bg: #f8fafc;
        --surface-white: #ffffff;
        --brand-emerald: #10b981;
        --text-main: #0f172a;
        --text-sub: #64748b;
        --border-soft: #e2e8f0;
    }

    .theater-wrapper {
        padding: 40px 0 80px;
        background: var(--player-bg);
        min-height: 100vh;
    }

    /* Video Player Container */
    .video-viewport {
        background: #000;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
        position: relative;
        aspect-ratio: 16 / 9;
        margin-bottom: 30px;
    }

    .video-viewport video {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Meta Content Area */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }

    @media (max-width: 992px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    .main-info {
        background: var(--surface-white);
        padding: 32px;
        border-radius: 24px;
        border: 1px solid var(--border-soft);
    }

    .video-title {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-main);
        margin-bottom: 15px;
    }

    .meta-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-soft);
    }

    .uploader-profile {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-icon {
        width: 45px;
        height: 45px;
        background: var(--brand-emerald);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .description-box {
        color: var(--text-sub);
        line-height: 1.7;
        font-size: 1rem;
        white-space: pre-line;
    }

    /* Sidebar Actions */
    .video-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .action-card {
        background: var(--surface-white);
        padding: 24px;
        border-radius: 20px;
        border: 1px solid var(--border-soft);
    }

    .action-card h6 {
        font-weight: 700;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: var(--text-sub);
    }

    .btn-action {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
        margin-bottom: 10px;
    }

    .btn-share { background: #f1f5f9; color: var(--text-main); border: none; }
    .btn-share:hover { background: #e2e8f0; }
</style>

<div class="theater-wrapper">
    <div class="container">
        
        <nav class="mb-4">
            <a href="?page=videos" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-chevron-left me-1"></i> BACK TO LIBRARY
            </a>
        </nav>

        <div class="video-viewport">
            <?php if (!empty($video['filename'])): ?>
                <video controls crossorigin playsinline>
                    <source src="uploads/videos/<?php echo htmlspecialchars($video['filename']); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center h-100 text-white">
                    <p>Video file not found.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="content-grid">
            
            <div class="main-info">
                <h1 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h1>
                
                <div class="meta-bar">
                    <div class="uploader-profile">
                        <div class="avatar-icon">
                            <?php echo strtoupper(substr($video['uploader_email'], 0, 1)); ?>
                        </div>
                        <div>
                            <div class="fw-bold text-main"><?php echo htmlspecialchars($video['uploader_email']); ?></div>
                            <div class="small text-muted">Uploaded on <?php echo date('M j, Y', strtotime($video['created_at'])); ?></div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-light text-dark border p-2 px-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i> Library Access
                        </span>
                    </div>
                </div>

                <div class="description-box">
                    <?php echo nl2br(htmlspecialchars($video['description'])); ?>
                </div>
            </div>

            <aside class="video-sidebar">
                <div class="action-card">
                    <h6>Video Actions</h6>
                    <button class="btn btn-action btn-share" onclick="copyUrl()">
                        <i class="fas fa-link"></i> Copy Link
                    </button>
                    <button class="btn btn-action btn-share">
                        <i class="fas fa-download"></i> Offline Access
                    </button>
                    <hr>
                    <p class="small text-muted text-center m-0">Secure internal playback active</p>
                </div>

                <div class="action-card bg-primary text-white border-0 shadow-sm" style="background: var(--brand-emerald) !important;">
                    <h6 class="text-white opacity-75">Community Note</h6>
                    <p class="small m-0">This video is part of the internal PAS Knowledge Base. Please do not share outside the secure portal.</p>
                </div>
            </aside>
        </div>
    </div>
</div>

<script>
function copyUrl() {
    navigator.clipboard.writeText(window.location.href);
    alert('Video link copied to clipboard!');
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>