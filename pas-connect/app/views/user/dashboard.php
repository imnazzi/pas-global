<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --brand-deep: #063A15;
        --brand-bright: #4ade80;
        --glass-bg: rgba(255, 255, 255, 0.85);
    }

    .hub-bg {
        background: #f0f4f2;
        background-image: 
            radial-gradient(at 0% 0%, rgba(74, 222, 128, 0.08) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(6, 58, 21, 0.05) 0px, transparent 50%);
        min-height: 100vh;
        padding-bottom: 80px;
    }

    .hub-header {
        padding: 60px 0 40px;
    }

    .welcome-text h1 {
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--brand-deep);
        font-size: 2.5rem;
    }

    /* Quick Access Action Cards */
    .action-card {
        background: var(--brand-gradient);
        border-radius: 24px;
        padding: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        box-shadow: 0 15px 30px rgba(6, 58, 21, 0.15);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        min-height: 200px;
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(6, 58, 21, 0.25);
    }

    .action-card i.bg-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.1;
        transform: rotate(-15deg);
    }

    /* Content Feed Glass Cards */
    .feed-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 28px;
        height: 100%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }

    .feed-header {
        padding: 24px 30px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .feed-header h5 {
        font-weight: 800;
        margin: 0;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--brand-deep);
    }

    /* The "Smart" List Items */
    .smart-item {
        padding: 16px 30px;
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 15px;
        text-decoration: none !important;
    }

    .smart-item:hover {
        background: rgba(74, 222, 128, 0.05);
    }

    .smart-item .avatar-mini {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-deep);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        flex-shrink: 0;
    }

    .smart-item .content-info {
        flex-grow: 1;
    }

    .smart-item .title-link {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 2px;
    }

    .date-pill {
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
    }

    /* Calendar Specific Styles */
    .cal-date-box {
        background: #fff;
        padding: 8px 12px;
        border-radius: 14px;
        text-align: center;
        min-width: 55px;
        border: 1px solid #edf2f7;
    }

    .cal-day { font-size: 1.1rem; font-weight: 800; color: #ef4444; line-height: 1; }
    .cal-month { font-size: 0.65rem; font-weight: 700; color: #64748b; text-transform: uppercase; }

</style>

<div class="hub-bg">
    <div class="container">
        
        <header class="hub-header">
            <div class="row align-items-center g-4">
                <div class="col-md-7 welcome-text">
                    <h1><?php echo htmlspecialchars(t('portal_dashboard')); ?></h1>
                    <p class="text-muted lead"><?php echo htmlspecialchars(t('welcome_back_center')); ?></p>
                </div>
                <div class="col-md-5 d-flex justify-content-md-end gap-3">
                    <a href="?page=messages_inbox" class="btn btn-dark px-4 py-3 rounded-4 fw-bold">
                        <i class="fas fa-envelope-open-text me-2"></i> <?php echo htmlspecialchars(t('inbox')); ?>
                    </a>
                </div>
            </div>
        </header>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="?page=videos" class="text-decoration-none">
                    <div class="action-card" style="background: linear-gradient(135deg, #063A15 0%, #0c7a2c 100%);">
                        <i class="fas fa-play-circle bg-icon"></i>
                        <div class="fw-bold small opacity-75">ACADEMY</div>
                        <h3 class="fw-800 m-0">Video Lectures</h3>
                        <span class="small mt-2">Browse the archive <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="?page=forums" class="text-decoration-none">
                    <div class="action-card" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                        <i class="fas fa-comments bg-icon"></i>
                        <div class="fw-bold small opacity-75">COMMUNITY</div>
                        <h3 class="fw-800 m-0">Discussion Forums</h3>
                        <span class="small mt-2">Join the conversation <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="?page=calendar" class="text-decoration-none">
                    <div class="action-card" style="background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);">
                        <i class="fas fa-calendar-alt bg-icon"></i>
                        <div class="fw-bold small opacity-75">EVENTS</div>
                        <h3 class="fw-800 m-0">Network Calendar</h3>
                        <span class="small mt-2">Schedule & Workshops <i class="fas fa-arrow-right ms-1"></i></span>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="feed-card">
                    <div class="feed-header">
                        <h5><i class="fas fa-rss me-2 text-success"></i> Latest Updates</h5>
                        <a href="?page=community" class="btn btn-sm btn-light rounded-pill px-3 fw-bold"><?php echo htmlspecialchars(t('view_more')); ?></a> 
                    </div>
                    <div class="p-0">
                        <?php
                        $posts = (function(){ 
                            $pdo = getPDO(); 
                            $stmt = $pdo->prepare('SELECT id, title, created_at FROM community_posts ORDER BY created_at DESC LIMIT 6'); 
                            $stmt->execute(); 
                            return $stmt->fetchAll(); 
                        })();
                        foreach($posts as $p): ?>
                            <a href="?page=community_view&id=<?=(int)$p['id']?>" class="smart-item">
                                <div class="avatar-mini">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <div class="content-info">
                                    <span class="title-link"><?=htmlspecialchars($p['title'])?></span>
                                    <span class="date-pill"><?=date('F d, Y', strtotime($p['created_at']))?></span>
                                </div>
                                <i class="fas fa-chevron-right text-muted opacity-25"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="feed-card shadow-sm" style="border-top: 5px solid #ef4444;">
                    <div class="feed-header">
                        <h5><i class="fas fa-bolt me-2 text-danger"></i> Schedule</h5>
                    </div>
                    <div class="p-0">
                        <?php
                        $events = (function(){ 
                            $pdo = getPDO(); 
                            $stmt = $pdo->prepare('SELECT id, title, start_at FROM calendar_events WHERE start_at >= NOW() ORDER BY start_at ASC LIMIT 4'); 
                            $stmt->execute(); 
                            return $stmt->fetchAll(); 
                        })();
                        foreach($events as $e): ?>
                            <a href="?page=calendar_view&id=<?=(int)$e['id']?>" class="smart-item">
                                <div class="cal-date-box">
                                    <div class="cal-day"><?=date('d', strtotime($e['start_at']))?></div>
                                    <div class="cal-month"><?=date('M', strtotime($e['start_at']))?></div>
                                </div>
                                <div class="content-info">
                                    <span class="title-link text-truncate" style="max-width:180px;"><?=htmlspecialchars($e['title'])?></span>
                                    <span class="text-danger small fw-bold"><?=date('h:i A', strtotime($e['start_at']))?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="p-3">
                        <a href="?page=calendar" class="btn btn-outline-danger w-100 rounded-3 fw-bold small">Open Full Calendar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>