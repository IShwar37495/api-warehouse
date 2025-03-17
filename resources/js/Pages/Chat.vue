<template>
    <div class="chat-container">
      <!-- Sidebar for recent chats with search -->
      <div class="sidebar">
        <h2 class="sidebar-title">Recent Chats</h2>
        <input v-model="searchQuery" placeholder="Search user..." class="search-input" />

        <ul>
          <li v-for="user in filteredChats" :key="user.id" @click="selectChat(user)">
            <img :src="user.photo" class="user-photo" />
            <div class="user-info">
              <span class="user-name">{{ user.name }}</span>
              <span class="last-message">{{ user.lastMessage }}</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Chat Window -->
      <div class="chat-window">
        <div class="chat-header" v-if="selectedUser">
          <img :src="selectedUser.photo" class="header-photo" />
          <h3>{{ selectedUser.name }}</h3>
        </div>
        <div class="chat-messages">
          <div
            v-for="msg in messages"
            :key="msg.id"
            :class="{ 'message-sent': msg.senderId === userId, 'message-received': msg.senderId !== userId }"
          >
            <p>{{ msg.message }}</p>
          </div>
        </div>
        <div class="chat-input">
          <input v-model="message" placeholder="Type a message..." @keyup.enter="sendMessage" />
          <button @click="sendMessage">Send</button>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from "vue";
  import { io } from "socket.io-client";
  import axios from "axios";

  const userId = ref(null);
  const recentChats = ref([]);
  const selectedUser = ref(null);
  const messages = ref([]);
  const message = ref("");
  const searchQuery = ref("");
  const socket = ref(null);

  const fetchAccessToken = async () => {
    try {
      const response = await axios.get("http://localhost:8000/user/chat/auth/token", { withCredentials: true });
      return response.data.data;
    } catch (error) {
      console.error("Failed to fetch access token:", error);
      return null;
    }
  };

  const fetchRecentChats = async () => {
    try {
      const response = await axios.get("http://localhost:3000/api/recent-chats", { withCredentials: true });
      recentChats.value = response.data;
    } catch (error) {
      console.error("Failed to fetch recent chats:", error);
    }
  };

  const connectWebSocket = async () => {
    const token = await fetchAccessToken();
    if (!token) return;

    socket.value = io("http://localhost:3000", { auth: { token } });

    socket.value.on("connect", () => console.log("✅ Connected"));
    socket.value.on("disconnect", () => console.warn("⚠️ Disconnected"));
    socket.value.on("newMessage", (msg) => {
      if (selectedUser.value && msg.senderId === selectedUser.value.id) {
        messages.value.push(msg);
      }
    });
  };

  const selectChat = (user) => {
    selectedUser.value = user;
    fetchMessages(user.id);
  };

  const fetchMessages = async (receiverId) => {
    try {
      const response = await axios.get(`http://localhost:3000/api/messages/${receiverId}`);
      messages.value = response.data;
    } catch (error) {
      console.error("Failed to fetch messages:", error);
    }
  };

  const sendMessage = () => {
    if (!message.value.trim()) return;
    socket.value.emit("sendMessage", { receiverId: selectedUser.value.id, message: message.value });
    messages.value.push({ senderId: userId.value, message: message.value });
    message.value = "";
  };

  // ✅ Filter users based on search input
  const filteredChats = computed(() => {
    if (!searchQuery.value.trim()) {
      return recentChats.value;
    }
    return recentChats.value.filter((user) =>
      user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      user.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });

  onMounted(() => {
    fetchRecentChats();
    connectWebSocket();
  });
  </script>

  <style scoped>
  .chat-container {
    display: flex;
    height: 100vh;
    background-color: #f9f9f9;
  }
  .sidebar {
    width: 300px;
    background-color: #fe4d01;
    color: white;
    padding: 20px;
    overflow-y: auto;
  }
  .sidebar-title {
    font-size: 24px;
    margin-bottom: 10px;
  }
  .search-input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: none;
    border-radius: 5px;
  }
  .user-photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }
  .user-info {
    display: flex;
    flex-direction: column;
  }
  .chat-window {
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .chat-header {
    display: flex;
    align-items: center;
    padding: 20px;
    background: #fff;
    border-bottom: 1px solid #ddd;
  }
  .header-photo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
  }
  .chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }
  .message-sent {
    align-self: flex-end;
    background-color: #fe4d01;
    color: white;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
  }
  .message-received {
    align-self: flex-start;
    background-color: #ddd;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
  }
  .chat-input {
    display: flex;
    padding: 10px;
    background: #fff;
    border-top: 1px solid #ddd;
  }
  .chat-input input {
    flex: 1;
    padding: 10px;
    border: none;
    outline: none;
  }
  .chat-input button {
    background: #fe4d01;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
  }
  </style>
