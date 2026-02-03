// Dashboard Functions for PAS Global Connect

// Check authentication on page load
if (!checkAuth()) {
    window.location.href = 'index.html';
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    loadStatistics();
    loadNewsFeed();
    loadRecentActivities();
    loadUpcomingEvents();
});

// Load statistics
async function loadStatistics() {
    try {
        // Get total members
        const usersResponse = await fetch('tables/users?limit=1000');
        const usersData = await usersResponse.json();
        document.getElementById('totalMembers').textContent = usersData.total || usersData.data.length;
        
        // Get unique countries
        const countries = [...new Set(usersData.data.map(u => u.country))];
        document.getElementById('totalCountries').textContent = countries.length;
        
        // Get total events this month
        const eventsResponse = await fetch('tables/events?limit=1000');
        const eventsData = await eventsResponse.json();
        const thisMonth = new Date().getMonth();
        const thisYear = new Date().getFullYear();
        const monthlyEvents = eventsData.data.filter(e => {
            const eventDate = new Date(e.date);
            return eventDate.getMonth() === thisMonth && eventDate.getFullYear() === thisYear;
        });
        document.getElementById('totalEvents').textContent = monthlyEvents.length;
        
        // Get total forum topics
        const forumResponse = await fetch('tables/forum_topics?limit=1000');
        const forumData = await forumResponse.json();
        document.getElementById('totalDiscussions').textContent = forumData.total || forumData.data.length;
    } catch (error) {
        console.error('Error loading statistics:', error);
    }
}

// Load news feed
async function loadNewsFeed() {
    const newsFeedContainer = document.getElementById('newsFeed');
    
    try {
        const response = await fetch('tables/news_feed?limit=10&sort=-created_at');
        const data = await response.json();
        
        if (data.data.length === 0) {
            // Create sample news if empty
            await createSampleNews();
            loadNewsFeed();
            return;
        }
        
        // Get users for author names
        const usersResponse = await fetch('tables/users?limit=1000');
        const usersData = await usersResponse.json();
        const usersMap = new Map(usersData.data.map(u => [u.id, u]));
        
        newsFeedContainer.innerHTML = data.data.map(news => {
            const author = usersMap.get(news.author_id) || { full_name: 'Unknown' };
            return `
                <div class="news-item">
                    <div class="news-header">
                        <div class="news-author">
                            <div class="author-avatar">${author.full_name.charAt(0)}</div>
                            <div class="author-info">
                                <div class="author-name">${author.full_name}</div>
                                <div class="news-date">${timeAgo(news.created_at)}</div>
                            </div>
                        </div>
                        <span class="news-category category-${news.category.toLowerCase()}">${news.category}</span>
                    </div>
                    <div class="news-content">
                        <h3>${news.title}</h3>
                        <p>${news.content.substring(0, 200)}${news.content.length > 200 ? '...' : ''}</p>
                    </div>
                    <div class="news-footer">
                        <button class="btn-icon" onclick="likeNews('${news.id}')">
                            <i class="fas fa-heart"></i>
                            <span>${news.likes || 0}</span>
                        </button>
                        <button class="btn-icon">
                            <i class="fas fa-comment"></i>
                            <span>${news.comments_count || 0}</span>
                        </button>
                        <button class="btn-icon">
                            <i class="fas fa-share"></i>
                            <span>Kongsi</span>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
        
    } catch (error) {
        console.error('Error loading news feed:', error);
        newsFeedContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <p>Tiada berita pada masa ini</p>
            </div>
        `;
    }
}

// Load recent activities
async function loadRecentActivities() {
    const activitiesContainer = document.getElementById('recentActivities');
    
    try {
        // Get recent forum posts
        const postsResponse = await fetch('tables/forum_posts?limit=5&sort=-created_at');
        const postsData = await postsResponse.json();
        
        // Get users
        const usersResponse = await fetch('tables/users?limit=1000');
        const usersData = await usersResponse.json();
        const usersMap = new Map(usersData.data.map(u => [u.id, u]));
        
        // Get topics
        const topicsResponse = await fetch('tables/forum_topics?limit=1000');
        const topicsData = await topicsResponse.json();
        const topicsMap = new Map(topicsData.data.map(t => [t.id, t]));
        
        if (postsData.data.length === 0) {
            activitiesContainer.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-clock"></i>
                    <p>Tiada aktiviti terkini</p>
                </div>
            `;
            return;
        }
        
        activitiesContainer.innerHTML = postsData.data.map(post => {
            const author = usersMap.get(post.author_id) || { full_name: 'Unknown', country: '-' };
            const topic = topicsMap.get(post.topic_id) || { title: 'Unknown Topic' };
            return `
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>${author.full_name}</strong> menambah komen di topik <strong>${topic.title}</strong></p>
                        <small>${timeAgo(post.created_at)} • ${author.country}</small>
                    </div>
                </div>
            `;
        }).join('');
        
    } catch (error) {
        console.error('Error loading activities:', error);
        activitiesContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-clock"></i>
                <p>Tiada aktiviti terkini</p>
            </div>
        `;
    }
}

// Load upcoming events
async function loadUpcomingEvents() {
    const eventsContainer = document.getElementById('upcomingEvents');
    
    try {
        const response = await fetch('tables/events?limit=1000');
        const data = await response.json();
        
        // Filter future events
        const now = new Date();
        const upcomingEvents = data.data
            .filter(e => new Date(e.date) >= now)
            .sort((a, b) => new Date(a.date) - new Date(b.date))
            .slice(0, 5);
        
        if (upcomingEvents.length === 0) {
            // Create sample events if empty
            await createSampleEvents();
            loadUpcomingEvents();
            return;
        }
        
        // Get users
        const usersResponse = await fetch('tables/users?limit=1000');
        const usersData = await usersResponse.json();
        const usersMap = new Map(usersData.data.map(u => [u.id, u]));
        
        eventsContainer.innerHTML = upcomingEvents.map(event => {
            const organizer = usersMap.get(event.organizer_id) || { full_name: 'Unknown' };
            const eventDate = new Date(event.date);
            return `
                <div class="event-item">
                    <div class="event-date">
                        <div class="event-day">${eventDate.getDate()}</div>
                        <div class="event-month">${eventDate.toLocaleDateString('ms-MY', { month: 'short' })}</div>
                    </div>
                    <div class="event-details">
                        <h4>${event.title}</h4>
                        <p><i class="fas fa-map-marker-alt"></i> ${event.location}, ${event.country}</p>
                        <p><i class="fas fa-clock"></i> ${event.time}</p>
                        <small><i class="fas fa-user"></i> Anjuran: ${organizer.full_name}</small>
                    </div>
                    <div class="event-category">
                        <span class="badge badge-${event.category.toLowerCase()}">${event.category}</span>
                    </div>
                </div>
            `;
        }).join('');
        
    } catch (error) {
        console.error('Error loading events:', error);
        eventsContainer.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>Tiada acara akan datang</p>
            </div>
        `;
    }
}

// Like news
async function likeNews(newsId) {
    try {
        const response = await fetch(`tables/news_feed/${newsId}`);
        const news = await response.json();
        
        await fetch(`tables/news_feed/${newsId}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                likes: (news.likes || 0) + 1
            })
        });
        
        loadNewsFeed();
    } catch (error) {
        console.error('Error liking news:', error);
    }
}

// Create sample news
async function createSampleNews() {
    const user = getCurrentUser();
    
    const sampleNews = [
        {
            id: generateUUID(),
            title: 'Selamat Datang ke PAS Global Connect',
            content: 'Alhamdulillah, platform PAS Global Connect kini telah dilancarkan untuk menghubungkan semua ahli PAS di seluruh dunia. Mari kita gunakan platform ini untuk memperkukuh silaturahim dan dakwah kita.',
            category: 'Pengumuman',
            author_id: user.id,
            image_url: '',
            likes: 25,
            comments_count: 8
        },
        {
            id: generateUUID(),
            title: 'Mesyuarat Agung Tahunan 2024',
            content: 'Mesyuarat Agung Tahunan PAS Luar Negara akan diadakan pada bulan depan. Semua ahli dijemput hadir secara virtual melalui platform ini.',
            category: 'Penting',
            author_id: user.id,
            image_url: '',
            likes: 15,
            comments_count: 5
        }
    ];
    
    for (const news of sampleNews) {
        await fetch('tables/news_feed', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(news)
        });
    }
}

// Create sample events
async function createSampleEvents() {
    const user = getCurrentUser();
    const now = new Date();
    
    const sampleEvents = [
        {
            id: generateUUID(),
            title: 'Ceramah Bulanan - Keluarga Bahagia',
            description: 'Ceramah mengenai pembinaan keluarga bahagia menurut Islam',
            category: 'Ceramah',
            date: new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000).toISOString(),
            time: '20:00 - 22:00',
            location: 'Masjid Al-Falah',
            country: user.country,
            organizer_id: user.id,
            participants: []
        },
        {
            id: generateUUID(),
            title: 'Mesyuarat Cawangan Bulanan',
            description: 'Mesyuarat rutin ahli PAS cawangan',
            category: 'Mesyuarat',
            date: new Date(now.getTime() + 14 * 24 * 60 * 60 * 1000).toISOString(),
            time: '19:00 - 21:00',
            location: 'Dewan Cawangan',
            country: user.country,
            organizer_id: user.id,
            participants: []
        }
    ];
    
    for (const event of sampleEvents) {
        await fetch('tables/events', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(event)
        });
    }
}