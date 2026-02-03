<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --page-bg: #f8fafc;
        --card-white: #ffffff;
        --brand-emerald: #10b981;
        --text-main: #0f172a;
        --text-sub: #64748b;
        --border-soft: #e2e8f0;
    }

    .event-wrapper {
        padding: 60px 0 100px;
        background: var(--page-bg);
        min-height: 100vh;
    }

    .event-header {
        max-width: 1000px;
        margin: 0 auto 40px;
    }

    .event-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 30px;
        max-width: 1000px;
        margin: 0 auto;
    }

    @media (max-width: 992px) {
        .event-grid { grid-template-columns: 1fr; }
    }

    /* Primary Content Card */
    .event-main-card {
        background: var(--card-white);
        border: 1px solid var(--border-soft);
        border-radius: 28px;
        padding: 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .event-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--text-main);
        margin-bottom: 25px;
        line-height: 1.2;
    }

    .event-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-body);
        white-space: pre-line;
    }

    /* Info Sidebar */
    .event-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-box {
        background: var(--card-white);
        border: 1px solid var(--border-soft);
        border-radius: 24px;
        padding: 24px;
    }

    .info-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-sub);
        margin-bottom: 12px;
        display: block;
    }

    .info-value {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-weight: 600;
        color: var(--text-main);
    }

    .info-icon {
        width: 32px;
        height: 32px;
        background: var(--brand-emerald);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    /* CTA Buttons */
    .btn-rsvp {
        width: 100%;
        padding: 14px;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        background: var(--brand-emerald);
        color: white;
        transition: all 0.3s;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }

    .btn-rsvp:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 15px 20px -3px rgba(16, 185, 129, 0.3);
    }

    .calendar-sync {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: var(--brand-emerald);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 700;
    }
</style>

<div class="event-wrapper">
    <div class="container">
        
        <div class="event-header">
            <a href="?page=calendar" class="text-decoration-none text-muted small fw-bold">
                <i class="fas fa-arrow-left me-1"></i> BACK TO SCHEDULE
            </a>
        </div>

        <div class="event-grid">
            
            <div class="event-main-card">
                <span class="badge mb-3 px-3 py-2 rounded-pill" style="background: rgba(16, 185, 129, 0.1); color: var(--brand-emerald); font-weight: 700; font-size: 0.75rem;">Official Event</span>
                <h1 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h1>
                
                <div class="event-description">
                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                </div>
            </div>

            <aside class="event-sidebar">
                <div class="info-box">
                    <div class="mb-4">
                        <span class="info-label">When</span>
                        <div class="info-value">
                            <div class="info-icon"><i class="far fa-calendar-alt"></i></div>
                            <div>
                                <div><?php echo date('F j, Y', strtotime($event['start_at'])); ?></div>
                                <div class="text-muted small"><?php echo date('H:i', strtotime($event['start_at'])); ?> - 
                                    <?php echo $event['end_at'] ? date('H:i', strtotime($event['end_at'])) : 'End TBD'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="info-label">Organizer</span>
                        <div class="info-value">
                            <div class="info-icon"><i class="far fa-user"></i></div>
                            <div>
                                <div class="small fw-bold"><?php echo htmlspecialchars($event['creator_email']); ?></div>
                                <div class="text-muted" style="font-size: 0.7rem;">Verified PAS Member</div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-rsvp">
                        I'm Attending
                    </button>
                    <a href="#" class="calendar-sync"><i class="far fa-calendar-plus me-1"></i> Add to Calendar</a>
                </div>

                <div class="info-box bg-light border-0">
                    <span class="info-label text-muted">Privacy Note</span>
                    <p class="small text-muted m-0">This event is private to the PAS Global network. Recording without consent is prohibited.</p>
                </div>
            </aside>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>