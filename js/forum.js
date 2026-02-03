// Forum Functions
if (!checkAuth()) window.location.href = 'index.html';

document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    loadForumTopics();
});

async function loadForumTopics() {
    const container = document.getElementById('forumTopics');
    container.innerHTML = '<div class="loading-container"><div class="loading"></div></div>';
    
    try {
        const [topicsRes, usersRes, postsRes] = await Promise.all([
            fetch('tables/forum_topics?limit=1000&sort=-created_at'),
            fetch('tables/users?limit=1000'),
            fetch('tables/forum_posts?limit=1000')
        ]);
        
        const topics = await topicsRes.json();
        const users = await usersRes.json();
        const posts = await postsRes.json();
        
        const usersMap = new Map(users.data.map(u => [u.id, u]));
        
        if (topics.data.length === 0) {
            await createSampleTopics();
            loadForumTopics();
            return;
        }
        
        container.innerHTML = topics.data.map(topic => {
            const author = usersMap.get(topic.author_id) || { full_name: 'Unknown', country: '-' };
            const topicPosts = posts.data.filter(p => p.topic_id === topic.id);
            return `
                <div class="forum-topic-item" onclick="window.location.href='forum-topic.html?id=${topic.id}'">
                    <div class="topic-icon"><i class="fas fa-comments"></i></div>
                    <div class="topic-content">
                        <h3>${topic.title}</h3>
                        <p>${topic.description.substring(0, 150)}...</p>
                        <div class="topic-meta">
                            <span class="badge badge-${topic.category.toLowerCase()}">${topic.category}</span>
                            <span><i class="fas fa-user"></i> ${author.full_name}</span>
                            <span><i class="fas fa-map-marker-alt"></i> ${author.country}</span>
                            <span><i class="fas fa-clock"></i> ${timeAgo(topic.created_at)}</span>
                        </div>
                    </div>
                    <div class="topic-stats">
                        <div><i class="fas fa-eye"></i> ${topic.views || 0}</div>
                        <div><i class="fas fa-comment"></i> ${topicPosts.length}</div>
                    </div>
                </div>
            `;
        }).join('');
    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Ralat memuatkan topik</p></div>';
    }
}

function showNewTopicModal() {
    document.getElementById('newTopicModal').classList.add('active');
}

function closeNewTopicModal() {
    document.getElementById('newTopicModal').classList.remove('active');
}

async function createTopic(e) {
    e.preventDefault();
    const user = getCurrentUser();
    
    const topic = {
        id: generateUUID(),
        title: sanitizeInput(document.getElementById('topicTitle').value),
        category: document.getElementById('topicCategory').value,
        description: sanitizeInput(document.getElementById('topicDescription').value),
        author_id: user.id,
        views: 0,
        replies_count: 0
    };
    
    try {
        await fetch('tables/forum_topics', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(topic)
        });
        
        showAlert('Topik berjaya disiark an!', 'success');
        closeNewTopicModal();
        document.getElementById('newTopicForm').reset();
        loadForumTopics();
    } catch (error) {
        showAlert('Ralat menyiarkan topik', 'danger');
    }
}

function searchForumTopics() {
    const search = document.getElementById('searchTopics').value.toLowerCase();
    document.querySelectorAll('.forum-topic-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(search) ? 'flex' : 'none';
    });
}

function filterTopics() {
    const category = document.getElementById('categoryFilter').value;
    document.querySelectorAll('.forum-topic-item').forEach(item => {
        if (!category || item.querySelector('.badge').textContent === category) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

async function createSampleTopics() {
    const user = getCurrentUser();
    const samples = [
        { title: 'Panduan Ibadah di Negara Barat', category: 'Dakwah', description: 'Mari berkongsi pengalaman dan tips untuk menjalankan ibadah dengan sempurna di negara-negara Barat.' },
        { title: 'Program Pendidikan Anak-anak', category: 'Pendidikan', description: 'Perbincangan mengenai pendidikan Islam untuk anak-anak di luar negara.' }
    ];
    
    for (const s of samples) {
        await fetch('tables/forum_topics', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: generateUUID(), ...s, author_id: user.id, views: 0, replies_count: 0 })
        });
    }
}