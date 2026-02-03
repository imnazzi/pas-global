// Chat Functions for PAS Global Connect

// Check authentication
if (!checkAuth()) {
    window.location.href = 'index.html';
}

let currentChatUser = null;
let messageRefreshInterval = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initializeUserDisplay();
    loadContacts();
    loadAllUsers();
    
    // Check if there's a user parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user');
    if (userId) {
        openChat(userId);
    }
});

// Load contacts list
async function loadContacts() {
    const contactsList = document.getElementById('contactsList');
    const currentUser = getCurrentUser();
    
    try {
        // Get all users
        const usersResponse = await fetch('tables/users?limit=1000');
        const usersData = await usersResponse.json();
        
        // Get all messages
        const messagesResponse = await fetch('tables/messages?limit=1000');
        const messagesData = await messagesResponse.json();
        
        // Filter users who have conversations with current user
        const conversations = new Map();
        
        messagesData.data.forEach(msg => {
            if (msg.sender_id === currentUser.id || msg.receiver_id === currentUser.id) {
                const otherUserId = msg.sender_id === currentUser.id ? msg.receiver_id : msg.sender_id;
                if (!conversations.has(otherUserId) || new Date(msg.created_at) > new Date(conversations.get(otherUserId).lastMessage)) {
                    conversations.set(otherUserId, {
                        lastMessage: msg.created_at,
                        message: msg.message,
                        unread: msg.receiver_id === currentUser.id && !msg.read ? true : false
                    });
                }
            }
        });
        
        if (conversations.size === 0) {
            contactsList.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-comment-slash"></i>
                    <p>Tiada perbualan lagi</p>
                    <button class="btn btn-primary" onclick="toggleNewChatModal()" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i>
                        Mulakan Perbualan
                    </button>
                </div>
            `;
            return;
        }
        
        // Build contacts HTML
        const contactsHTML = [];
        conversations.forEach((conversation, userId) => {
            const user = usersData.data.find(u => u.id === userId);
            if (user) {
                contactsHTML.push({
                    time: new Date(conversation.lastMessage),
                    html: `
                        <div class="contact-item" onclick="openChat('${user.id}')">
                            <div class="contact-avatar online">
                                ${user.full_name.charAt(0).toUpperCase()}
                            </div>
                            <div class="contact-info">
                                <div class="contact-name">${user.full_name}</div>
                                <div class="contact-last-message">${conversation.message}</div>
                            </div>
                            <div class="contact-meta">
                                <div class="contact-time">${timeAgo(conversation.lastMessage)}</div>
                                ${conversation.unread ? '<span class="unread-badge">Baru</span>' : ''}
                            </div>
                        </div>
                    `
                });
            }
        });
        
        // Sort by most recent
        contactsHTML.sort((a, b) => b.time - a.time);
        contactsList.innerHTML = contactsHTML.map(c => c.html).join('');
        
    } catch (error) {
        console.error('Error loading contacts:', error);
        contactsList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-exclamation-circle"></i>
                <p>Ralat memuatkan kenalan</p>
            </div>
        `;
    }
}

// Search contacts
function searchContacts() {
    const searchTerm = document.getElementById('searchContacts').value.toLowerCase();
    const contacts = document.querySelectorAll('.contact-item');
    
    contacts.forEach(contact => {
        const name = contact.querySelector('.contact-name').textContent.toLowerCase();
        if (name.includes(searchTerm)) {
            contact.style.display = 'flex';
        } else {
            contact.style.display = 'none';
        }
    });
}

// Open chat with user
async function openChat(userId) {
    currentChatUser = userId;
    
    // Clear any existing refresh interval
    if (messageRefreshInterval) {
        clearInterval(messageRefreshInterval);
    }
    
    // Hide empty state
    document.getElementById('emptyChatState').style.display = 'none';
    document.getElementById('chatWindow').style.display = 'flex';
    
    // Get user info
    try {
        const response = await fetch(`tables/users/${userId}`);
        const user = await response.json();
        
        // Update chat header
        document.querySelector('.chat-user-avatar').textContent = user.full_name.charAt(0).toUpperCase();
        document.querySelector('.chat-user-name').textContent = user.full_name;
        
        // Load messages
        await loadMessages(userId);
        
        // Mark active contact
        document.querySelectorAll('.contact-item').forEach(item => {
            item.classList.remove('active');
        });
        event?.currentTarget?.classList.add('active');
        
        // Set up auto-refresh for messages
        messageRefreshInterval = setInterval(() => loadMessages(userId), 3000);
        
    } catch (error) {
        console.error('Error opening chat:', error);
    }
}

// Load messages
async function loadMessages(userId) {
    const currentUser = getCurrentUser();
    const messagesContainer = document.getElementById('chatMessages');
    
    try {
        const response = await fetch('tables/messages?limit=1000');
        const data = await response.json();
        
        // Filter messages for this conversation
        const messages = data.data.filter(msg => 
            (msg.sender_id === currentUser.id && msg.receiver_id === userId) ||
            (msg.sender_id === userId && msg.receiver_id === currentUser.id)
        ).sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        
        if (messages.length === 0) {
            messagesContainer.innerHTML = `
                <div class="empty-state">
                    <p style="color: var(--text-muted);">Tiada mesej lagi. Mulakan perbualan!</p>
                </div>
            `;
            return;
        }
        
        // Get user for avatar
        const userResponse = await fetch(`tables/users/${userId}`);
        const otherUser = await userResponse.json();
        
        messagesContainer.innerHTML = messages.map(msg => {
            const isSent = msg.sender_id === currentUser.id;
            const avatar = isSent ? currentUser.full_name.charAt(0) : otherUser.full_name.charAt(0);
            
            return `
                <div class="message ${isSent ? 'sent' : 'received'}">
                    <div class="message-avatar">${avatar.toUpperCase()}</div>
                    <div class="message-content">
                        <div class="message-bubble">${sanitizeInput(msg.message)}</div>
                        <div class="message-time">${formatDateTime(msg.created_at)}</div>
                    </div>
                </div>
            `;
        }).join('');
        
        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Mark messages as read
        messages.forEach(async msg => {
            if (msg.receiver_id === currentUser.id && !msg.read) {
                await fetch(`tables/messages/${msg.id}`, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ read: true })
                });
            }
        });
        
    } catch (error) {
        console.error('Error loading messages:', error);
    }
}

// Send message
async function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (!message || !currentChatUser) return;
    
    const currentUser = getCurrentUser();
    
    try {
        const newMessage = {
            id: generateUUID(),
            sender_id: currentUser.id,
            receiver_id: currentChatUser,
            message: sanitizeInput(message),
            encrypted: false,
            read: false
        };
        
        await fetch('tables/messages', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newMessage)
        });
        
        messageInput.value = '';
        await loadMessages(currentChatUser);
        await loadContacts();
        
    } catch (error) {
        console.error('Error sending message:', error);
        showAlert('Ralat menghantar mesej', 'danger');
    }
}

// Handle enter key
function handleEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Toggle new chat modal
function toggleNewChatModal() {
    const modal = document.getElementById('newChatModal');
    modal.classList.toggle('active');
}

// Load all users for new chat
async function loadAllUsers() {
    const usersList = document.getElementById('usersList');
    const currentUser = getCurrentUser();
    
    try {
        const response = await fetch('tables/users?limit=1000');
        const data = await response.json();
        
        // Filter out current user
        const users = data.data.filter(u => u.id !== currentUser.id);
        
        usersList.innerHTML = users.map(user => `
            <div class="user-item" onclick="startNewChat('${user.id}')">
                <div class="user-item-avatar">
                    ${user.full_name.charAt(0).toUpperCase()}
                </div>
                <div class="user-item-info">
                    <div class="user-item-name">${user.full_name}</div>
                    <div class="user-item-country">
                        <i class="fas fa-map-marker-alt"></i> ${user.country}
                    </div>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading users:', error);
    }
}

// Search users in modal
function searchUsers() {
    const searchTerm = document.getElementById('searchUsers').value.toLowerCase();
    const users = document.querySelectorAll('.user-item');
    
    users.forEach(user => {
        const name = user.querySelector('.user-item-name').textContent.toLowerCase();
        const country = user.querySelector('.user-item-country').textContent.toLowerCase();
        if (name.includes(searchTerm) || country.includes(searchTerm)) {
            user.style.display = 'flex';
        } else {
            user.style.display = 'none';
        }
    });
}

// Start new chat
function startNewChat(userId) {
    toggleNewChatModal();
    openChat(userId);
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (messageRefreshInterval) {
        clearInterval(messageRefreshInterval);
    }
});