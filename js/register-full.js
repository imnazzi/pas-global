// Full Registration JavaScript

// All countries in the world with flags
const worldCountries = [
    { name: "Afghanistan", flag: "🇦🇫" },
    { name: "Albania", flag: "🇦🇱" },
    { name: "Algeria", flag: "🇩🇿" },
    { name: "Andorra", flag: "🇦🇩" },
    { name: "Angola", flag: "🇦🇴" },
    { name: "Argentina", flag: "🇦🇷" },
    { name: "Armenia", flag: "🇦🇲" },
    { name: "Australia", flag: "🇦🇺" },
    { name: "Austria", flag: "🇦🇹" },
    { name: "Azerbaijan", flag: "🇦🇿" },
    { name: "Bahamas", flag: "🇧🇸" },
    { name: "Bahrain", flag: "🇧🇭" },
    { name: "Bangladesh", flag: "🇧🇩" },
    { name: "Barbados", flag: "🇧🇧" },
    { name: "Belarus", flag: "🇧🇾" },
    { name: "Belgium", flag: "🇧🇪" },
    { name: "Belize", flag: "🇧🇿" },
    { name: "Benin", flag: "🇧🇯" },
    { name: "Bhutan", flag: "🇧🇹" },
    { name: "Bolivia", flag: "🇧🇴" },
    { name: "Bosnia and Herzegovina", flag: "🇧🇦" },
    { name: "Botswana", flag: "🇧🇼" },
    { name: "Brazil", flag: "🇧🇷" },
    { name: "Brunei", flag: "🇧🇳" },
    { name: "Bulgaria", flag: "🇧🇬" },
    { name: "Burkina Faso", flag: "🇧🇫" },
    { name: "Burundi", flag: "🇧🇮" },
    { name: "Cambodia", flag: "🇰🇭" },
    { name: "Cameroon", flag: "🇨🇲" },
    { name: "Canada", flag: "🇨🇦" },
    { name: "Cape Verde", flag: "🇨🇻" },
    { name: "Central African Republic", flag: "🇨🇫" },
    { name: "Chad", flag: "🇹🇩" },
    { name: "Chile", flag: "🇨🇱" },
    { name: "China", flag: "🇨🇳" },
    { name: "Colombia", flag: "🇨🇴" },
    { name: "Comoros", flag: "🇰🇲" },
    { name: "Congo", flag: "🇨🇬" },
    { name: "Costa Rica", flag: "🇨🇷" },
    { name: "Croatia", flag: "🇭🇷" },
    { name: "Cuba", flag: "🇨🇺" },
    { name: "Cyprus", flag: "🇨🇾" },
    { name: "Czech Republic", flag: "🇨🇿" },
    { name: "Denmark", flag: "🇩🇰" },
    { name: "Djibouti", flag: "🇩🇯" },
    { name: "Dominica", flag: "🇩🇲" },
    { name: "Dominican Republic", flag: "🇩🇴" },
    { name: "East Timor", flag: "🇹🇱" },
    { name: "Ecuador", flag: "🇪🇨" },
    { name: "Egypt", flag: "🇪🇬" },
    { name: "El Salvador", flag: "🇸🇻" },
    { name: "Equatorial Guinea", flag: "🇬🇶" },
    { name: "Eritrea", flag: "🇪🇷" },
    { name: "Estonia", flag: "🇪🇪" },
    { name: "Ethiopia", flag: "🇪🇹" },
    { name: "Fiji", flag: "🇫🇯" },
    { name: "Finland", flag: "🇫🇮" },
    { name: "France", flag: "🇫🇷" },
    { name: "Gabon", flag: "🇬🇦" },
    { name: "Gambia", flag: "🇬🇲" },
    { name: "Georgia", flag: "🇬🇪" },
    { name: "Germany", flag: "🇩🇪" },
    { name: "Ghana", flag: "🇬🇭" },
    { name: "Greece", flag: "🇬🇷" },
    { name: "Grenada", flag: "🇬🇩" },
    { name: "Guatemala", flag: "🇬🇹" },
    { name: "Guinea", flag: "🇬🇳" },
    { name: "Guinea-Bissau", flag: "🇬🇼" },
    { name: "Guyana", flag: "🇬🇾" },
    { name: "Haiti", flag: "🇭🇹" },
    { name: "Honduras", flag: "🇭🇳" },
    { name: "Hungary", flag: "🇭🇺" },
    { name: "Iceland", flag: "🇮🇸" },
    { name: "India", flag: "🇮🇳" },
    { name: "Indonesia", flag: "🇮🇩" },
    { name: "Iran", flag: "🇮🇷" },
    { name: "Iraq", flag: "🇮🇶" },
    { name: "Ireland", flag: "🇮🇪" },
    { name: "Israel", flag: "🇮🇱" },
    { name: "Italy", flag: "🇮🇹" },
    { name: "Ivory Coast", flag: "🇨🇮" },
    { name: "Jamaica", flag: "🇯🇲" },
    { name: "Japan", flag: "🇯🇵" },
    { name: "Jordan", flag: "🇯🇴" },
    { name: "Kazakhstan", flag: "🇰🇿" },
    { name: "Kenya", flag: "🇰🇪" },
    { name: "Kiribati", flag: "🇰🇮" },
    { name: "Kosovo", flag: "🇽🇰" },
    { name: "Kuwait", flag: "🇰🇼" },
    { name: "Kyrgyzstan", flag: "🇰🇬" },
    { name: "Laos", flag: "🇱🇦" },
    { name: "Latvia", flag: "🇱🇻" },
    { name: "Lebanon", flag: "🇱🇧" },
    { name: "Lesotho", flag: "🇱🇸" },
    { name: "Liberia", flag: "🇱🇷" },
    { name: "Libya", flag: "🇱🇾" },
    { name: "Liechtenstein", flag: "🇱🇮" },
    { name: "Lithuania", flag: "🇱🇹" },
    { name: "Luxembourg", flag: "🇱🇺" },
    { name: "Macedonia", flag: "🇲🇰" },
    { name: "Madagascar", flag: "🇲🇬" },
    { name: "Malawi", flag: "🇲🇼" },
    { name: "Malaysia", flag: "🇲🇾" },
    { name: "Maldives", flag: "🇲🇻" },
    { name: "Mali", flag: "🇲🇱" },
    { name: "Malta", flag: "🇲🇹" },
    { name: "Marshall Islands", flag: "🇲🇭" },
    { name: "Mauritania", flag: "🇲🇷" },
    { name: "Mauritius", flag: "🇲🇺" },
    { name: "Mexico", flag: "🇲🇽" },
    { name: "Micronesia", flag: "🇫🇲" },
    { name: "Moldova", flag: "🇲🇩" },
    { name: "Monaco", flag: "🇲🇨" },
    { name: "Mongolia", flag: "🇲🇳" },
    { name: "Montenegro", flag: "🇲🇪" },
    { name: "Morocco", flag: "🇲🇦" },
    { name: "Mozambique", flag: "🇲🇿" },
    { name: "Myanmar", flag: "🇲🇲" },
    { name: "Namibia", flag: "🇳🇦" },
    { name: "Nauru", flag: "🇳🇷" },
    { name: "Nepal", flag: "🇳🇵" },
    { name: "Netherlands", flag: "🇳🇱" },
    { name: "New Zealand", flag: "🇳🇿" },
    { name: "Nicaragua", flag: "🇳🇮" },
    { name: "Niger", flag: "🇳🇪" },
    { name: "Nigeria", flag: "🇳🇬" },
    { name: "North Korea", flag: "🇰🇵" },
    { name: "Norway", flag: "🇳🇴" },
    { name: "Oman", flag: "🇴🇲" },
    { name: "Pakistan", flag: "🇵🇰" },
    { name: "Palau", flag: "🇵🇼" },
    { name: "Palestine", flag: "🇵🇸" },
    { name: "Panama", flag: "🇵🇦" },
    { name: "Papua New Guinea", flag: "🇵🇬" },
    { name: "Paraguay", flag: "🇵🇾" },
    { name: "Peru", flag: "🇵🇪" },
    { name: "Philippines", flag: "🇵🇭" },
    { name: "Poland", flag: "🇵🇱" },
    { name: "Portugal", flag: "🇵🇹" },
    { name: "Qatar", flag: "🇶🇦" },
    { name: "Romania", flag: "🇷🇴" },
    { name: "Russia", flag: "🇷🇺" },
    { name: "Rwanda", flag: "🇷🇼" },
    { name: "Saint Kitts and Nevis", flag: "🇰🇳" },
    { name: "Saint Lucia", flag: "🇱🇨" },
    { name: "Saint Vincent and the Grenadines", flag: "🇻🇨" },
    { name: "Samoa", flag: "🇼🇸" },
    { name: "San Marino", flag: "🇸🇲" },
    { name: "Sao Tome and Principe", flag: "🇸🇹" },
    { name: "Saudi Arabia", flag: "🇸🇦" },
    { name: "Senegal", flag: "🇸🇳" },
    { name: "Serbia", flag: "🇷🇸" },
    { name: "Seychelles", flag: "🇸🇨" },
    { name: "Sierra Leone", flag: "🇸🇱" },
    { name: "Singapore", flag: "🇸🇬" },
    { name: "Slovakia", flag: "🇸🇰" },
    { name: "Slovenia", flag: "🇸🇮" },
    { name: "Solomon Islands", flag: "🇸🇧" },
    { name: "Somalia", flag: "🇸🇴" },
    { name: "South Africa", flag: "🇿🇦" },
    { name: "South Korea", flag: "🇰🇷" },
    { name: "South Sudan", flag: "🇸🇸" },
    { name: "Spain", flag: "🇪🇸" },
    { name: "Sri Lanka", flag: "🇱🇰" },
    { name: "Sudan", flag: "🇸🇩" },
    { name: "Suriname", flag: "🇸🇷" },
    { name: "Swaziland", flag: "🇸🇿" },
    { name: "Sweden", flag: "🇸🇪" },
    { name: "Switzerland", flag: "🇨🇭" },
    { name: "Syria", flag: "🇸🇾" },
    { name: "Taiwan", flag: "🇹🇼" },
    { name: "Tajikistan", flag: "🇹🇯" },
    { name: "Tanzania", flag: "🇹🇿" },
    { name: "Thailand", flag: "🇹🇭" },
    { name: "Togo", flag: "🇹🇬" },
    { name: "Tonga", flag: "🇹🇴" },
    { name: "Trinidad and Tobago", flag: "🇹🇹" },
    { name: "Tunisia", flag: "🇹🇳" },
    { name: "Turkey", flag: "🇹🇷" },
    { name: "Turkmenistan", flag: "🇹🇲" },
    { name: "Tuvalu", flag: "🇹🇻" },
    { name: "Uganda", flag: "🇺🇬" },
    { name: "Ukraine", flag: "🇺🇦" },
    { name: "United Arab Emirates", flag: "🇦🇪" },
    { name: "United Kingdom", flag: "🇬🇧" },
    { name: "United States", flag: "🇺🇸" },
    { name: "Uruguay", flag: "🇺🇾" },
    { name: "Uzbekistan", flag: "🇺🇿" },
    { name: "Vanuatu", flag: "🇻🇺" },
    { name: "Vatican City", flag: "🇻🇦" },
    { name: "Venezuela", flag: "🇻🇪" },
    { name: "Vietnam", flag: "🇻🇳" },
    { name: "Yemen", flag: "🇾🇪" },
    { name: "Zambia", flag: "🇿🇲" },
    { name: "Zimbabwe", flag: "🇿🇼" }
];

let currentSection = 1;
let formData = {};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeCountryDropdown();
    
    const form = document.getElementById('registerFullForm');
    if (form) {
        form.addEventListener('submit', handleSubmit);
    }
});

// Initialize country dropdown
function initializeCountryDropdown() {
    const dropdown = document.getElementById('countryDropdown');
    dropdown.innerHTML = worldCountries.map(country => `
        <div class="country-option" onclick="selectCountry('${country.name}', '${country.flag}')">
            <span class="country-flag">${country.flag}</span>
            <span>${country.name}</span>
        </div>
    `).join('');
}

// Show country dropdown
function showCountryDropdown() {
    document.getElementById('countryDropdown').classList.add('show');
}

// Hide country dropdown
function hideCountryDropdown() {
    setTimeout(() => {
        document.getElementById('countryDropdown').classList.remove('show');
    }, 200);
}

// Filter countries
function filterCountries() {
    const searchInput = document.getElementById('countrySearch');
    const filter = searchInput.value.toLowerCase();
    const dropdown = document.getElementById('countryDropdown');
    
    const filtered = worldCountries.filter(country => 
        country.name.toLowerCase().includes(filter)
    );
    
    dropdown.innerHTML = filtered.map(country => `
        <div class="country-option" onclick="selectCountry('${country.name}', '${country.flag}')">
            <span class="country-flag">${country.flag}</span>
            <span>${country.name}</span>
        </div>
    `).join('');
    
    dropdown.classList.add('show');
}

// Select country
function selectCountry(name, flag) {
    document.getElementById('countrySearch').value = `${flag} ${name}`;
    document.getElementById('selectedCountry').value = name;
    hideCountryDropdown();
}

// Click outside to hide dropdown
document.addEventListener('click', function(event) {
    const countrySearch = document.getElementById('countrySearch');
    const dropdown = document.getElementById('countryDropdown');
    
    if (countrySearch && dropdown) {
        if (!countrySearch.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    }
});

// Preview photo
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Profile Photo">`;
            formData.photoUrl = e.target.result;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Next section
function nextSection(section) {
    // Validate current section
    if (!validateSection(currentSection)) {
        return;
    }
    
    // Save current section data
    saveCurrentSectionData();
    
    // Hide current section
    document.getElementById(`section${currentSection}`).classList.remove('active');
    document.querySelector(`.progress-step[data-step="${currentSection}"]`).classList.remove('active');
    document.querySelector(`.progress-step[data-step="${currentSection}"]`).classList.add('completed');
    
    // Show next section
    currentSection = section;
    document.getElementById(`section${currentSection}`).classList.add('active');
    document.querySelector(`.progress-step[data-step="${currentSection}"]`).classList.add('active');
    
    // If final section, show review
    if (section === 5) {
        showReview();
    }
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Previous section
function prevSection(section) {
    // Hide current section
    document.getElementById(`section${currentSection}`).classList.remove('active');
    document.querySelector(`.progress-step[data-step="${currentSection}"]`).classList.remove('active');
    
    // Show previous section
    currentSection = section;
    document.getElementById(`section${currentSection}`).classList.add('active');
    document.querySelector(`.progress-step[data-step="${currentSection}"]`).classList.add('active');
    document.querySelector(`.progress-step[data-step="${section}"]`).classList.remove('completed');
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Validate section
function validateSection(section) {
    const sectionElement = document.getElementById(`section${section}`);
    const inputs = sectionElement.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'var(--danger-color)';
            isValid = false;
        } else {
            input.style.borderColor = 'var(--border-color)';
        }
    });
    
    // Special validation for section 3 (country)
    if (section === 3) {
        const selectedCountry = document.getElementById('selectedCountry').value;
        if (!selectedCountry) {
            document.getElementById('countrySearch').style.borderColor = 'var(--danger-color)';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert('Sila lengkapkan semua medan yang diperlukan', 'danger');
    }
    
    return isValid;
}

// Save current section data
function saveCurrentSectionData() {
    const section = document.getElementById(`section${currentSection}`);
    const inputs = section.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        if (input.type !== 'checkbox' && input.type !== 'file') {
            formData[input.id] = input.value;
        } else if (input.type === 'checkbox') {
            formData[input.id] = input.checked;
        }
    });
}

// Show review
function showReview() {
    const reviewContent = document.getElementById('reviewContent');
    
    const sections = [
        {
            title: '📋 Maklumat Peribadi',
            items: [
                { label: 'Nama Penuh', value: formData.fullName },
                { label: 'Nama Panggilan', value: formData.nickname || '-' },
                { label: 'Jantina', value: formData.gender },
                { label: 'Tarikh Lahir', value: formData.birthDate },
                { label: 'No. IC/Passport', value: formData.icPassport },
                { label: 'Kewarganegaraan', value: formData.nationality }
            ]
        },
        {
            title: '🎫 Keahlian PAS',
            items: [
                { label: 'Nombor Ahli', value: formData.pasMemberId },
                { label: 'Tarikh Menjadi Ahli', value: formData.memberSince || '-' },
                { label: 'Cawangan/DUN', value: formData.branch },
                { label: 'Negeri', value: formData.state || '-' },
                { label: 'Status Keahlian', value: formData.membershipStatus || 'Ahli Biasa' }
            ]
        },
        {
            title: '🌍 Lokasi & Pekerjaan',
            items: [
                { label: 'Negara Semasa', value: formData.selectedCountry },
                { label: 'Bandar/Kota', value: formData.city },
                { label: 'Poskod', value: formData.postcode || '-' },
                { label: 'Alamat', value: formData.address || '-' },
                { label: 'Status Kediaman', value: formData.residenceStatus || '-' },
                { label: 'Tempoh di Luar Negara', value: formData.yearsAbroad || '-' },
                { label: 'Pekerjaan', value: formData.profession },
                { label: 'Bidang Industri', value: formData.industry || '-' },
                { label: 'Majikan/Universiti', value: formData.employer || '-' }
            ]
        },
        {
            title: '📞 Perhubungan & Lain-lain',
            items: [
                { label: 'Email', value: formData.email },
                { label: 'Telefon', value: formData.phone },
                { label: 'WhatsApp', value: formData.whatsapp || '-' },
                { label: 'Telegram', value: formData.telegram || '-' },
                { label: 'Kepakaran', value: formData.expertise || '-' },
                { label: 'Bahasa', value: formData.languages || '-' },
                { label: 'Pendidikan', value: formData.education || '-' }
            ]
        }
    ];
    
    reviewContent.innerHTML = sections.map(section => `
        <div class="review-section">
            <h3 style="font-size: 20px; margin-bottom: 15px; color: var(--primary-light);">${section.title}</h3>
            ${section.items.map(item => `
                <div class="review-item">
                    <div class="review-label">${item.label}:</div>
                    <div class="review-value">${item.value}</div>
                </div>
            `).join('')}
        </div>
    `).join('');
}

// Handle form submission
async function handleSubmit(e) {
    e.preventDefault();
    
    const agreeTerms = document.getElementById('agreeTerms').checked;
    const agreePrivacy = document.getElementById('agreePrivacy').checked;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Validate
    if (!agreeTerms || !agreePrivacy) {
        showAlert('Sila bersetuju dengan terma dan syarat', 'danger');
        return;
    }
    
    if (password !== confirmPassword) {
        showAlert('Kata laluan tidak sepadan', 'danger');
        return;
    }
    
    if (validatePasswordStrength(password) === 'weak') {
        showAlert('Kata laluan terlalu lemah', 'danger');
        return;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="loading"></span> Sedang memproses...';
    submitBtn.disabled = true;
    
    try {
        // Check if email exists
        const checkResponse = await fetch('tables/users?limit=1000');
        const checkData = await checkResponse.json();
        
        const existingUser = checkData.data.find(u => u.email === formData.email);
        if (existingUser) {
            showAlert('Email sudah didaftarkan', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            return;
        }
        
        // Hash password
        const passwordHash = await hashPassword(password);
        
        // Create user object
        const newUser = {
            id: generateUUID(),
            // Personal Info
            full_name: formData.fullName,
            nickname: formData.nickname || '',
            gender: formData.gender,
            birth_date: formData.birthDate,
            ic_passport: formData.icPassport,
            nationality: formData.nationality,
            photo_url: formData.photoUrl || '',
            
            // PAS Membership
            pas_member_id: formData.pasMemberId,
            member_since: formData.memberSince || '',
            branch: formData.branch,
            state: formData.state || '',
            membership_status: formData.membershipStatus || 'Ahli Biasa',
            
            // Location & Work
            country: formData.selectedCountry,
            city: formData.city,
            postcode: formData.postcode || '',
            address: formData.address || '',
            residence_status: formData.residenceStatus || '',
            years_abroad: formData.yearsAbroad || '',
            profession: formData.profession,
            industry: formData.industry || '',
            employer: formData.employer || '',
            
            // Contact & Additional
            email: formData.email,
            phone: formData.phone,
            whatsapp: formData.whatsapp || formData.phone,
            telegram: formData.telegram || '',
            expertise: formData.expertise || '',
            languages: formData.languages || '',
            education: formData.education || '',
            experience: formData.experience || '',
            contributions: formData.contributions || '',
            
            // Security
            password_hash: passwordHash,
            role: 'member',
            verified: false,
            last_login: new Date().toISOString(),
            bio: formData.experience || ''
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
            
            showAlert('Pendaftaran berjaya! Selamat datang ke PAS Global Connect!', 'success');
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