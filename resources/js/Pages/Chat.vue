<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
</script>

<template>
    <AppLayout>
    <div class="chat-container" :class="{ 'dark-mode': darkMode }">
      <div class="sidebar" :class="{ 'mobile-open': sidebarOpen }">
        <div class="search-container">
          <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input
              type="text"
              v-model="searchQuery"
              placeholder="Search friends..."
              class="search-input"
            />
            <i v-if="searchQuery" @click="clearSearch" class="fas fa-times clear-icon"></i>
          </div>
        </div>

        <div class="user-list">
          <h3>Friends</h3>
          <div
            v-for="user in filteredUsers"
            :key="user.id"
            class="user-item"
            :class="{ active: selectedUser && selectedUser.id === user.id }"
            @click="selectUser(user)"
          >
            <div class="avatar">
              <img :src="user.avatar" :alt="user.name" />
              <span class="status-indicator" :class="user.online ? 'online' : 'offline'"></span>
            </div>
            <div class="user-info">
              <div class="user-name">{{ user.name }}</div>
              <div class="last-message">{{ user.lastMessage }}</div>
            </div>
            <div class="message-info">
              <span class="time">{{ user.lastMessageTime }}</span>
              <span v-if="user.unreadCount" class="unread-badge">{{ user.unreadCount }}</span>
            </div>
          </div>
        </div>

        <!-- People You May Know section with toggle on mobile -->
        <div class="mobile-section-toggle" @click="togglePeopleSection">
          <h3>People you may know</h3>
          <i :class="peopleSectionOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
        </div>

        <div class="discover-section" :class="{ 'mobile-section-open': peopleSectionOpen }">
          <div
            v-for="user in suggestedUsers"
            :key="user.id"
            class="suggested-user-item"
          >
            <div class="avatar">
              <img :src="user.avatar" :alt="user.name" />
            </div>
            <div class="user-info">
              <div class="user-name">{{ user.name }}</div>
              <div class="mutual-friends">{{ user.mutualFriends }} mutual friends</div>
            </div>
            <button class="add-friend-btn" @click="addFriend(user)">
              <span>Add</span>
            </button>
          </div>
        </div>

        <!-- Mobile close sidebar button -->
        <button v-if="sidebarOpen" class="close-sidebar-btn" @click="toggleSidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Main chat area -->
      <div class="chat-area">
        <template v-if="selectedUser">
          <div class="chat-header">
            <!-- Back button for mobile -->
            <button class="back-btn" @click="deselectUser">
              <i class="fas fa-arrow-left"></i>
            </button>

            <div class="user-info">
              <div class="avatar">
                <img :src="selectedUser.avatar" :alt="selectedUser.name" />
                <span class="status-indicator" :class="selectedUser.online ? 'online' : 'offline'"></span>
              </div>
              <div>
                <div class="user-name">{{ selectedUser.name }}</div>
                <div class="status-text">{{ selectedUser.online ? 'Online' : 'Offline' }}</div>
              </div>
            </div>
            <div class="actions">
              <button class="action-btn">
                <i class="fas fa-phone"></i>
              </button>
              <button class="action-btn">
                <i class="fas fa-video"></i>
              </button>
              <button class="action-btn">
                <i class="fas fa-info-circle"></i>
              </button>
            </div>
          </div>

          <div class="messages-container" ref="messagesContainer">
            <div v-for="(message, index) in currentConversation" :key="index"
                 class="message"
                 :class="{ 'own-message': message.senderId === currentUserId }">
              <div class="message-content">
                <div class="message-text">{{ message.text }}</div>
                <div class="message-time">{{ message.time }}</div>
              </div>
            </div>
            <div v-if="currentConversation.length === 0" class="empty-conversation">
              <div class="empty-state">
                <i class="fas fa-comments"></i>
                <p>Start a conversation with {{ selectedUser.name }}</p>
              </div>
            </div>
          </div>

          <div class="message-input-container">
            <button class="attachment-btn">
              <i class="fas fa-paperclip"></i>
            </button>
            <textarea
              v-model="newMessage"
              placeholder="Type a message..."
              class="message-input"
              @keyup.enter="sendMessage"
            ></textarea>
            <button class="send-btn" @click="sendMessage" :disabled="!newMessage.trim()">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </template>

        <div v-else class="no-conversation">
          <div class="empty-state">
            <i class="fas fa-comments"></i>
            <h2>Select a conversation</h2>
            <p>Choose a friend from the list to start chatting</p>
          </div>
        </div>
      </div>
    </div>
    <Footer />
</AppLayout>
  </template>

  <script>
  export default {
    name: 'ChatApp',
    data() {
      return {
        currentUserId: 1,
        searchQuery: '',
        selectedUser: null,
        newMessage: '',
        darkMode: false,
        sidebarOpen: false,
        peopleSectionOpen: false,
        users: [
          {
            id: 2,
            name: 'Sarah Johnson',
            avatar: 'https://i.pravatar.cc/150?img=1',
            online: true,
            lastMessage: 'See you tomorrow!',
            lastMessageTime: '12:30 PM',
            unreadCount: 2
          },
          {
            id: 3,
            name: 'Michael Chen',
            avatar: 'https://i.pravatar.cc/150?img=2',
            online: false,
            lastMessage: 'Thanks for your help',
            lastMessageTime: 'Yesterday',
            unreadCount: 0
          },
          {
            id: 4,
            name: 'Jennifer Lopez',
            avatar: 'https://i.pravatar.cc/150?img=3',
            online: true,
            lastMessage: 'Did you check my proposal?',
            lastMessageTime: '2 days ago',
            unreadCount: 0
          },
          {
            id: 5,
            name: 'Robert Wilson',
            avatar: 'https://i.pravatar.cc/150?img=4',
            online: true,
            lastMessage: 'Let me know when you are free',
            lastMessageTime: '1 week ago',
            unreadCount: 0
          }
        ],
        suggestedUsers: [
          {
            id: 6,
            name: 'Emma Davis',
            avatar: 'https://i.pravatar.cc/150?img=5',
            mutualFriends: 3
          },
          {
            id: 7,
            name: 'John Smith',
            avatar: 'https://i.pravatar.cc/150?img=6',
            mutualFriends: 5
          }
        ],
        conversations: {
          2: [
            { id: 1, senderId: 2, text: 'Hey, how are you?', time: '12:10 PM' },
            { id: 2, senderId: 1, text: 'I\'m good, thanks! How about you?', time: '12:15 PM' },
            { id: 3, senderId: 2, text: 'Doing well! Are we still meeting tomorrow?', time: '12:20 PM' },
            { id: 4, senderId: 1, text: 'Yes, definitely!', time: '12:25 PM' },
            { id: 5, senderId: 2, text: 'Great! See you tomorrow!', time: '12:30 PM' }
          ],
          3: [
            { id: 1, senderId: 3, text: 'Can you help me with something?', time: 'Yesterday' },
            { id: 2, senderId: 1, text: 'Sure, what do you need?', time: 'Yesterday' },
            { id: 3, senderId: 3, text: 'I\'m having trouble with the project setup', time: 'Yesterday' },
            { id: 4, senderId: 1, text: 'I can help you with that. Let me share some instructions.', time: 'Yesterday' },
            { id: 5, senderId: 3, text: 'Thanks for your help', time: 'Yesterday' }
          ],
          4: [
            { id: 1, senderId: 4, text: 'I sent you my proposal', time: '2 days ago' },
            { id: 2, senderId: 1, text: 'I\'ll take a look at it soon', time: '2 days ago' },
            { id: 3, senderId: 4, text: 'Did you check my proposal?', time: '2 days ago' }
          ],
          5: [
            { id: 1, senderId: 5, text: 'Let me know when you are free', time: '1 week ago' }
          ]
        }
      };
    },
    computed: {
      filteredUsers() {
        if (!this.searchQuery) {
          return this.users;
        }

        const query = this.searchQuery.toLowerCase();
        return this.users.filter(user =>
          user.name.toLowerCase().includes(query)
        );
      },
      currentConversation() {
        return this.selectedUser ? (this.conversations[this.selectedUser.id] || []) : [];
      },
      isMobile() {
        return window.innerWidth <= 768;
      }
    },
    methods: {
      selectUser(user) {
        this.selectedUser = user;
        // Reset unread count when selecting a chat
        if (user.unreadCount) {
          user.unreadCount = 0;
        }

        // Close sidebar on mobile when selecting a user
        if (this.isMobile) {
          this.sidebarOpen = false;
        }

        // Scroll to bottom of messages
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      },
      deselectUser() {
        // Only for mobile view - go back to the user list
        if (this.isMobile) {
          this.selectedUser = null;
          this.sidebarOpen = true;
        }
      },
      sendMessage() {
        if (!this.newMessage.trim() || !this.selectedUser) return;

        const newMsg = {
          id: this.currentConversation.length + 1,
          senderId: this.currentUserId,
          text: this.newMessage.trim(),
          time: this.formatTime(new Date())
        };

        if (!this.conversations[this.selectedUser.id]) {
          this.$set(this.conversations, this.selectedUser.id, []);
        }

        this.conversations[this.selectedUser.id].push(newMsg);

        // Update the last message for the user
        this.selectedUser.lastMessage = this.newMessage.trim();
        this.selectedUser.lastMessageTime = 'Just now';

        this.newMessage = '';

        // Scroll to bottom
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      },
      scrollToBottom() {
        const container = this.$refs.messagesContainer;
        if (container) {
          container.scrollTop = container.scrollHeight;
        }
      },
      formatTime(date) {
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      },
      addFriend(user) {
        // Add the suggested user to the friends list
        this.users.push({
          id: user.id,
          name: user.name,
          avatar: user.avatar,
          online: false,
          lastMessage: 'Say hi!',
          lastMessageTime: 'Just now',
          unreadCount: 0
        });

        // Remove from suggested users
        const index = this.suggestedUsers.findIndex(u => u.id === user.id);
        if (index !== -1) {
          this.suggestedUsers.splice(index, 1);
        }

        // Initialize empty conversation
        this.$set(this.conversations, user.id, []);
      },
      toggleDarkMode() {
        this.darkMode = !this.darkMode;
        // Save preference to localStorage
        localStorage.setItem('chatDarkMode', this.darkMode);
      },
      toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
      },
      togglePeopleSection() {
        this.peopleSectionOpen = !this.peopleSectionOpen;
      },
      clearSearch() {
        this.searchQuery = '';
      },
      checkScreenSize() {
        if (window.innerWidth <= 768) {
          // On mobile, start with sidebar open and no selected user
          this.sidebarOpen = true;
          this.selectedUser = null;
        } else {
          // On desktop, keep sidebar always visible
          this.sidebarOpen = false;
        }
      }
    },
    mounted() {
      // Check for saved dark mode preference
      const savedDarkMode = localStorage.getItem('chatDarkMode');
      if (savedDarkMode !== null) {
        this.darkMode = savedDarkMode === 'true';
      } else {
        // Check system preference
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        this.darkMode = prefersDark;
      }

      // Initial screen size check
      this.checkScreenSize();

      // Listen for resize events
      window.addEventListener('resize', this.checkScreenSize);
    },
    beforeDestroy() {
      // Clean up event listener
      window.removeEventListener('resize', this.checkScreenSize);
    }
  };
  </script>

  <style scoped>
  .chat-container {
    display: flex;
    height: 100vh;
    width: 100%;
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    overflow: hidden;
  }

  /* Dark mode styles */
  .dark-mode {
    background-color: #121212;
    color: #e0e0e0;
  }

  .dark-mode .sidebar,
  .dark-mode .chat-area,
  .dark-mode .chat-header,
  .dark-mode .message-input-container,
  .dark-mode .mobile-header {
    background-color: #1e1e1e;
    border-color: #333;
  }

  .dark-mode .search-input,
  .dark-mode .message-input {
    background-color: #2d2d2d;
    color: #e0e0e0;
    border-color: #333;
  }

  .dark-mode .user-item:hover,
  .dark-mode .suggested-user-item:hover,
  .dark-mode .action-btn:hover {
    background-color: #2d2d2d;
  }

  .dark-mode .user-item.active {
    background-color: rgba(254, 77, 1, 0.15);
  }

  .dark-mode .user-name {
    color: #e0e0e0;
  }

  .dark-mode .time,
  .dark-mode .last-message,
  .dark-mode .mutual-friends,
  .dark-mode .status-text,
  .dark-mode h3 {
    color: #aaa;
  }

  .dark-mode .message-content {
    background-color: #2d2d2d;
    color: #e0e0e0;
  }

  .dark-mode .own-message .message-content {
    background-color: #fe4d01;
    color: white;
  }

  .dark-mode .empty-state {
    color: #aaa;
  }

  .dark-mode .no-conversation {
    background-color: #121212;
  }

  /* Mobile header */
  .mobile-header {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    background-color: white;
    border-bottom: 1px solid #e0e0e0;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 100;
  }

  .menu-btn, .theme-toggle, .back-btn {
    background: none;
    border: none;
    font-size: 18px;
    color: #65676b;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
  }

  .dark-mode .menu-btn,
  .dark-mode .theme-toggle,
  .dark-mode .back-btn {
    color: #e0e0e0;
  }

  .theme-toggle:hover,
  .menu-btn:hover,
  .back-btn:hover {
    background-color: #f0f2f5;
  }

  .dark-mode .theme-toggle:hover,
  .dark-mode .menu-btn:hover,
  .dark-mode .back-btn:hover {
    background-color: #2d2d2d;
  }

  .mobile-header h2 {
    margin: 0;
    font-size: 18px;
  }

  /* Sidebar */
  .sidebar {
    width: 350px;
    background-color: white;
    border-right: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
    height: 100%;
    z-index: 20;
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border-bottom: 1px solid #e0e0e0;
  }

  .sidebar-header h2 {
    margin: 0;
    font-size: 20px;
  }

  .search-container {
    padding: 16px;
    border-bottom: 1px solid #e0e0e0;
  }

  .search-wrapper {
    position: relative;
    width: 100%;
  }

  .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #65676b;
  }

  .dark-mode .search-icon {
    color: #aaa;
  }

  .clear-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #65676b;
    cursor: pointer;
  }

  .dark-mode .clear-icon {
    color: #aaa;
  }

  .search-input {
    width: 100%;
    padding: 10px 40px;
    border-radius: 20px;
    border: 1px solid #e0e0e0;
    background-color: #f0f2f5;
    outline: none;
    font-size: 14px;
  }

  .search-input:focus {
    border-color: #fe4d01;
  }

  .user-list {
    flex: 1;
    overflow-y: auto;
  }

  .user-list h3, .discover-section h3, .mobile-section-toggle h3 {
    padding: 16px;
    margin: 0;
    color: #65676b;
    font-size: 16px;
    font-weight: 600;
  }

  .user-item, .suggested-user-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    cursor: pointer;
    position: relative;
    transition: background-color 0.2s;
  }

  .user-item:hover, .suggested-user-item:hover {
    background-color: #f0f2f5;
  }

  .user-item.active {
    background-color: #ffe8e0;
  }

  .avatar {
    position: relative;
    margin-right: 12px;
  }

  .avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
  }

  .status-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
  }

  .dark-mode .status-indicator {
    border-color: #1e1e1e;
  }

  .status-indicator.online {
    background-color: #31a24c;
  }

  .status-indicator.offline {
    background-color: #65676b;
  }

  .user-info {
    flex: 1;
    min-width: 0;
  }

  .user-name {
    font-weight: 600;
    margin-bottom: 2px;
    color: #050505;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .last-message, .mutual-friends {
    color: #65676b;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .message-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    margin-left: 8px;
  }

  .time {
    font-size: 12px;
    color: #65676b;
    margin-bottom: 4px;
  }

  .unread-badge {
    background-color: #fe4d01;
    color: white;
    font-size: 12px;
    font-weight: 600;
    min-width: 20px;
    height: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 6px;
  }

  .mobile-section-toggle {
    display: none;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    border-top: 1px solid #e0e0e0;
    padding-right: 16px;
  }

  .discover-section {
    border-top: 1px solid #e0e0e0;
    padding-bottom: 16px;
  }

  .add-friend-btn {
    background-color: #fe4d01;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 6px 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    font-size: 14px;
  }

  .add-friend-btn:hover {
    background-color: #e04600;
  }

  .close-sidebar-btn {
    display: none;
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 24px;
    color: #65676b;
    cursor: pointer;
    z-index: 30;
  }

  .dark-mode .close-sidebar-btn {
    color: #e0e0e0;
  }

  /* Chat area */
  .chat-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: white;
  }

  .chat-header {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e0e0e0;
    background-color: white;
  }

  .back-btn {
    display: none;
    margin-right: 12px;
  }

  .chat-header .user-info {
    display: flex;
    align-items: center;
    flex: 1;
  }

  .status-text {
    font-size: 13px;
    color: #65676b;
  }

  .actions {
    display: flex;
  }

  .action-btn {
    background: none;
    border: none;
    color: #65676b;
    font-size: 18px;
    padding: 8px;
    cursor: pointer;
    border-radius: 50%;
    margin-left: 8px;
    transition: background-color 0.2s;
  }

  .dark-mode .action-btn {
    color: #e0e0e0;
  }

  .action-btn:hover {
    background-color: #f0f2f5;
    color: #fe4d01;
  }

  .dark-mode .action-btn:hover {
    background-color: #2d2d2d;
    color: #fe4d01;
  }

  .messages-container {
    flex: 1;
    padding: 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
  }

  .message {
    margin-bottom: 16px;
    max-width: 75%;
    align-self: flex-start;
  }

  .own-message {
    align-self: flex-end;
  }

  .message-content {
    background-color: #f0f2f5;
    padding: 12px;
    border-radius: 18px;
    position: relative;
  }

  .own-message .message-content {
    background-color: #fe4d01;
    color: white;
  }

  .message-text {
    font-size: 14px;
    line-height: 1.4;
    white-space: pre-wrap;
    word-break: break-word;
  }

  .message-time {
    font-size: 11px;
    color: #65676b;
    margin-top: 4px;
    text-align: right;
  }

  .own-message .message-time {
    color: rgba(255, 255, 255, 0.8);
  }

  .message-input-container {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-top: 1px solid #e0e0e0;
    background-color: white;
  }

  .attachment-btn {
    background: none;
    border: none;
    color: #65676b;
    font-size: 18px;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 50%;
    transition: color 0.2s;
  }

  .dark-mode .attachment-btn {
    color: #e0e0e0;
  }

  .attachment-btn:hover {
    color: #fe4d01;
  }

  .message-input {
    flex: 1;
    border: none;
    border-radius: 20px;
    background-color: #f0f2f5;
    padding: 10px 16px;
    margin: 0 12px;
    resize: none;
    max-height: 100px;
    outline: none;
    font-family: inherit;
    font-size: 14px;
  }

  .send-btn {
    background-color: #fe4d01;
    color: white;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s;
  }

  .send-btn:disabled {
    background-color: #e4e6eb;
    cursor: not-allowed;
  }

  .dark-mode .send-btn:disabled {
    background-color: #444;
  }

  .send-btn:not(:disabled):hover {
    background-color: #e04600;
  }

  .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #65676b;
  }

  .empty-state i {
    font-size: 48px;
    color: #fe4d01;
    margin-bottom: 16px;
  }

  .empty-state h2 {
    margin: 8px 0;
    font-weight: 600;
  }

  .no-conversation {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
  }

  .empty-conversation {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Mobile styles */
  @media (max-width: 768px) {
    .mobile-header {
      display: flex;
    }

    .chat-container {
      padding-top: 56px; /* Height of mobile header */
    }

    .sidebar {
      position: fixed;
      left: 0;
      top: 56px;
      bottom: 0;
      width: 100%;
      transform: translateX(-100%);
      transition: transform 0.3s ease;
      z-index: 10;
    }

    .sidebar.mobile-open {
      transform: translateX(0);
    }

    .sidebar-header {
      display: none;
    }

    .close-sidebar-btn {
      display: block;
    }

    .mobile-section-toggle {
      display: flex;
    }

    .discover-section {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
}
    </style>
