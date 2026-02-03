<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; } ?>

<style>
    .newsroom-wrapper {
        padding: 50px 0;
        background: #f8faf9;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .editor-canvas {
        background: #ffffff;
        border-radius: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 20px 60px rgba(0,0,0,0.04);
        padding: 40px;
    }

    .section-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--brand-bright);
        margin-bottom: 20px;
        display: block;
    }

    /* Seamless Inputs */
    .input-title {
        font-size: 2.25rem;
        font-weight: 800;
        border: none;
        border-bottom: 2px solid #f1f5f9;
        border-radius: 0;
        padding: 10px 0;
        color: var(--brand-deep);
        margin-bottom: 30px;
    }

    .input-title:focus {
        box-shadow: none;
        border-color: var(--brand-bright);
    }

    .input-body {
        font-size: 1.1rem;
        border: none;
        resize: none;
        line-height: 1.6;
        color: #475569;
    }

    .input-body:focus { box-shadow: none; }

    /* Floating Control Panel */
    .control-panel {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
    }

    /* Image Upload Zone */
    .image-dropzone {
        border: 2px dashed #e2e8f0;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fdfdfd;
    }

    .image-dropzone:hover {
        border-color: var(--brand-bright);
        background: #f0fdf4;
    }

    #commPreview {
        width: 100%;
        border-radius: 12px;
        margin-top: 15px;
        display: none;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-publish {
        background: var(--brand-gradient);
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 700;
        width: 100%;
        color: white;
        transition: all 0.3s;
    }

    .btn-publish:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(6, 58, 21, 0.2);
    }
</style>

<div class="newsroom-wrapper">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="editor-canvas">
                    <span class="section-label">Drafting Community News</span>
                    <form id="communityForm">
                        <input name="title" class="form-control input-title" placeholder="Catchy Headline..." required>
                        
                        <textarea name="body" class="form-control input-body" rows="12" placeholder="Tell the community what's happening..." required></textarea>
                        
                        <input id="commImage" type="file" name="image" accept="image/*" hidden>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="control-panel">
                    <h6 class="fw-bold mb-3 text-dark">Publishing Options</h6>
                    
                    <div class="mb-4">
                        <label class="small text-muted mb-2 fw-bold">Cover Image</label>
                        <div class="image-dropzone" onclick="document.getElementById('commImage').click()">
                            <i class="fas fa-image text-muted mb-1"></i>
                            <p class="extra-small m-0 text-muted">Click to attach media</p>
                        </div>
                        <img id="commPreview" src="#" />
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="announcement" id="announceCheck" form="communityForm">
                            <label class="form-check-label fw-bold small" for="announceCheck">Priority Announcement</label>
                        </div>
                        <p class="extra-small text-muted mt-1">This will pin the post and notify all global members.</p>
                    </div>

                    <button class="btn-publish" id="commSubmit" form="communityForm">
                        <i class="fas fa-paper-plane me-2"></i> Broadcast Post
                    </button>
                    
                    <button class="btn btn-link btn-sm w-100 mt-3 text-muted text-decoration-none" onclick="history.back()">Discard Draft</button>
                </div>

                <div class="mt-4 p-3 rounded-4 bg-success-subtle border border-success-subtle">
                    <p class="small m-0 text-success">
                        <i class="fas fa-circle-info me-1"></i> 
                        <strong>Pro-tip:</strong> Announcements receive 3x more engagement than standard posts.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const imgInput = document.getElementById('commImage');
    const imgPreview = document.getElementById('commPreview');
    const form = document.getElementById('communityForm');
    const btn = document.getElementById('commSubmit');

    imgInput.onchange = function(){
        const file = this.files[0];
        if (file){
            imgPreview.src = URL.createObjectURL(file);
            imgPreview.style.display = 'block';
        }
    };

    form.onsubmit = function(e){
        e.preventDefault();
        const fd = new FormData(this);
        // Important: Get the checkbox value from the form scope
        fd.append('announcement', document.getElementById('announceCheck').checked ? '1' : '0');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Broadcasting...';

        fetch('api/community_create.php', { 
            method: 'POST', 
            body: fd 
        })
        .then(r => r.json())
        .then(j => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Broadcast Post';
            if (j.success){
                showFlash('Broadcast successful', 'success');
                setTimeout(() => location.href='?page=community', 800);
            } else {
                showFlash('Failed: ' + (j.error || 'Check server logs'), 'error');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Broadcast Post';
            showFlash('Network timeout', 'error');
        });
    };
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>