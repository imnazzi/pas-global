// Profile Functions
if (!checkAuth()) window.location.href = 'index.html';

let viewingUserId = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    const urlParams = new URLSearchParams(window.location.search);
    viewingUserId = urlParams.get('view');
    
    if (viewingUserId) {
        loadOtherProfile(viewingUserId);
    } else {
        loadMyProfile();
    }
});

async function loadMyProfile() {
    const user = getCurrentUser();
    document.getElementById('profileAvatar').textContent = user.full_name.charAt(0).toUpperCase();
    document.getElementById('profileName').textContent = user.full_name;
    document.getElementById('profileRole').textContent = user.role === 'admin' ? 'Pentadbir' : user.role === 'moderator' ? 'Moderator' : 'Ahli';
    
    document.getElementById('fullName').value = user.full_name;
    document.getElementById('email').value = user.email;
    document.getElementById('phone').value = user.phone;
    document.getElementById('country').value = user.country;
    document.getElementById('profession').value = user.profession || '';
    document.getElementById('branch').value = user.branch;
    document.getElementById('expertise').value = user.expertise || '';
    document.getElementById('bio').value = user.bio || '';
}

async function loadOtherProfile(userId) {
    try {
        const response = await fetch(`tables/users/${userId}`);
        const user = await response.json();
        
        document.getElementById('profileAvatar').textContent = user.full_name.charAt(0).toUpperCase();
        document.getElementById('profileName').textContent = user.full_name;
        document.getElementById('profileRole').textContent = user.role === 'admin' ? 'Pentadbir' : 'Ahli';
        
        document.getElementById('profileActions').innerHTML = `
            <button class="btn btn-primary" onclick="window.location.href='chat.html?user=${user.id}'"><i class="fas fa-comment"></i>Mesej</button>
        `;
        
        document.getElementById('fullName').value = user.full_name;
        document.getElementById('fullName').disabled = true;
        document.getElementById('email').value = user.email;
        document.getElementById('email').disabled = true;
        document.getElementById('phone').value = user.phone;
        document.getElementById('phone').disabled = true;
        document.getElementById('country').value = user.country;
        document.getElementById('country').disabled = true;
        document.getElementById('profession').value = user.profession || '';
        document.getElementById('profession').disabled = true;
        document.getElementById('branch').value = user.branch;
        document.getElementById('branch').disabled = true;
        document.getElementById('expertise').value = user.expertise || '';
        document.getElementById('expertise').disabled = true;
        document.getElementById('bio').value = user.bio || '';
        document.getElementById('bio').disabled = true;
        
        document.querySelector('button[type="submit"]').style.display = 'none';
    } catch (error) {
        console.error('Error:', error);
        showAlert('Ralat memuatkan profil', 'danger');
    }
}

async function updateProfile(e) {
    e.preventDefault();
    const user = getCurrentUser();
    
    const updates = {
        full_name: sanitizeInput(document.getElementById('fullName').value),
        email: sanitizeInput(document.getElementById('email').value),
        phone: sanitizeInput(document.getElementById('phone').value),
        country: sanitizeInput(document.getElementById('country').value),
        profession: sanitizeInput(document.getElementById('profession').value),
        branch: sanitizeInput(document.getElementById('branch').value),
        expertise: sanitizeInput(document.getElementById('expertise').value),
        bio: sanitizeInput(document.getElementById('bio').value)
    };
    
    try {
        const response = await fetch(`tables/users/${user.id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updates)
        });
        
        const updatedUser = await response.json();
        setCurrentUser(updatedUser, true);
        showAlert('Profil berjaya dikemaskini!', 'success');
        initializeUserDisplay();
    } catch (error) {
        console.error('Error:', error);
        showAlert('Ralat mengemaskini profil', 'danger');
    }
}