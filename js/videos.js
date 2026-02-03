// Video Ceramah Functions
if (!checkAuth()) window.location.href = 'index.html';

let currentVideoId = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    loadVideos();
    populateCountryFilter();
});

// Load videos
async function loadVideos() {
    const container = document.getElementById('videoGrid');
    container.innerHTML = '<div class="loading-container"><div class="loading"></div><p style="margin-top: 15px;">Memuatkan video...</p></div>';
    
    try {
        const [videosRes, usersRes] = await Promise.all([
            fetch('tables/videos?limit=1000&sort=-created_at'),
            fetch('tables/users?limit=1000')
        ]);
        
        const videos = await videosRes.json();
        const users = await usersRes.json();
        const usersMap = new Map(users.data.map(u => [u.id, u]));
        
        if (videos.data.length === 0) {
            await createSampleVideos();
            loadVideos();
            return;
        }
        
        container.innerHTML = videos.data.map(video => {
            const uploader = usersMap.get(video.uploader_id) || { full_name: 'Unknown' };
            const categoryClass = video.category.toLowerCase().replace(' ', '-');
            const thumbnailUrl = video.thumbnail_url || getVideoThumbnail(video.video_url);
            const isNew = isVideoNew(video.created_at);
            
            return `
                <div class="video-card" onclick="playVideo('${video.id}')">
                    <div class="video-thumbnail">
                        <img src="${thumbnailUrl}" alt="${video.title}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22200%22%3E%3Crect fill=%22%230a1f1a%22 width=%22320%22 height=%22200%22/%3E%3Ctext fill=%22%23006838%22 font-size=%2220%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3E%F0%9F%8E%AC Video%3C/text%3E%3C/svg%3E'">
                        <div class="play-overlay">
                            <div class="play-icon">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        ${video.duration ? `<div class="video-duration-badge">${video.duration}</div>` : ''}
                        ${isNew ? '<div class="new-badge">BARU</div>' : ''}
                    </div>
                    <div class="video-card-content">
                        <div class="video-category-badge category-${categoryClass}">
                            ${getCategoryIcon(video.category)} ${video.category}
                        </div>
                        <div class="video-title">${video.title}</div>
                        <div class="video-speaker">
                            <i class="fas fa-user-tie"></i>
                            ${video.speaker}
                        </div>
                        <div class="video-stats">
                            <span>
                                <i class="fas fa-eye"></i>
                                ${video.views || 0}
                            </span>
                            <span>
                                <i class="fas fa-thumbs-up"></i>
                                ${video.likes || 0}
                            </span>
                            <span>
                                <i class="fas fa-map-marker-alt"></i>
                                ${video.country || 'Global'}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        
    } catch (error) {
        console.error('Error loading videos:', error);
        container.innerHTML = `
            <div class="video-empty-state">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Ralat Memuatkan Video</h3>
                <p>Sila cuba lagi sebentar</p>
            </div>
        `;
    }
}

// Get video thumbnail
function getVideoThumbnail(url) {
    // YouTube thumbnail
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoId = extractYouTubeId(url);
        if (videoId) {
            return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
        }
    }
    
    // Vimeo thumbnail (would need API call in production)
    if (url.includes('vimeo.com')) {
        return 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22200%22%3E%3Crect fill=%22%230a1f1a%22 width=%22320%22 height=%22200%22/%3E%3Ctext fill=%22%23006838%22 font-size=%2220%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3E%F0%9F%8E%A5 Vimeo%3C/text%3E%3C/svg%3E';
    }
    
    // Default placeholder
    return 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22200%22%3E%3Crect fill=%22%230a1f1a%22 width=%22320%22 height=%22200%22/%3E%3Ctext fill=%22%23006838%22 font-size=%2220%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3E%F0%9F%8E%AC Video%3C/text%3E%3C/svg%3E';
}

// Extract YouTube ID
function extractYouTubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}

// Get category icon
function getCategoryIcon(category) {
    const icons = {
        'Ceramah Agama': '🕌',
        'Tazkirah': '📿',
        'Kuliah': '📚',
        'Motivasi': '💪',
        'Pendidikan': '🎓',
        'Lain-lain': '📹'
    };
    return icons[category] || '📹';
}

// Check if video is new (within 7 days)
function isVideoNew(createdAt) {
    const videoDate = new Date(createdAt);
    const now = new Date();
    const diffTime = Math.abs(now - videoDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays <= 7;
}

// Play video
async function playVideo(videoId) {
    currentVideoId = videoId;
    
    try {
        const response = await fetch(`tables/videos/${videoId}`);
        const video = await response.json();
        
        // Update views
        await fetch(`tables/videos/${videoId}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ views: (video.views || 0) + 1 })
        });
        
        // Show modal
        document.getElementById('playerTitle').textContent = video.title;
        document.getElementById('playerSpeaker').textContent = video.speaker;
        document.getElementById('playerDuration').textContent = video.duration || 'N/A';
        document.getElementById('playerCountry').textContent = video.country || 'Global';
        document.getElementById('playerViews').textContent = (video.views || 0) + 1;
        document.getElementById('playerLikes').textContent = video.likes || 0;
        document.getElementById('playerDescription').textContent = video.description || 'Tiada penerangan';
        
        // Embed video
        const playerDiv = document.getElementById('videoPlayer');
        playerDiv.innerHTML = embedVideo(video.video_url);
        
        document.getElementById('playerModal').classList.add('active');
        
    } catch (error) {
        console.error('Error playing video:', error);
        showAlert('Ralat memuatkan video', 'danger');
    }
}

// Embed video
function embedVideo(url) {
    // YouTube
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoId = extractYouTubeId(url);
        if (videoId) {
            return `<iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        }
    }
    
    // Vimeo
    if (url.includes('vimeo.com')) {
        const videoId = url.split('/').pop();
        return `<iframe src="https://player.vimeo.com/video/${videoId}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
    }
    
    // Direct video file
    if (url.endsWith('.mp4') || url.endsWith('.webm') || url.endsWith('.ogg')) {
        return `<video controls playsinline webkit-playsinline style="width: 100%; height: 500px;">
            <source src="${url}" type="video/mp4">
            Pelayar anda tidak menyokong tag video.
        </video>`;
    }
    
    // Default iframe
    return `<iframe src="${url}" frameborder="0" allowfullscreen style="width: 100%; height: 500px;"></iframe>`;
}

// Close player modal
function closePlayerModal() {
    document.getElementById('playerModal').classList.remove('active');
    document.getElementById('videoPlayer').innerHTML = '';
    loadVideos(); // Refresh to update views
}

// Like video
async function likeVideo() {
    if (!currentVideoId) return;
    
    try {
        const response = await fetch(`tables/videos/${currentVideoId}`);
        const video = await response.json();
        
        await fetch(`tables/videos/${currentVideoId}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ likes: (video.likes || 0) + 1 })
        });
        
        document.getElementById('playerLikes').textContent = (video.likes || 0) + 1;
        showAlert('Terima kasih atas sokongan anda!', 'success');
        
    } catch (error) {
        console.error('Error liking video:', error);
    }
}

// Share video
function shareVideo() {
    if (!currentVideoId) return;
    
    const shareUrl = `${window.location.origin}/videos.html?v=${currentVideoId}`;
    
    if (navigator.share) {
        navigator.share({
            title: document.getElementById('playerTitle').textContent,
            text: 'Tonton video ceramah ini di PAS Global Connect',
            url: shareUrl
        }).catch(err => console.log('Error sharing:', err));
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(shareUrl).then(() => {
            showAlert('Link video telah disalin!', 'success');
        });
    }
}

// Upload modal
function showUploadModal() {
    document.getElementById('uploadModal').classList.add('active');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('active');
    document.getElementById('uploadForm').reset();
}

// Upload video
async function uploadVideo(e) {
    e.preventDefault();
    const user = getCurrentUser();
    
    const video = {
        id: generateUUID(),
        title: sanitizeInput(document.getElementById('videoTitle').value),
        description: sanitizeInput(document.getElementById('videoDescription').value),
        category: document.getElementById('videoCategory').value,
        video_url: document.getElementById('videoUrl').value,
        thumbnail_url: document.getElementById('thumbnailUrl').value,
        speaker: sanitizeInput(document.getElementById('videoSpeaker').value),
        duration: document.getElementById('videoDuration').value,
        country: sanitizeInput(document.getElementById('videoCountry').value) || user.country,
        uploader_id: user.id,
        views: 0,
        likes: 0
    };
    
    try {
        await fetch('tables/videos', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(video)
        });
        
        showAlert('Video berjaya dimuat naik!', 'success');
        closeUploadModal();
        loadVideos();
        
    } catch (error) {
        console.error('Error uploading video:', error);
        showAlert('Ralat memuat naik video', 'danger');
    }
}

// Search videos
function searchVideos() {
    const search = document.getElementById('searchVideos').value.toLowerCase();
    document.querySelectorAll('.video-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(search) ? 'block' : 'none';
    });
}

// Filter videos
function filterVideos() {
    const category = document.getElementById('categoryFilter').value;
    const country = document.getElementById('countryFilter').value;
    
    document.querySelectorAll('.video-card').forEach(card => {
        const cardCategory = card.querySelector('.video-category-badge').textContent.trim();
        const cardCountry = card.querySelector('.video-stats span:last-child').textContent.trim();
        
        const categoryMatch = !category || cardCategory.includes(category);
        const countryMatch = !country || cardCountry.includes(country);
        
        card.style.display = (categoryMatch && countryMatch) ? 'block' : 'none';
    });
}

// Populate country filter
async function populateCountryFilter() {
    try {
        const response = await fetch('tables/videos?limit=1000');
        const data = await response.json();
        
        const countries = [...new Set(data.data.map(v => v.country).filter(c => c))];
        const select = document.getElementById('countryFilter');
        
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country;
            option.textContent = country;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading countries:', error);
    }
}

// Create sample videos
async function createSampleVideos() {
    const user = getCurrentUser();
    
    const samples = [
        {
            id: generateUUID(),
            title: 'Ceramah Ramadan: Keistimewaan Bulan Ramadan',
            description: 'Ceramah mengenai keistimewaan dan kelebihan bulan Ramadan serta amalan-amalan yang digalakkan.',
            category: 'Ceramah Agama',
            video_url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            thumbnail_url: '',
            speaker: 'Ustaz Ahmad bin Abdullah',
            duration: '45:30',
            country: user.country,
            uploader_id: user.id,
            views: 125,
            likes: 45
        },
        {
            id: generateUUID(),
            title: 'Tazkirah Pagi: Keutamaan Solat Berjemaah',
            description: 'Tazkirah ringkas mengenai keutamaan dan pahala solat berjemaah di masjid.',
            category: 'Tazkirah',
            video_url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            thumbnail_url: '',
            speaker: 'Ustaz Muhammad bin Ali',
            duration: '15:20',
            country: user.country,
            uploader_id: user.id,
            views: 89,
            likes: 32
        },
        {
            id: generateUUID(),
            title: 'Kuliah Fiqh: Zakat Fitrah dan Zakat Harta',
            description: 'Kuliah mengenai hukum-hakam zakat fitrah dan zakat harta menurut mazhab Syafie.',
            category: 'Kuliah',
            video_url: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            thumbnail_url: '',
            speaker: 'Ustaz Dr. Hassan bin Omar',
            duration: '1:15:00',
            country: user.country,
            uploader_id: user.id,
            views: 234,
            likes: 78
        }
    ];
    
    for (const video of samples) {
        await fetch('tables/videos', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(video)
        });
    }
}

// Check for video ID in URL
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const videoId = urlParams.get('v');
    if (videoId) {
        setTimeout(() => playVideo(videoId), 1000);
    }
});