<?php
session_start();
require_once '../config.php';

// Security Check: Ensure user is logged in and is an Admin
if (!isset($_SESSION['loggedin']) || strpos($_SESSION['role'], 'Admin') === false) {
    // For AJAX requests, it's better to send a JSON error response
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
        exit;
    }
    // For direct page access, redirect to login
    header("Location: ../login.php");
    exit;
}

// Page-specific data
$page_title = "RAIS Admin - Chat Management";
$active_page = "chat_management"; // For highlighting the active link in the sidebar

// NOTE: Static data is removed. Data will be fetched via JavaScript.

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                             <div class="text-center p-3 text-muted">Loading conversations...</div>
                        </div>
                    </div>

                    <div class="chat-area-panel">
                        <div class="chat-header-panel d-flex align-items-center">
                            <button class="btn btn-link d-md-none me-2" id="backToConversations"><i class="bi bi-arrow-left fs-5"></i></button>
                            <span id="activeChatUserName">Select a conversation</span>
                        </div>
                        <div class="chat-messages" id="chatMessages">
                             <div class="h-100 d-flex justify-content-center align-items-center text-muted">
                                Please select a conversation to view messages.
                            </div>
                        </div>
                        <div class="chat-input-area">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Reply..." id="adminMessageInput" disabled>
                                <button class="btn" type="button" id="sendAdminMessage" disabled>Send</button>
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
        xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    
    <script src="togglemodeScript.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let conversations = {};
            let activeUserId = null;
            let chatInterval;

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

            // --- ASYNC FUNCTIONS ---
            async function fetchConversations() {
                try {
                    const response = await fetch('admin_chat_handler.php?action=getConversations');
                    const data = await response.json();
                    if (data.status === 'success') {
                        const newConversations = {};
                        data.conversations.forEach(convo => {
                            newConversations[convo.id] = convo;
                        });
                        conversations = newConversations;
                        renderConversationList(conversations);
                    } else {
                        conversationListContainer.innerHTML = `<div class="text-center p-3 text-danger">${data.message}</div>`;
                    }
                } catch (error) {
                    console.error("Error fetching conversations:", error);
                    conversationListContainer.innerHTML = '<div class="text-center p-3 text-danger">Failed to load conversations.</div>';
                }
            }

            async function fetchMessages(userId) {
                const formData = new FormData();
                formData.append('action', 'getMessages');
                formData.append('userId', userId);

                try {
                    const response = await fetch('admin_chat_handler.php', { method: 'POST', body: formData });
                    const data = await response.json();
                    if (data.status === 'success') {
                        renderChatMessages(data.messages);
                    }
                } catch (error) {
                    console.error(`Error fetching messages for user ${userId}:`, error);
                }
            }

            // --- RENDER FUNCTIONS ---
            function renderConversationList(convosToRender) {
                conversationListContainer.innerHTML = '';
                 if (Object.keys(convosToRender).length === 0) {
                    conversationListContainer.innerHTML = '<div class="text-center p-3 text-muted">No active conversations.</div>';
                    return;
                }
                for (const userId in convosToRender) {
                    const convo = convosToRender[userId];
                    const conversationItem = document.createElement('div');
                    conversationItem.classList.add('conversation-item');
                    if (userId == activeUserId) {
                        conversationItem.classList.add('active');
                    }
                    conversationItem.setAttribute('data-user-id', userId);
                    
                    const profileImage = convo.profileImage ? `../${convo.profileImage}` : `https://placehold.co/40x40/004d40/FFFFFF?text=${convo.firstName.charAt(0)}${convo.lastName.charAt(0)}`;

                    conversationItem.innerHTML = `
                        <img src="${profileImage}" alt="User Avatar" onerror="this.onerror=null;this.src='https://placehold.co/40x40/D9D9D9/525252?text=??';">
                        <div class="details">
                            <div class="name">${convo.firstName} ${convo.lastName}</div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger delete-convo-btn ms-auto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteChatModal" 
                                data-user-id="${userId}" 
                                data-user-name="${convo.firstName} ${convo.lastName}">
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

            function renderChatMessages(messages = []) {
                chatMessagesContainer.innerHTML = '';
                if (!activeUserId || !conversations[activeUserId]) {
                    activeChatUserName.textContent = 'Select a conversation';
                    adminMessageInput.placeholder = 'No conversation selected...';
                    adminMessageInput.disabled = true;
                    sendAdminMessageBtn.disabled = true;
                    return;
                }

                const activeConvo = conversations[activeUserId];
                activeChatUserName.textContent = `${activeConvo.firstName} ${activeConvo.lastName}`;
                adminMessageInput.placeholder = `Reply to ${activeConvo.firstName}...`;
                adminMessageInput.disabled = false;
                sendAdminMessageBtn.disabled = false;
                
                if (messages.length === 0) {
                     chatMessagesContainer.innerHTML = '<div class="h-100 d-flex justify-content-center align-items-center text-muted">No messages in this conversation yet.</div>';
                     return;
                }

                messages.forEach(message => {
                    const messageBubble = document.createElement('div');
                    const senderType = message.sender_id == 0 ? 'admin' : 'user';
                    const senderName = senderType === 'user' ? `${activeConvo.firstName} ${activeConvo.lastName}` : 'Admin';
                    const formattedTime = new Date(message.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    messageBubble.classList.add('chat-message-bubble', senderType);
                    messageBubble.innerHTML = `
                        <div class="sender-name">${senderName}</div>
                        <div class="chat-message-content">${message.message}</div>
                        <span class="timestamp">${formattedTime}</span>
                    `;
                    chatMessagesContainer.appendChild(messageBubble);
                });
                chatMessagesContainer.scrollTop = chatMessagesContainer.scrollHeight;
            }

            // --- ACTION FUNCTIONS ---
            function switchActiveChat(userId) {
                activeUserId = userId;
                renderConversationList(conversations); // Re-render to highlight the active one
                fetchMessages(userId);

                clearInterval(chatInterval);
                chatInterval = setInterval(() => fetchMessages(activeUserId), 3000);
            }

            async function sendAdminMessage() {
                const messageText = adminMessageInput.value.trim();
                if (messageText && activeUserId) {
                    const formData = new FormData();
                    formData.append('action', 'sendMessage');
                    formData.append('receiver_id', activeUserId);
                    formData.append('message', messageText);

                    adminMessageInput.value = '';

                    try {
                        const response = await fetch('admin_chat_handler.php', { method: 'POST', body: formData });
                        const data = await response.json();
                        if(data.status === 'success') {
                            fetchMessages(activeUserId);
                        }
                    } catch (error) {
                        console.error("Error sending message:", error);
                    }
                }
            }
            
            // --- EVENT LISTENERS ---
            sendAdminMessageBtn.addEventListener('click', sendAdminMessage);
            adminMessageInput.addEventListener('keypress', (e) => e.key === 'Enter' && sendAdminMessage());
            backToConversationsBtn.addEventListener('click', () => {
                chatContainer.classList.remove('view-active');
                activeUserId = null;
                renderChatMessages(); // Clear the chat window
                clearInterval(chatInterval);
            });

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const filtered = Object.keys(conversations).reduce((acc, userId) => {
                    const convo = conversations[userId];
                    const fullName = `${convo.firstName} ${convo.lastName}`.toLowerCase();
                    if (fullName.includes(searchTerm)) {
                        acc[userId] = convo;
                    }
                    return acc;
                }, {});
                renderConversationList(filtered);
            });

            // --- MODAL LOGIC ---
            if (deleteChatModal) {
                deleteChatModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.getAttribute('data-user-name');
                    
                    deleteChatModal.querySelector('#deleteChatModalBody').textContent = `Are you sure you want to delete the entire conversation with ${userName}? This cannot be undone.`;
                    deleteChatModal.querySelector('#confirmDeleteChatButton').setAttribute('data-user-id-to-delete', userId);
                });

                const confirmBtn = document.getElementById('confirmDeleteChatButton');
                confirmBtn.addEventListener('click', async function() {
                    const userIdToDelete = this.getAttribute('data-user-id-to-delete');
                    const formData = new FormData();
                    formData.append('action', 'deleteConversation');
                    formData.append('userId', userIdToDelete);

                    try {
                        const response = await fetch('admin_chat_handler.php', { method: 'POST', body: formData });
                        const data = await response.json();
                        if(data.status === 'success') {
                            if (activeUserId == userIdToDelete) {
                                activeUserId = null;
                                renderChatMessages(); // Clear chat area
                            }
                            fetchConversations(); // Refresh list
                            bootstrap.Modal.getInstance(deleteChatModal).hide();
                        }
                    } catch (error) {
                         console.error("Error deleting conversation:", error);
                    }
                });
            }

            // --- INITIAL LOAD ---
            fetchConversations();
            setInterval(fetchConversations, 10000); // Poll for new conversations every 10 seconds
        });
    </script>
</body>

</html>
