document.addEventListener('DOMContentLoaded',() => {

    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('messageInput');  
    const chatListContainer = document.getElementById('chat-list');
    const messagesContainer = document.getElementById('messages');
    const currentUserId = document.querySelector('meta[name="user-id"]').content;
    const chatHeader=document.querySelector('.chat-header h5');
    const noChatsMessage = document.getElementById('no-chats-message');
    const ChatInput=document.querySelector(".chat-input");
    const divConversation=document.createElement('div');
    let receiverId = messagesContainer.getAttribute('data-receiver-id') || null;
    let currentChatId = null;


    function searchResponse(response)
    {
        return response.json();
    }

    function fetchUserinfo() {
        fetch('/chats/getUser',{ method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
        })
            .then(searchResponse)
            .then(user => {
                if (user && user.id) {
                    displayUserInfo(user);
                } 
            });
        }

        fetchUserinfo();

    function loadChatList() {
        fetch('/chats/all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
    }).then(searchResponse).then(chats=>{
        chatListContainer.innerHTML = ''; 

        chats.forEach(chat => {
            const chatItem = updateChatListItem(chat);
            chatListContainer.appendChild(chatItem);
        });
    })
}

    function initializeChat() {
    const lastChatUserId = messagesContainer.getAttribute('data-receiver-id');
    const chatUsername = messagesContainer.getAttribute('data-chat-username');
    const newChats = messagesContainer.getAttribute('data-new-chat') === 'true';
    divConversation.className='text-center mt-3';

    if (!lastChatUserId && !chatUsername && !newChats) {
        if (noChatsMessage) {
            noChatsMessage.style.display = 'block';
        }
        if (messageForm) {
            ChatInput.style.display = 'none';
        }
        divConversation.textContent="Non hai ancora iniziato nessuna conversazione";
        messagesContainer.appendChild(divConversation);
        chatHeader.textContent = 'Nessuna chat attiva';
        return;
    }
    else if (lastChatUserId) {
        receiverId = lastChatUserId;
        loadChat(receiverId);
    } 
    loadChatList();
}

    initializeChat();

    chatListContainer.addEventListener('click', (e) => {
        const chatItem = e.target.closest('.chat-list-item');
        
        if (chatItem) {
            const newReceiverId = chatItem.getAttribute('data-chat-user-id');
            if (currentChatId !== newReceiverId) { 
                receiverId = newReceiverId;
                loadChat(receiverId);
            }
        }
    });

    //Canale per far avvenire conversazione in tempo reale
    function subscribeToChatChannels() {
        if (!currentUserId || !receiverId) return;

    window.Echo.private(`chat.${currentUserId}.${receiverId}`)
    .listen('.new.message', (data) => {
        
        const message = data.message;
        const users = message.id_mittente === parseInt(receiverId) || 
                         message.id_destinatario === parseInt(receiverId);
        
        if (users) {
            const mio = message.id_mittente === parseInt(currentUserId);
            appendMessage(message, mio);
            loadChatList();
        }
    });

    window.Echo.private(`chat.${receiverId}.${currentUserId}`)
    .listen('.new.message', (data) => {
        
        const message = data.message;
        const users = message.id_mittente === parseInt(receiverId) || 
                         message.id_destinatario === parseInt(receiverId);
        
        if (users) {
            const mio = message.id_mittente === parseInt(currentUserId);
            appendMessage(message, mio);
            loadChatList();
        }
    });
    }

    // Invio del messaggio
    messageForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const message = messageInput.value.trim();
        if (!message || !receiverId) return;

            fetch(`/chats/${receiverId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            }).then(searchResponse).then(json=>{
                if (json.message) {
                    messageInput.value = '';
                    loadChatList();
                }
            })

    });

    if (receiverId) {
            fetch('/chats/last', {method: 'POST',headers: {'Content-Type': 'application/json','X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
        }).then(searchResponse).then(loadChat);
    } 

    function loadChat(receiverId) {
                fetch(`/chats/check/${receiverId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
            }).then(searchResponse).then(json=>{
                chatHeader.textContent="Chat con "+json.otherUser.username;
                messagesContainer.setAttribute('data-receiver-id', receiverId);
                currentChatId = receiverId;
                messagesContainer.innerHTML = ''; 
                
                if (json.messages.length === 0) {
                    divConversation.textContent="Nessun messaggio. Inizia la conversazione!";
                    divConversation.className='text-center mt-3';
                    messagesContainer.appendChild(divConversation);
                } else {
                    displayChatMessages(json.messages);
                }
    
                if (messageForm) {
                    messageForm.style.display = 'block';
                }
                subscribeToChatChannels();
            })
    }

    function displayUserInfo(user) {
        const appendNav=document.getElementById('navbarDropdown');

        const navAvatar=document.createElement('img');
        navAvatar.src=user.pic;
        navAvatar.alt=`${user.username}`;
        navAvatar.className= 'rounded-circle me-2';

        const span=document.createElement("span");
        span.textContent = user.username;

        appendNav.appendChild(navAvatar);
        appendNav.appendChild(span);

    }

    function displayChatMessages(messages) {
        messagesContainer.innerHTML = '';
        
        // Raggruppa i messaggi per giorno
        const messagesByDay = groupMessagesByDay(messages);
        
        Object.entries(messagesByDay).forEach(([day, dayMessages]) => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'day-header';
            dayHeader.textContent = formatDay(new Date(day));
            messagesContainer.appendChild(dayHeader);
            
            dayMessages.forEach(message => {
                appendMessage(message, message.id_mittente === parseInt(currentUserId));
            });
        });
    }

    function groupMessagesByDay(messages) {
        const groups = {};
        messages.forEach(message => {
            const date = new Date(message.timestamp);
            //Anno-Mese-Giorno
            const day = date.toISOString().split('T')[0]; 
            if (!groups[day]) {
                groups[day] = [];
            }
            groups[day].push(message);
        });
        return groups;
    }

    function formatDay(date) {
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);

        if (date.toDateString() === today.toDateString()) {
            return "Oggi";
        } else if (date.toDateString() === yesterday.toDateString()) {
            return "Ieri";
        } else {
            return date.toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
    }

    function appendMessage(message, isSent) {
        const existingMessages = messagesContainer.querySelectorAll('.message');
        const messageExists = Array.from(existingMessages).some(msg => {
            return msg.dataset.messageId === String(message.id);
        });

        if (messageExists) {
            return;
        }

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'message-sent' : 'message-received'}`;
        messageDiv.dataset.messageId = message.id;

        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        
        const cleanMessage = message.messaggio.replace(/undefined/, '');
        messageContent.innerHTML = `<div style="white-space: pre-wrap;">${cleanMessage}</div>`;

        //Mostrare il messaggio non intero nella lista chat
        if (messageContent.scrollHeight > 280) {
            messageContent.classList.add('truncated');
        }

        const messageTime = document.createElement('div');
        messageTime.className = 'message-time';
        messageTime.textContent = formatTimestamp(message.timestamp);

        messageDiv.appendChild(messageContent);
        messageDiv.appendChild(messageTime);

        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function formatTimestamp(timestamp) {
        if (!timestamp) return '';

        //Serve a convertire il formato sql database in formato data JS
        const date = new Date(timestamp.replace(' ', 'T')); 
        if (isNaN(date.getTime())) return ''; 
        
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        const messageDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        const diffDays = Math.floor((today - messageDate) / (1000 * 60 * 60 * 24));
        
    if (diffDays === 0) {
        return date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
    }
    else if (diffDays === 1) {
        return 'Ieri ' + date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
    }
    else if (diffDays <= 7) {
        return date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
    }
    return date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
}

    function updateChatListItem(chat) {
        const chatItem = document.createElement('div');
        chatItem.className = 'chat-list-item';
        chatItem.dataset.chatUserId = chat.userId;

        const avatar = document.createElement('img');
        avatar.src = chat.userAvatar;
        avatar.alt = chat.username;
        avatar.className = 'chat-list-avatar';

        const chatInfo = document.createElement('div');
        chatInfo.className = 'chat-list-info';

        const chatName = document.createElement('div');
        chatName.className = 'chat-list-name';
        chatName.textContent = chat.username;

        const preview = document.createElement('div');
        preview.className = 'chat-list-preview';

        const mio = chat.lastSenderId === parseInt(currentUserId);

        const previewSender = document.createElement('span');
        previewSender.className = 'chat-list-preview-sender';
        previewSender.innerHTML = mio ? 'Tu: ' : `${chat.username}: `;

        const previewMessage = document.createElement('span');
        previewMessage.className = 'chat-list-preview-message';
        previewMessage.textContent = chat.lastMessage;

        preview.appendChild(previewSender);
        preview.appendChild(previewMessage);
    
        chatInfo.appendChild(chatName);
        chatInfo.appendChild(preview);

        chatItem.appendChild(avatar);
        chatItem.appendChild(chatInfo);

        return chatItem;
    }
});

const logoutButton=document.getElementById('logout');
logoutButton.onclick = (e) => {
    e.preventDefault();
    window.location.href="/logout";
}