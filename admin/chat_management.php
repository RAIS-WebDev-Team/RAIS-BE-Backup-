<?php
// Page-specific data
$page_title = "RAIS Admin - Chat Management";
$active_page = "chat_management"; // For highlighting the active link in the sidebar

// In a real application, this data would be fetched from a database.
$conversations = [
    "user1" => [
        "name" => "John Doe",
        "avatar" => "https://placehold.co/40x40/D9D9D9/525252?text=JD",
        "messages" => [
            ["sender" => "user", "text" => "Hello, I have a question about my visa application.", "timestamp" => "10:05 AM"],
            ["sender" => "admin", "text" => "Certainly, John. What specific questions do you have regarding your visa application?", "timestamp" => "10:07 AM"],
            ["sender" => "user", "text" => "I'm confused about the financial proof requirements.", "timestamp" => "10:10 AM"]
        ]
    ],
    "user2" => [
        "name" => "Jane Smith",
        "avatar" => "https://placehold.co/40x40/D9D9D9/525252?text=JS",
        "messages" => [
            ["sender" => "user", "text" => "When is the next IELTS fair?", "timestamp" => "10:15 AM"],
            ["sender" => "admin", "text" => "Hi Jane, the next IELTS Mini Fair is scheduled for March 29, 2025.", "timestamp" => "10:17 AM"]
        ]
    ],
    "user3" => [
        "name" => "Peter Jones",
        "avatar" => "https://placehold.co/40x40/D9D9D9/525252?text=PJ",
        "messages" => [
            ["sender" => "user", "text" => "I need help updating my profile information.", "timestamp" => "10:20 AM"]
        ]
    ]
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link rel="icon" href="../img/logoulit.png" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-wrapper">
        
        <?php require_once 'sidebar.php'; ?>

        <div class="content-area">
            
            <?php require_once 'header.php'; ?>

            <main class="main-content main-content-chat">
                <h1>Chat Management</h1>

                <div class="chat-container-admin">
                    <div class="conversation-list-panel">
                        <div class="conversation-search">
                            <input type="text" class="form-control" placeholder="Search conversations..." id="searchConversationsInput">
                        </div>
                        <div id="conversationList">
                            <!-- Conversation list is rendered by JavaScript -->
                        </div>
                    </div>

                    <div class="chat-area-panel">
                        <div class="chat-header-panel d-flex align-items-center">
                            <button class="btn btn-link d-md-none me-2" id="backToConversations"><i class="bi bi-arrow-left fs-5"></i></button>
                            <span id="activeChatUserName">Select a conversation</span>
                        </div>
                        <div class="chat-messages" id="chatMessages">
                             <!-- Messages are rendered by JavaScript -->
                        </div>
                        <div class="chat-input-area">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Reply..." id="adminMessageInput">
                                <button class="btn" type="button" id="sendAdminMessage">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- MODALS -->
    <div class="modal fade" id="deleteChatModal" tabindex="-1" aria-labelledby="deleteChatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteChatModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deleteChatModalBody">
                    Are you sure you want to delete this conversation?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteChatButton">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    
    <!-- Corrected the filename from togglemodeScripts.js to togglemodeScript.js -->
    <script src="togglemodeScript.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const conversations = <?php echo json_encode($conversations, JSON_PRETTY_PRINT); ?>;
            let activeUserId = Object.keys(conversations)[0] || null;

            // --- DOM Element Selectors ---
            const chatContainer = document.querySelector('.chat-container-admin');
            const conversationListContainer = document.getElementById('conversationList');
            const chatMessagesContainer = document.getElementById('chatMessages');
            const activeChatUserName = document.getElementById('activeChatUserName');
            const adminMessageInput = document.getElementById('adminMessageInput');
            const sendAdminMessageBtn = document.getElementById('sendAdminMessage');
            const backToConversationsBtn = document.getElementById('backToConversations');
            const searchInput = document.getElementById('searchConversationsInput');
            const deleteChatModal = document.getElementById('deleteChatModal');

            // --- FUNCTIONS ---
            function renderConversationList(filteredConversations) {
                conversationListContainer.innerHTML = '';
                for (const userId in filteredConversations) {
                    const convo = filteredConversations[userId];
                    const conversationItem = document.createElement('div');
                    conversationItem.classList.add('conversation-item');
                    if (userId === activeUserId) {
                        conversationItem.classList.add('active');
                    }
                    conversationItem.setAttribute('data-user-id', userId);
                    
                    conversationItem.innerHTML = `
                        <img src="${convo.avatar}" alt="User Avatar">
                        <div class="details">
                            <div class="name">${convo.name}</div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-convo-btn ms-auto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteChatModal" 
                                data-user-id="${userId}" 
                                data-user-name="${convo.name}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                    
                    conversationItem.addEventListener('click', (e) => {
                        if (e.target.closest('.delete-convo-btn')) return; 
                        
                        switchActiveChat(userId);
                        chatContainer.classList.add('view-active');
                    });
                    conversationListContainer.appendChild(conversationItem);
                }
            }

            function renderChatMessages() {
                chatMessagesContainer.innerHTML = '';
                if (!activeUserId || !conversations[activeUserId]) {
                    activeChatUserName.textContent = 'Select a conversation';
                    adminMessageInput.placeholder = 'No conversation selected...';
                    return;
                }

                const activeConvo = conversations[activeUserId];
                activeChatUserName.textContent = activeConvo.name;
                adminMessageInput.placeholder = `Reply to ${activeConvo.name}...`;

                activeConvo.messages.forEach(message => {
                    const messageBubble = document.createElement('div');
                    messageBubble.classList.add('chat-message-bubble', message.sender);
                    messageBubble.innerHTML = `
                        <div class="sender-name">${message.sender === 'user' ? activeConvo.name : 'Admin'}</div>
                        <div class="chat-message-content">${message.text}</div>
                        <span class="timestamp">${message.timestamp}</span>
                    `;
                    chatMessagesContainer.appendChild(messageBubble);
                });
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }

            function switchActiveChat(userId) {
                activeUserId = userId;
                renderConversationList(conversations);
                renderChatMessages();
            }

            function sendAdminMessage() {
                const messageText = adminMessageInput.value.trim();
                if (messageText && activeUserId) {
                    const newMessage = {
                        sender: "admin",
                        text: messageText,
                        timestamp: new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
                    };
                    conversations[activeUserId].messages.push(newMessage);
                    renderChatMessages();
                    adminMessageInput.value = '';
                }
            }
            
            // --- EVENT LISTENERS ---
            sendAdminMessageBtn.addEventListener('click', sendAdminMessage);
            adminMessageInput.addEventListener('keypress', (e) => e.key === 'Enter' && sendAdminMessage());
            backToConversationsBtn.addEventListener('click', () => chatContainer.classList.remove('view-active'));

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredConversations = Object.keys(conversations).reduce((acc, userId) => {
                    if (conversations[userId].name.toLowerCase().includes(searchTerm)) {
                        acc[userId] = conversations[userId];
                    }
                    return acc;
                }, {});
                renderConversationList(filteredConversations);
            });

            // --- MODAL LOGIC ---
            if (deleteChatModal) {
                deleteChatModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');
                    
                    deleteChatModal.querySelector('#deleteChatModalBody').textContent = `Are you sure you want to delete the entire conversation with ${userName}?`;
                    deleteChatModal.querySelector('#confirmDeleteChatButton').setAttribute('data-user-id-to-delete', userId);
                });

                const confirmBtn = document.getElementById('confirmDeleteChatButton');
                confirmBtn.addEventListener('click', function() {
                    const userIdToDelete = this.getAttribute('data-user-id-to-delete');
                    
                    delete conversations[userIdToDelete];
                    
                    if (activeUserId === userIdToDelete) {
                        const remainingIds = Object.keys(conversations);
                        activeUserId = remainingIds.length > 0 ? remainingIds[0] : null;
                    }

                    renderConversationList(conversations);
                    renderChatMessages();
                    bootstrap.Modal.getInstance(deleteChatModal).hide();
                });
            }

            // --- INITIAL RENDER ---
            renderConversationList(conversations);
            renderChatMessages();
        });
    </script>
</body>

</html>