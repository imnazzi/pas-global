// Authentication Functions for PAS Global Connect

// Registration form steps
let currentStep = 1;

function nextStep(step) {
    // Validate current step before proceeding
    if (!validateStep(currentStep)) {
        return;
    }
    
    // Hide current step
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
    
    // Show next step
    currentStep = step;
    document.getElementById(`step${currentStep}`).classList.add('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(step) {
    // Hide current step
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
    
    // Show previous step
    currentStep = step;
    document.getElementById(`step${currentStep}`).classList.add('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('completed');
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateStep(step) {
    let isValid = true;
    const stepElement = document.getElementById(`step${step}`);
    const inputs = stepElement.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'var(--danger-color)';
            isValid = false;
        } else {
            input.style.borderColor = 'var(--border-color)';
        }
    });
    
    if (!isValid) {
        showAlert('Sila lengkapkan semua medan yang diperlukan', 'danger');
    }
    
    return isValid;
}

// Handle login form submission
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
    
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegister);
    }
    
    // Check if already logged in
    const user = getCurrentUser();
    if (user && (window.location.pathname.includes('index.html') || window.location.pathname === '/')) {
        window.location.href = 'dashboard.html';
    }
});

async function handleLogin(e) {
    e.preventDefault();
    
    const email = sanitizeInput(document.getElementById('loginEmail').value);
    const password = document.getElementById('loginPassword').value;
    const rememberMe = document.getElementById('rememberMe').checked;
    
    // Validate inputs
    if (!email || !password) {
        showAlert('Sila masukkan email dan kata laluan', 'danger');
        return;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="loading"></span> Sedang log masuk...';
    submitBtn.disabled = true;
    
    try {
        // Hash password
        const passwordHash = await hashPassword(password);
        
        // Get users from API
        const response = await fetch('tables/users?limit=1000');
        const data = await response.json();
        
        // Find user by email or phone
        const user = data.data.find(u => 
            (u.email === email || u.phone === email) && 
            u.password_hash === passwordHash
        );
        
        if (user) {
            // Update last login
            await fetch(`tables/users/${user.id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    last_login: new Date().toISOString()
                })
            });
            
            // Save user session
            setCurrentUser(user, rememberMe);
            
            // Redirect to dashboard
            showAlert('Berjaya log masuk! Mengalihkan...', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1000);
        } else {
            showAlert('Email atau kata laluan tidak sah', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    } catch (error) {
        console.error('Login error:', error);
        showAlert('Ralat semasa log masuk. Sila cuba lagi.', 'danger');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

async function handleRegister(e) {
    e.preventDefault();
    
    // Get form values
    const fullName = sanitizeInput(document.getElementById('fullName').value);
    const email = sanitizeInput(document.getElementById('email').value);
    const phone = sanitizeInput(document.getElementById('phone').value);
    const country = sanitizeInput(document.getElementById('country').value);
    const profession = sanitizeInput(document.getElementById('profession').value);
    const pasMemberId = sanitizeInput(document.getElementById('pasMemberId').value);
    const branch = sanitizeInput(document.getElementById('branch').value);
    const expertise = sanitizeInput(document.getElementById('expertise').value);
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const agreeTerms = document.getElementById('agreeTerms').checked;
    const agreeData = document.getElementById('agreeData').checked;
    
    // Validation
    if (!validateEmail(email)) {
        showAlert('Format email tidak sah', 'danger');
        return;
    }
    
    if (!validatePhone(phone)) {
        showAlert('Format nombor telefon tidak sah', 'danger');
        return;
    }
    
    if (password !== confirmPassword) {
        showAlert('Kata laluan tidak sepadan', 'danger');
        return;
    }
    
    if (validatePasswordStrength(password) === 'weak') {
        showAlert('Kata laluan terlalu lemah. Gunakan kombinasi huruf besar, kecil, nombor dan simbol.', 'danger');
        return;
    }
    
    if (!agreeTerms || !agreeData) {
        showAlert('Sila bersetuju dengan terma dan syarat', 'danger');
        return;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="loading"></span> Sedang mendaftar...';
    submitBtn.disabled = true;
    
    try {
        // Check if email already exists
        const checkResponse = await fetch('tables/users?limit=1000');
        const checkData = await checkResponse.json();
        
        const existingUser = checkData.data.find(u => u.email === email);
        if (existingUser) {
            showAlert('Email sudah didaftarkan', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            return;
        }
        
        // Hash password
        const passwordHash = await hashPassword(password);
        
        // Create new user
        const newUser = {
            id: generateUUID(),
            full_name: fullName,
            email: email,
            phone: phone,
            password_hash: passwordHash,
            pas_member_id: pasMemberId,
            branch: branch,
            country: country,
            profession: profession,
            expertise: expertise,
            role: 'member',
            verified: false,
            last_login: new Date().toISOString(),
            avatar_url: '',
            bio: ''
        };
        
        // Save to database
        const response = await fetch('tables/users', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newUser)
        });
        
        if (response.ok) {
            const userData = await response.json();
            
            // Auto login
            setCurrentUser(userData, true);
            
            showAlert('Pendaftaran berjaya! Mengalihkan ke dashboard...', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 2000);
        } else {
            showAlert('Ralat semasa mendaftar. Sila cuba lagi.', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    } catch (error) {
        console.error('Registration error:', error);
        showAlert('Ralat semasa mendaftar. Sila cuba lagi.', 'danger');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// Initialize demo users if database is empty
async function initializeDemoUsers() {
    try {
        const response = await fetch('tables/users?limit=10');
        const data = await response.json();
        
        if (data.data.length === 0) {
            // Hash passwords
            const masterAdminPassword = await hashPassword('MasterAdmin@2026');
            const admin1Password = await hashPassword('Admin1@2026');
            const admin2Password = await hashPassword('Admin2@2026');
            const admin3Password = await hashPassword('Admin3@2026');
            
            // Create Master Admin
            const masterAdmin = {
                id: generateUUID(),
                full_name: 'Tuan Haji Abdul Rahman bin Ibrahim',
                email: 'master@pasglobalconnect.com',
                phone: '+60123456789',
                password_hash: masterAdminPassword,
                pas_member_id: 'PGCMASTER001',
                branch: 'Pusat',
                country: 'Malaysia',
                profession: 'Master Administrator',
                expertise: 'System Management, Security, Full Access',
                role: 'master_admin',
                verified: true,
                last_login: new Date().toISOString(),
                avatar_url: '',
                bio: 'Master Administrator - Full System Access'
            };
            
            // Create Admin 1
            const admin1 = {
                id: generateUUID(),
                full_name: 'Tuan Haji Mohd Aziz bin Hassan',
                email: 'admin1@pasglobalconnect.com',
                phone: '+60123456790',
                password_hash: admin1Password,
                pas_member_id: 'PGCADM001',
                branch: 'Wilayah Utara',
                country: 'Malaysia',
                profession: 'Administrator',
                expertise: 'User Management, Content Moderation',
                role: 'admin',
                verified: true,
                last_login: new Date().toISOString(),
                avatar_url: '',
                bio: 'Administrator - Wilayah Utara'
            };
            
            // Create Admin 2
            const admin2 = {
                id: generateUUID(),
                full_name: 'Tuan Haji Ahmad Syukri bin Abdullah',
                email: 'admin2@pasglobalconnect.com',
                phone: '+60123456791',
                password_hash: admin2Password,
                pas_member_id: 'PGCADM002',
                branch: 'Wilayah Tengah',
                country: 'Malaysia',
                profession: 'Administrator',
                expertise: 'Forum Management, Event Coordination',
                role: 'admin',
                verified: true,
                last_login: new Date().toISOString(),
                avatar_url: '',
                bio: 'Administrator - Wilayah Tengah'
            };
            
            // Create Admin 3
            const admin3 = {
                id: generateUUID(),
                full_name: 'Tuan Haji Ismail bin Yusof',
                email: 'admin3@pasglobalconnect.com',
                phone: '+60123456792',
                password_hash: admin3Password,
                pas_member_id: 'PGCADM003',
                branch: 'Wilayah Selatan',
                country: 'Malaysia',
                profession: 'Administrator',
                expertise: 'Video Content, Community Engagement',
                role: 'admin',
                verified: true,
                last_login: new Date().toISOString(),
                avatar_url: '',
                bio: 'Administrator - Wilayah Selatan'
            };
            
            // Save all admin users
            await fetch('tables/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(masterAdmin)
            });
            
            await fetch('tables/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(admin1)
            });
            
            await fetch('tables/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(admin2)
            });
            
            await fetch('tables/users', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(admin3)
            });
            
            console.log('Admin users created successfully:');
            console.log('Master Admin: master@pasglobalconnect.com / MasterAdmin@2026');
            console.log('Admin 1: admin1@pasglobalconnect.com / Admin1@2026');
            console.log('Admin 2: admin2@pasglobalconnect.com / Admin2@2026');
            console.log('Admin 3: admin3@pasglobalconnect.com / Admin3@2026');
        }
    } catch (error) {
        console.error('Error initializing demo users:', error);
    }
}

// Initialize demo users on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeDemoUsers);
} else {
    initializeDemoUsers();
}