<template>
    <div class="chat-container">
      <!-- Sidebar for Searching Users -->
      <div class="sidebar">
        <h2 class="sidebar-title">Search Users</h2>
        <input v-model="searchQuery" placeholder="Search user..." class="search-input" @input="fetchUsers" />
        <ul>
          <li v-for="user in users" :key="user.id" @click="setSelectedUser(user)">
            <img :src="user.profile_photo_path" class="user-photo" />
            <div class="user-info">
              <span class="user-name">{{ user.name }}</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Chat Window -->
      <div class="chat-window" v-if="selectedUser">
        <div class="chat-header">
          <img :src="selectedUser.photo" class="header-photo" />
          <h3>{{ selectedUser.name }}</h3>
        </div>

        <div class="chat-messages">
          <div
            v-for="msg in messages"
            :key="msg.id"
            :class="{ 'message-sent': msg.sender_id === userId, 'message-received': msg.sender_id !== userId }"
          >
            <p>{{ msg.message }}</p>
          </div>
        </div>

        <!-- Input box to send message -->
        <div class="chat-input">
          <input v-model="message" placeholder="Type a message..." @keyup.enter="sendMessage" />
          <button @click="sendMessage">Send</button>
        </div>
      </div>
    </div>
  </template>
<script setup>
import { ref, computed, onMounted } from "vue";
import { useChatStore } from "../stores/chatStores.js";
import axios from "axios";

const chatStore = useChatStore();
const searchQuery = ref("");
const users = ref([]);
const message = ref("");
const userId = ref(1); // Replace with actual logged-in user ID

const fetchUsers = async () => {
  if (!searchQuery.value.trim()) {
    users.value = [];
    return;
  }
  try {
    const response = await axios.get("http://localhost:8000/user/search/users", {
      params: { query: searchQuery.value },
    });
    users.value = response.data;
  } catch (error) {
    console.error("❌ Failed to fetch users:", error);
  }
};

// ✅ Clicking on a user will update `selectedUser`
const setSelectedUser = (user) => {
  chatStore.setSelectedUser(user);
};

// ✅ Reactive computed properties for selectedUser & messages
const selectedUser = computed(() => chatStore.selectedUser);
const messages = computed(() => chatStore.messages);

const sendMessage = () => {
  if (!message.value.trim()) return;
  chatStore.sendMessage(message.value);
  message.value = "";
};

onMounted(() => {
  chatStore.connectSocket();
});
</script>



