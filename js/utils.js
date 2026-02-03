// Utility Functions for PAS Global Connect

// Generate UUID
function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        const r = Math.random() * 16 | 0;
        const v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

// Hash password using SHA-256
async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

// Sanitize input to prevent XSS
function sanitizeInput(input) {
    const div = document.createElement('div');
    div.textContent = input;
    return div.innerHTML;
}

// Validate email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Validate phone number
function validatePhone(phone) {
    const re = /^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{1,9}$/;
    return re.test(phone);
}

// Validate password strength
function validatePasswordStrength(password) {
    const minLength = password.length >= 8;
    const hasUpper = /[A-Z]/.test(password);
    const hasLower = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
    const score = [minLength, hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;
    
    if (score <= 2) return 'weak';
    if (score <= 3) return 'medium';
    return 'strong';
}

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.parentElement.querySelector('.toggle-password');
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Check password strength (for registration)
function checkPasswordStrength(password) {
    const strengthElement = document.getElementById('passwordStrength');
    if (!strengthElement) return;
    
    const bar = strengthElement.querySelector('.strength-bar');
    const text = strengthElement.querySelector('.strength-text');
    
    const strength = validatePasswordStrength(password);
    
    bar.className = 'strength-bar ' + strength;
    
    switch(strength) {
        case 'weak':
            text.textContent = 'Lemah - Gunakan kombinasi huruf, nombor dan simbol';
            text.style.color = 'var(--danger-color)';
            break;
        case 'medium':
            text.textContent = 'Sederhana - Tambah lebih banyak aksara untuk keselamatan';
            text.style.color = 'var(--warning-color)';
            break;
        case 'strong':
            text.textContent = 'Kuat - Kata laluan anda selamat!';
            text.style.color = 'var(--accent-color)';
            break;
    }
}

// Format date
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('ms-MY', options);
}

// Format datetime
function formatDateTime(date) {
    const options = { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(date).toLocaleDateString('ms-MY', options);
}

// Time ago function
function timeAgo(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    
    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + ' tahun yang lalu';
    
    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + ' bulan yang lalu';
    
    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + ' hari yang lalu';
    
    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + ' jam yang lalu';
    
    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + ' minit yang lalu';
    
    return 'Baru sahaja';
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'}"></i>
        <span>${message}</span>
    `;
    
    const container = document.querySelector('.login-form-container, .register-content, .main-content');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.style.opacity = '0';
            setTimeout(() => alertDiv.remove(), 300);
        }, 5000);
    }
}

// Get current user from session
function getCurrentUser() {
    const userJson = sessionStorage.getItem('currentUser') || localStorage.getItem('currentUser');
    return userJson ? JSON.parse(userJson) : null;
}

// Set current user in session
function setCurrentUser(user, remember = false) {
    const userJson = JSON.stringify(user);
    sessionStorage.setItem('currentUser', userJson);
    if (remember) {
        localStorage.setItem('currentUser', userJson);
    }
}

// Logout user
function logout() {
    sessionStorage.removeItem('currentUser');
    localStorage.removeItem('currentUser');
    window.location.href = 'index.html';
}

// Check if user is logged in
function checkAuth() {
    const user = getCurrentUser();
    if (!user) {
        window.location.href = 'index.html';
        return false;
    }
    return true;
}

// Initialize user in header/sidebar
function initializeUserDisplay() {
    const user = getCurrentUser();
    if (!user) return;
    
    const userNameElements = document.querySelectorAll('.user-name');
    const userRoleElements = document.querySelectorAll('.user-role');
    const userAvatarElements = document.querySelectorAll('.user-avatar');
    
    userNameElements.forEach(el => el.textContent = user.full_name);
    userRoleElements.forEach(el => el.textContent = user.role || 'Ahli');
    userAvatarElements.forEach(el => {
        el.textContent = user.full_name.charAt(0).toUpperCase();
    });
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Export functions for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        generateUUID,
        hashPassword,
        sanitizeInput,
        validateEmail,
        validatePhone,
        validatePasswordStrength,
        formatDate,
        formatDateTime,
        timeAgo,
        showAlert,
        getCurrentUser,
        setCurrentUser,
        logout,
        checkAuth,
        initializeUserDisplay,
        debounce
    };
}