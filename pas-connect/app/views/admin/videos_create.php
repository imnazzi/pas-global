<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php if (empty($_SESSION['admin_id'])) { header('Location: ?page=login'); exit; } ?>

<style>
    .studio-wrapper {
        padding: 40px 0;
        background: #f8faf9;
        min-height: 100vh;
    }

    /* Glass Card */
    .studio-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .studio-header {
        background: var(--brand-gradient);
        padding: 30px;
        color: white;
    }

    /* Custom File Dropzone */
    .dropzone-area {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s;
        background: #fdfdfd;
        cursor: pointer;
        position: relative;
    }

    .dropzone-area:hover {
        border-color: var(--brand-bright);
        background: #f0fdf4;
    }

    .dropzone-icon {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    /* Progress Bar */
    .upload-progress-container {
        display: none;
        margin-top: 20px;
    }

    .progress {
        height: 10px;
        border-radius: 20px;
        background-color: #e2e8f0;
    }

    .progress-bar {
        background: var(--brand-gradient);
        transition: width 0.4s ease;
    }

    /* Preview Styling */
    #videoPreview {
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        background: #000;
        margin-top: 15px;
    }

    .preview-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
    }

    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.15);
        border-color: var(--brand-bright);
    }
</style>

<div class="studio-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="studio-card">
                    <div class="studio-header">
                        <h3 class="m-0 fw-bold"><i class="fas fa-clapperboard me-2"></i> Media Studio</h3>
                        <p class="small opacity-75 mb-0">Upload and optimize global video assets</p>
                    </div>

                    <form id="videoForm" class="p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Video Title</label>
                                    <input name="title" class="form-control" placeholder="Enter a descriptive title..." required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Detailed Description</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="What is this video about?"></textarea>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="publish" id="publishCheck">
                                        <label class="form-check-label fw-bold" for="publishCheck">Make publicly visible immediately</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="preview-label">1. Source File (MP4)</label>
                                <div class="dropzone-area mb-3" onclick="document.getElementById('videoInput').click()">
                                    <i class="fas fa-cloud-arrow-up dropzone-icon"></i>
                                    <p class="small text-muted m-0">Click to upload or drag & drop MP4</p>
                                    <input id="videoInput" type="file" name="video" accept="video/mp4" hidden required>
                                </div>
                                <video id="videoPreview" controls style="width:100%; display:none;"></video>

                                <div class="mt-4">
                                    <label class="preview-label">2. Custom Thumbnail</label>
                                    <input id="thumbInput" type="file" name="thumbnail" accept="image/*" class="form-control mb-2">
                                    <img id="thumbPreview" class="img-fluid rounded" style="display:none; border: 1px solid #ddd;" />
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="upload-progress-container" id="progressContainer">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small fw-bold text-muted">Uploading to Global CDN...</span>
                                <span class="small fw-bold text-success" id="progressPercent">0%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-link text-muted text-decoration-none" onclick="history.back()">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-success px-5 fw-bold" id="videoSubmit" style="border-radius: 12px; background: var(--brand-gradient); border:none;">
                                <i class="fas fa-paper-plane me-2"></i> Start Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const vInput = document.getElementById('videoInput');
    const tInput = document.getElementById('thumbInput');
    const vPrev = document.getElementById('videoPreview');
    const tPrev = document.getElementById('thumbPreview');
    const form = document.getElementById('videoForm');
    const btn = document.getElementById('videoSubmit');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');

    // Video Preview
    vInput.onchange = function() {
        const file = this.files[0];
        if (file) {
            vPrev.src = URL.createObjectURL(file);
            vPrev.style.display = 'block';
        }
    };

    // Thumbnail Preview
    tInput.onchange = function() {
        const file = this.files[0];
        if (file) {
            tPrev.src = URL.createObjectURL(file);
            tPrev.style.display = 'block';
        }
    };

    // AJAX Upload with Progress
    form.onsubmit = function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        
        btn.disabled = true;
        progressContainer.style.display = 'block';

        const xhr = new XMLHttpRequest();
        // Use relative path so it works when the app is nested under a folder
        xhr.open('POST', 'api/videos_upload.php', true);

        // Track Progress
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressPercent.innerText = percent + '%';
            }
        };

        xhr.onload = function() {
            let j = null;
            try {
                j = JSON.parse(xhr.responseText);
            } catch (err) {
                console.error('Invalid JSON response from server:', xhr.responseText);
                btn.disabled = false;
                if (window.showFlash) showFlash('Server returned an unexpected response.', 'error');
                return;
            }
            if (j.success) {
                if(window.showFlash) showFlash('Video optimized and uploaded!', 'success');
                setTimeout(() => location.href='?page=admin_videos', 1000);
            } else {
                btn.disabled = false;
                if(window.showFlash) showFlash('Error: ' + j.error, 'error');
            }
        };

        xhr.onerror = function() {
            btn.disabled = false;
            showFlash('Connection lost', 'error');
        };

        xhr.send(fd);
    };
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>