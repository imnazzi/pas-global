// Calendar Functions
if (!checkAuth()) window.location.href = 'index.html';

let currentDate = new Date();

document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    renderCalendar();
    loadEvents();
});

function renderCalendar() {
    const month = currentDate.getMonth();
    const year = currentDate.getFullYear();
    document.getElementById('currentMonth').textContent = new Date(year, month).toLocaleDateString('ms-MY', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    let html = '<div class="calendar-days">';
    ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'].forEach(day => {
        html += `<div class="calendar-day-header">${day}</div>`;
    });
    html += '</div><div class="calendar-dates">';
    
    for (let i = 0; i < firstDay; i++) html += '<div class="calendar-date empty"></div>';
    
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        html += `<div class="calendar-date ${isToday ? 'today' : ''}">${day}</div>`;
    }
    
    html += '</div>';
    document.getElementById('calendarGrid').innerHTML = html;
}

function changeMonth(delta) {
    currentDate.setMonth(currentDate.getMonth() + delta);
    renderCalendar();
}

async function loadEvents() {
    const container = document.getElementById('eventsList');
    container.innerHTML = '<div class="loading-container"><div class="loading"></div></div>';
    
    try {
        const [eventsRes, usersRes] = await Promise.all([
            fetch('tables/events?limit=1000'),
            fetch('tables/users?limit=1000')
        ]);
        
        const events = await eventsRes.json();
        const users = await usersRes.json();
        const usersMap = new Map(users.data.map(u => [u.id, u]));
        
        const upcoming = events.data.filter(e => new Date(e.date) >= new Date()).sort((a, b) => new Date(a.date) - new Date(b.date));
        
        if (upcoming.length === 0) {
            container.innerHTML = '<div class="empty-state"><i class="fas fa-calendar-times"></i><p>Tiada acara akan datang</p></div>';
            return;
        }
        
        container.innerHTML = upcoming.map(event => {
            const organizer = usersMap.get(event.organizer_id) || { full_name: 'Unknown' };
            return `
                <div class="event-item">
                    <div class="event-date">
                        <div class="event-day">${new Date(event.date).getDate()}</div>
                        <div class="event-month">${new Date(event.date).toLocaleDateString('ms-MY', { month: 'short' })}</div>
                    </div>
                    <div class="event-details">
                        <h4>${event.title}</h4>
                        <p><i class="fas fa-map-marker-alt"></i> ${event.location}, ${event.country}</p>
                        <p><i class="fas fa-clock"></i> ${event.time}</p>
                        <small><i class="fas fa-user"></i> ${organizer.full_name}</small>
                    </div>
                    <div class="event-category"><span class="badge badge-${event.category.toLowerCase()}">${event.category}</span></div>
                </div>
            `;
        }).join('');
    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Ralat memuatkan acara</p></div>';
    }
}

function showNewEventModal() {
    document.getElementById('newEventModal').classList.add('active');
}

function closeNewEventModal() {
    document.getElementById('newEventModal').classList.remove('active');
}

async function createEvent(e) {
    e.preventDefault();
    const user = getCurrentUser();
    
    const event = {
        id: generateUUID(),
        title: sanitizeInput(document.getElementById('eventTitle').value),
        description: sanitizeInput(document.getElementById('eventDescription').value),
        category: document.getElementById('eventCategory').value,
        date: new Date(document.getElementById('eventDate').value).toISOString(),
        time: document.getElementById('eventTime').value,
        location: sanitizeInput(document.getElementById('eventLocation').value),
        country: sanitizeInput(document.getElementById('eventCountry').value),
        organizer_id: user.id,
        participants: []
    };
    
    try {
        await fetch('tables/events', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(event)
        });
        
        showAlert('Acara berjaya ditambah!', 'success');
        closeNewEventModal();
        document.getElementById('newEventForm').reset();
        loadEvents();
    } catch (error) {
        showAlert('Ralat menambah acara', 'danger');
    }
}