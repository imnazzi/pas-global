<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; } ?>

<style>
    .studio-bg {
        background: #f0f4f2;
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(74, 222, 128, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(6, 58, 21, 0.05) 0%, transparent 40%);
        min-height: 100vh;
        padding: 60px 0;
    }

    /* Glass Control Panel */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    }

    .form-label-caps {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--brand-deep);
        margin-bottom: 10px;
        display: block;
    }

    .modern-input {
        background: rgba(255, 255, 255, 0.8) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        transition: all 0.3s ease;
    }

    .modern-input:focus {
        border-color: var(--brand-bright) !important;
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.1) !important;
    }

    /* Live Preview Card */
    .preview-sticky {
        position: sticky;
        top: 100px;
    }

    .event-card-preview {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 30px 60px -12px rgba(0,0,0,0.1);
        transition: all 0.5s ease;
    }

    .event-card-accent {
        height: 8px;
        background: var(--brand-gradient);
    }

    .btn-deploy {
        background: var(--brand-gradient);
        color: white;
        border: none;
        border-radius: 14px;
        padding: 16px;
        font-weight: 700;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(6, 58, 21, 0.15);
    }

    .btn-deploy:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(6, 58, 21, 0.25);
    }
</style>

<div class="studio-bg">
    <div class="container">
        <div class="row g-5">
            
            <div class="col-lg-7">
                <div class="glass-panel">
                    <header class="mb-5">
                        <h2 class="fw-800" style="color: var(--brand-deep);">Event Creator</h2>
                        <p class="text-muted small">Coordinate global workshops and network lectures.</p>
                    </header>

                    <form id="eventForm" method="post" action="api/calendar_create.php">
                        <div class="mb-4">
                            <label class="form-label-caps">Session Title</label>
                            <input name="title" id="inTitle" class="form-control modern-input" placeholder="e.g. Advanced Bio-Tech Seminar" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-caps">Agenda & Details</label>
                            <textarea name="description" id="inDesc" class="form-control modern-input" rows="4" placeholder="Brief overview of the event..."></textarea>
                        </div>

                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="form-label-caps">Start Date & Time</label>
                                <input type="datetime-local" name="start_at" id="inStart" class="form-control modern-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-caps">End Date & Time</label>
                                <input type="datetime-local" name="end_at" id="inEnd" class="form-control modern-input">
                            </div>
                        </div>

                        <button type="submit" class="btn-deploy" id="btnSubmit">
                            <i class="fas fa-calendar-plus me-2"></i> Deploy to Global Calendar
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="preview-sticky">
                    <span class="form-label-caps text-center mb-3">Live Network Preview</span>
                    
                    <div class="event-card-preview">
                        <div class="event-card-accent"></div>
                        <div class="p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success-subtle text-success p-2 rounded-3 me-3">
                                    <i class="fas fa-calendar-day fa-lg"></i>
                                </div>
                                <div>
                                    <span class="text-muted extra-small fw-bold text-uppercase">Upcoming Session</span>
                                    <h5 class="m-0 fw-bold text-dark" id="pvTitle">Event Title Placeholder</h5>
                                </div>
                            </div>
                            
                            <p class="small text-secondary mb-4" id="pvDesc">The agenda details will appear here as you type them in the editor...</p>
                            
                            <div class="border-top pt-3">
                                <div class="row">
                                    <div class="col-6 border-end">
                                        <span class="extra-small text-muted d-block text-uppercase fw-bold">Begins</span>
                                        <span class="small fw-bold text-dark" id="pvStart">-- : --</span>
                                    </div>
                                    <div class="col-6 ps-3">
                                        <span class="extra-small text-muted d-block text-uppercase fw-bold">Ends</span>
                                        <span class="small fw-bold text-dark" id="pvEnd">-- : --</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-white border rounded-4 d-flex align-items-center">
                        <i class="fas fa-info-circle text-success me-2"></i>
                        <span class="extra-small text-muted">This event will be visible to all <strong>PAS Global</strong> authorized members.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function() {
    const fields = ['Title', 'Desc', 'Start', 'End'];
    
    fields.forEach(field => {
        const input = document.getElementById('in' + field);
        const preview = document.getElementById('pv' + field);
        
        input.addEventListener('input', () => {
            if (input.type === 'datetime-local') {
                preview.textContent = input.value ? input.value.replace('T', ' @ ') : '-- : --';
            } else {
                preview.textContent = input.value || (field === 'Title' ? 'Event Title Placeholder' : '...');
            }
        });
    });

    document.getElementById('eventForm').onsubmit = function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Deploying...';
    };
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>