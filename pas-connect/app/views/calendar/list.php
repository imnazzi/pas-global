<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --cal-bg: #f8fafc;
        --cal-card: #ffffff;
        --brand-emerald: #10b981;
        --text-main: #0f172a;
        --text-sub: #64748b;
        --border-light: #e2e8f0;
    }

    .calendar-wrapper {
        padding: 50px 0;
        background: var(--cal-bg);
        min-height: 100vh;
    }

    .calendar-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
    }

    .calendar-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: var(--text-main);
        margin: 0;
    }

    /* Event Card Design */
    .event-card {
        background: var(--cal-card);
        border: 1px solid var(--border-light);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 24px;
        text-decoration: none !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateX(8px);
        border-color: var(--brand-emerald);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.04);
    }

    /* Date Badge Logic */
    .date-badge {
        width: 70px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .event-card:hover .date-badge {
        background: var(--brand-emerald);
        color: white;
    }

    .date-day {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
    }

    .date-month {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 4px;
    }

    /* Event Content */
    .event-content {
        flex-grow: 1;
    }

    .event-type {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--brand-emerald);
        margin-bottom: 4px;
        display: block;
    }

    .event-headline {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .event-meta {
        font-size: 0.85rem;
        color: var(--text-sub);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .event-meta i { font-size: 0.8rem; }

    /* Right Action Arrow */
    .event-arrow {
        color: #cbd5e1;
        font-size: 1.2rem;
        transition: transform 0.3s;
    }

    .event-card:hover .event-arrow {
        transform: translateX(5px);
        color: var(--brand-emerald);
    }
</style>

<div class="calendar-wrapper">
    <div class="container">
        
        <div class="calendar-container">
            <header class="calendar-header">
                <div>
                    <h1 class="calendar-title">Upcoming <span style="color: var(--brand-emerald)">Events</span></h1>
                    <p class="text-muted mt-1">Your schedule for the PAS Global network.</p>
                </div>
                <div class="d-none d-md-block">
                    <button class="btn btn-outline-dark rounded-pill px-4 fw-bold small">
                        <i class="far fa-calendar-plus me-2"></i> Add Event
                    </button>
                </div>
            </header>

            <?php if (empty($events)): ?>
                <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                    <i class="far fa-calendar-times fa-3x text-muted mb-3 opacity-20"></i>
                    <h5 class="text-muted">No scheduled events found.</h5>
                </div>
            <?php else: ?>
                <div class="schedule-list">
                    <?php foreach ($events as $e): 
                        $timestamp = strtotime($e['start_at']);
                        $day = date('d', $timestamp);
                        $month = date('M', $timestamp);
                        $time = date('H:i', $timestamp);
                    ?>
                    <a href="?page=calendar_view&id=<?php echo (int)$e['id']; ?>" class="event-card">
                        <div class="date-badge">
                            <span class="date-day"><?php echo $day; ?></span>
                            <span class="date-month"><?php echo $month; ?></span>
                        </div>
                        
                        <div class="event-content">
                            <span class="event-type">Scheduled Meeting</span>
                            <div class="event-headline"><?php echo htmlspecialchars($e['title']); ?></div>
                            <div class="event-meta">
                                <span><i class="far fa-clock me-1"></i> <?php echo $time; ?></span>
                                <span><i class="far fa-user me-1"></i> <?php echo htmlspecialchars($e['creator_email']); ?></span>
                            </div>
                        </div>

                        <div class="event-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>