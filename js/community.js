// Community Functions
if (!checkAuth()) window.location.href = 'index.html';

document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    loadMembers();
});

async function loadMembers() {
    const container = document.getElementById('membersList');
    const filterSelect = document.getElementById('countryFilter');
    container.innerHTML = '<div class="loading-container"><div class="loading"></div></div>';
    
    try {
        const response = await fetch('tables/users?limit=1000');
        const data = await response.json();
        const currentUser = getCurrentUser();
        const members = data.data.filter(u => u.id !== currentUser.id);
        
        // Populate country filter
        const countries = [...new Set(members.map(m => m.country))];
        filterSelect.innerHTML = '<option value="">Semua Negara</option>' + 
            countries.map(c => `<option value="${c}">${c}</option>`).join('');
        
        container.innerHTML = members.map(member => `
            <div class="member-card">
                <div class="member-avatar">${member.full_name.charAt(0).toUpperCase()}</div>
                <h3>${member.full_name}</h3>
                <p class="member-profession">${member.profession || 'Tidak dinyatakan'}</p>
                <p class="member-location"><i class="fas fa-map-marker-alt"></i> ${member.country}</p>
                <p class="member-branch"><i class="fas fa-home"></i> ${member.branch}</p>
                <div class="member-actions">
                    <button class="btn btn-primary btn-sm" onclick="window.location.href='chat.html?user=${member.id}'"><i class="fas fa-comment"></i> Mesej</button>
                    <button class="btn btn-secondary btn-sm" onclick="window.location.href='profile.html?view=${member.id}'"><i class="fas fa-eye"></i> Profil</button>
                </div>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error:', error);
        container.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Ralat memuatkan ahli</p></div>';
    }
}

function searchCommunity() {
    const search = document.getElementById('searchMembers').value.toLowerCase();
    document.querySelectorAll('.member-card').forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(search) ? 'block' : 'none';
    });
}

function filterMembers() {
    const country = document.getElementById('countryFilter').value;
    document.querySelectorAll('.member-card').forEach(card => {
        const cardCountry = card.querySelector('.member-location').textContent;
        if (!country || cardCountry.includes(country)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}