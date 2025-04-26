<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, onUnmounted, computed, watch } from "vue";
import axios from "axios";
import { formatDistanceToNow } from "date-fns";

// Utility function for debouncing function calls
const debounce = (fn, delay) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn(...args), delay);
    };
};
import AttachmentIcon from "@/Components/Icons/AttachmentIcon.vue";
import SendIcon from "@/Components/Icons/SendIcon.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

// State management
const users = ref([]);
const chats = ref([]);
const messages = ref([]);
const newMessage = ref("");
const searchQuery = ref("");
const selectedChatId = ref(null);
const selectedUserId = ref(null);
const loading = ref(false);
const fileInput = ref(null);
const attachmentPreview = ref(null);
const selectedFile = ref(null);
const unreadCounts = ref({});
const isMobile = ref(window.innerWidth < 768);
const showChatList = ref(true);
const imageViewerUrl = ref(null); // For image viewer modal
const refreshInterval = ref(null); // For periodic refresh fallback
const isDarkMode = ref(localStorage.getItem("theme") === "dark"); // Dark mode state

// Watch for window resize to handle responsive layout
window.addEventListener("resize", () => {
    isMobile.value = window.innerWidth < 768;
    showChatList.value = !isMobile.value || !selectedChatId.value;
});

// Watch for selected chat changes to handle mobile view
watch(selectedChatId, (newVal) => {
    if (isMobile.value && newVal) {
        showChatList.value = false;
    }
});

// Toggle dark mode function
function toggleDarkMode() {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle("dark", isDarkMode.value);
    localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
}

// Fetch chats on component mount
onMounted(() => {
    fetchRecentChats();
    setupEchoListeners();

    // Apply dark mode on mount if needed
    if (isDarkMode.value) {
        document.documentElement.classList.add("dark");
    }

    // Debug Echo connection
    console.log("Echo connection setup with user ID:", page.props.auth.user.id);

    // Add connection status listeners
    window.Echo.connector.pusher.connection.bind("connected", () => {
        console.log("Successfully connected to Pusher/Reverb!");
    });

    window.Echo.connector.pusher.connection.bind("disconnected", () => {
        console.log("Disconnected from Pusher/Reverb");
    });

    window.Echo.connector.pusher.connection.bind("error", (err) => {
        console.error("Error connecting to Pusher/Reverb:", err);
    });
});

// Clean up on component unmount
onUnmounted(() => {
    // Clear any refresh intervals
    if (refreshInterval.value) {
        clearInterval(refreshInterval.value);
        refreshInterval.value = null;
    }

    // Unbind Echo listeners to prevent memory leaks
    if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
        window.Echo.connector.pusher.connection.unbind("connected");
        window.Echo.connector.pusher.connection.unbind("disconnected");
        window.Echo.connector.pusher.connection.unbind("error");
    }

    console.log("Chat component unmounted, listeners cleaned up");
});

// Sorted chats based on latest message
const sortedChats = computed(() => {
    return [...chats.value].sort((a, b) => {
        if (!a.latest_message || !b.latest_message) return 0;
        return (
            new Date(b.latest_message.created_at) -
            new Date(a.latest_message.created_at)
        );
    });
});

// Fetch user's recent chats with latest messages
function fetchRecentChats() {
    loading.value = true;
    axios
        .get(route("messages.getChats"))
        .then((response) => {
            chats.value = response.data.data;
            // Initialize unread counts
            chats.value.forEach((chat) => {
                if (chat.unread_count) {
                    unreadCounts.value[chat.id] = chat.unread_count;
                }
            });
        })
        .catch((error) => {
            console.error("Error fetching chats:", error);
        })
        .finally(() => {
            loading.value = false;
        });
}

// Function to refresh messages for the current chat
function refreshMessages() {
    if (!selectedChatId.value) return;

    axios
        .get(route("messages.getMessages", selectedChatId.value))
        .then((response) => {
            messages.value = response.data.data;
        })
        .catch((error) => {
            console.error("Error refreshing messages:", error);
        });
}

// Open chat and load messages
function openChat(chatId, userId) {
    // Clear any existing refresh interval
    if (refreshInterval.value) {
        clearInterval(refreshInterval.value);
        refreshInterval.value = null;
    }

    selectedChatId.value = chatId;
    selectedUserId.value = userId;
    loading.value = true;

    // On mobile, hide the chat list when opening a chat
    if (isMobile.value) {
        showChatList.value = false;
    }

    // Clear any file previews
    clearAttachment();

    // Fetch messages for this chat
    axios
        .get(route("messages.getMessages", chatId))
        .then((response) => {
            messages.value = response.data.data;
            // Mark messages as seen
            markAsSeen(chatId);

            // Scroll to bottom of messages
            scrollToBottom();

            // Set up a fallback refresh interval (every 10 seconds)
            refreshInterval.value = setInterval(refreshMessages, 10000);
        })
        .catch((error) => {
            console.error("Error fetching messages:", error);
        })
        .finally(() => {
            loading.value = false;
        });
}

// Return to chat list (for mobile)
function backToList() {
    if (isMobile.value) {
        showChatList.value = true;
    }
}

// Mark messages as seen when opening a chat
function markAsSeen(chatId) {
    axios
        .post(route("messages.markAsSeen", chatId))
        .then(() => {
            // Clear unread count for this chat
            unreadCounts.value[chatId] = 0;
        })
        .catch((error) => {
            console.error("Error marking messages as seen:", error);
        });
}

// Search for users - debounced to improve performance
const searchUsers = debounce(() => {
    if (!searchQuery.value.trim()) {
        fetchRecentChats();
        return;
    }

    loading.value = true;
    axios
        .get(route("messages.searchUsers"), {
            params: { searchTerm: searchQuery.value },
        })
        .then((response) => {
            users.value = response.data.data.data;
            // Hide chats and show search results
            chats.value = [];
        })
        .catch((error) => {
            console.error("Error searching users:", error);
        })
        .finally(() => {
            loading.value = false;
        });
}, 300); // 300ms debounce delay

// Clear search and show chats
function clearSearch() {
    searchQuery.value = "";
    users.value = [];
    fetchRecentChats();
}

// Start new chat with user
function startNewChat(userId) {
    axios
        .post(route("messages.startChat"), { user_id: userId })
        .then((response) => {
            selectedChatId.value = response.data.chat_id;
            selectedUserId.value = userId;
            messages.value = [];

            // On mobile, hide the chat list when starting a new chat
            if (isMobile.value) {
                showChatList.value = false;
            }

            // Refresh chats to include the new one
            fetchRecentChats();
        })
        .catch((error) => {
            console.error("Error starting new chat:", error);
        });
}

// Format timestamp to relative time
function formatTime(timestamp) {
    if (!timestamp) return "";
    return formatDistanceToNow(new Date(timestamp), { addSuffix: true });
}

// Open image in viewer
function openImage(url) {
    imageViewerUrl.value = url;
}

// Close image viewer
function closeImageViewer() {
    imageViewerUrl.value = null;
}

// Handle file selection
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;

    selectedFile.value = file;

    // Preview image if it's an image file
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = (e) => {
            attachmentPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        // Show file name for non-image files
        attachmentPreview.value = file.name;
    }
}

// Clear attachment
function clearAttachment() {
    selectedFile.value = null;
    attachmentPreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = "";
    }
}

// Send message (text or file)
function sendMessage() {
    if (
        (!newMessage.value.trim() && !selectedFile.value) ||
        !selectedChatId.value
    )
        return;

    const formData = new FormData();
    formData.append("chat_id", selectedChatId.value);
    formData.append("receiver_id", selectedUserId.value);

    if (selectedFile.value) {
        formData.append("file", selectedFile.value);
        formData.append(
            "type",
            selectedFile.value.type.startsWith("image/") ? "image" : "file"
        );
    } else {
        formData.append("message", newMessage.value);
        formData.append("type", "text");
    }

    axios
        .post(route("messages.send"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            // Add the new message to the list
            messages.value.push(response.data.message);
            newMessage.value = "";
            clearAttachment();

            // Scroll to bottom of messages with smooth animation
            scrollToBottom(true);

            // Update the latest message in the chat list
            const chatIndex = chats.value.findIndex(
                (c) => c.id === selectedChatId.value
            );
            if (chatIndex !== -1) {
                chats.value[chatIndex].latest_message = response.data.message;
            }
        })
        .catch((error) => {
            console.error("Error sending message:", error);
        });
}

// Check if user is at the bottom of the messages container
function isAtBottom() {
    const container = document.querySelector(".messages-container");
    if (!container) return true;

    const threshold = 100; // pixels from bottom to consider "at bottom"
    return (
        container.scrollHeight - container.scrollTop - container.clientHeight <
        threshold
    );
}

// Optimized scroll to bottom function
function scrollToBottom(smooth = false) {
    requestAnimationFrame(() => {
        const container = document.querySelector(".messages-container");
        if (container) {
            if (smooth) {
                container.scrollTo({
                    top: container.scrollHeight,
                    behavior: "smooth",
                });
            } else {
                container.scrollTop = container.scrollHeight;
            }
        }
    });
}

// Setup Echo listeners for real-time updates
function setupEchoListeners() {
    // Make sure Echo is available
    if (!window.Echo) {
        console.error(
            "Echo is not available. Real-time messaging will not work."
        );
        return;
    }

    // Try to reconnect if not connected
    if (window.Echo.connector.pusher.connection.state !== "connected") {
        console.log("Echo not connected, attempting to connect...");
        window.Echo.connector.pusher.connect();
    }

    // Listen for new messages on all chats
    window.Echo.private(`user.${page.props.auth.user.id}`).listen(
        "MessageSent", // Changed from "NewMessage" to "MessageSent" to match the backend event class name
        (e) => {
            console.log("New message received:", e);

            try {
                // Ensure we have the required data
                if (!e.chat_id || !e.message) {
                    console.error("Invalid message data received:", e);
                    return;
                }

                // Update unread count for the chat
                if (e.chat_id !== selectedChatId.value) {
                    unreadCounts.value[e.chat_id] =
                        (unreadCounts.value[e.chat_id] || 0) + 1;
                }

                // Add message to the current chat if it's open
                if (e.chat_id === selectedChatId.value) {
                    // Check if user was at bottom before adding new message
                    const shouldScroll = isAtBottom();

                    // Make sure the message object has all required properties
                    if (typeof e.message === "object" && e.message !== null) {
                        messages.value.push(e.message);
                        markAsSeen(e.chat_id);

                        // Only scroll if user was already at the bottom
                        if (shouldScroll) {
                            scrollToBottom(true);
                        }
                    } else {
                        console.error("Invalid message object:", e.message);
                    }
                }
            } catch (error) {
                console.error("Error processing received message:", error);
            }

            // Update the latest message in chat list
            const chatIndex = chats.value.findIndex((c) => c.id === e.chat_id);
            if (chatIndex !== -1) {
                chats.value[chatIndex].latest_message = e.message;
            } else {
                // If this is a new chat, refresh the list
                fetchRecentChats();
            }
        }
    );

    // Listen for message status updates
    window.Echo.private(`user.${page.props.auth.user.id}`).listen(
        "MessageStatusUpdated",
        (e) => {
            // Update message status in the UI
            const messageIndex = messages.value.findIndex(
                (m) => m.id === e.message_id
            );
            if (messageIndex !== -1) {
                messages.value[messageIndex].status = e.status;
            }
        }
    );
}
</script>

<template>
    <AppLayout title="Messages">
        <div class="chat-container" :class="{ 'mobile-view': isMobile }">
            <!-- Left sidebar - chats/users list -->
            <div class="sidebar" v-if="!isMobile || showChatList">
                <div class="search-bar">
                    <input
                        type="text"
                        placeholder="Search users or messages..."
                        v-model="searchQuery"
                        @input="searchUsers"
                    />
                    <button
                        v-if="searchQuery"
                        @click="clearSearch"
                        class="clear-btn"
                    >
                        ×
                    </button>
                </div>

                <div class="conversation-list" v-if="loading">
                    <div class="loading-spinner">Loading...</div>
                </div>

                <!-- Search results -->
                <div class="conversation-list" v-else-if="users.length > 0">
                    <div class="search-results-header">Search Results</div>
                    <div
                        v-for="user in users"
                        :key="user.id"
                        class="user-item"
                        @click="startNewChat(user.id)"
                    >
                        <div class="avatar">
                            {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="user-details">
                            <div class="user-name">{{ user.name }}</div>
                            <div class="user-email">{{ user.email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Recent chats -->
                <div
                    class="conversation-list"
                    v-else-if="sortedChats.length > 0"
                >
                    <div
                        v-for="chat in sortedChats"
                        :key="chat.id"
                        :class="[
                            'chat-item',
                            { active: selectedChatId === chat.id },
                        ]"
                        @click="openChat(chat.id, chat.other_user.id)"
                    >
                        <div class="avatar">
                            {{ chat.other_user.name.charAt(0).toUpperCase() }}
                        </div>
                        <div class="chat-details">
                            <div class="chat-header">
                                <span class="chat-name">{{
                                    chat.other_user.name
                                }}</span>
                                <span
                                    class="chat-time"
                                    v-if="chat.latest_message"
                                >
                                    {{
                                        formatTime(
                                            chat.latest_message.created_at
                                        )
                                    }}
                                </span>
                            </div>
                            <div class="chat-preview">
                                <div
                                    class="last-message"
                                    v-if="chat.latest_message"
                                >
                                    <span
                                        v-if="
                                            chat.latest_message.type === 'text'
                                        "
                                        >{{ chat.latest_message.message }}</span
                                    >
                                    <span
                                        v-else-if="
                                            chat.latest_message.type === 'image'
                                        "
                                        >🖼️ Image</span
                                    >
                                    <span
                                        v-else-if="
                                            chat.latest_message.type === 'file'
                                        "
                                        >📎 File</span
                                    >
                                </div>
                                <div
                                    class="unread-badge"
                                    v-if="unreadCounts[chat.id]"
                                >
                                    {{ unreadCounts[chat.id] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="empty-state" v-else>
                    <p>No conversations yet</p>
                    <p class="empty-hint">Search for users to start chatting</p>
                </div>
            </div>

            <!-- Right area - message display and input -->
            <div class="message-area" v-if="!isMobile || !showChatList">
                <div v-if="!selectedChatId" class="welcome-screen">
                    <div class="welcome-icon">💬</div>
                    <h2>Welcome to Messages</h2>
                    <p>
                        Select a conversation or search for a user to start
                        chatting
                    </p>
                </div>

                <template v-else>
                    <!-- Chat header -->
                    <div class="chat-header">
                        <div class="flex items-center">
                            <button
                                v-if="isMobile"
                                @click="backToList"
                                class="back-button"
                            >
                                &larr;
                            </button>
                            <div
                                class="chat-recipient"
                                v-if="
                                    chats.find((c) => c.id === selectedChatId)
                                "
                            >
                                {{
                                    chats.find((c) => c.id === selectedChatId)
                                        .other_user.name
                                }}
                            </div>
                        </div>

                        <!-- Dark mode toggle -->
                        <button
                            @click="toggleDarkMode"
                            class="dark-mode-toggle"
                            aria-label="Toggle dark mode"
                        >
                            <svg
                                v-if="isDarkMode"
                                class="w-5 h-5 text-yellow-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3v1m0 16v1m-8-8H3m16 0h1m-2.636 5.364l-.707-.707m-9.9 0l-.707.707M4.636 6.364l.707-.707m12.728 0l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z"
                                />
                            </svg>
                            <svg
                                v-else
                                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 1020.354 15.354z"
                                />
                            </svg>
                        </button>
                    </div>

                    <!-- Messages display -->
                    <div class="messages-container">
                        <div v-if="loading" class="loading-messages">
                            Loading messages...
                        </div>
                        <div
                            v-else-if="messages.length === 0"
                            class="no-messages"
                        >
                            No messages yet. Start the conversation!
                        </div>
                        <template v-else>
                            <div
                                v-for="message in messages"
                                :key="message.id"
                                :class="[
                                    'message',
                                    message.sender_id ===
                                    page.props.auth.user.id
                                        ? 'sent'
                                        : 'received',
                                ]"
                            >
                                <div class="message-content">
                                    <!-- Text message -->
                                    <div
                                        v-if="message.type === 'text'"
                                        class="message-text"
                                    >
                                        {{ message.message }}
                                    </div>

                                    <!-- Image message -->
                                    <div
                                        v-else-if="message.type === 'image'"
                                        class="message-image"
                                    >
                                        <img
                                            :src="message.file_url"
                                            alt="Image"
                                            @click="openImage(message.file_url)"
                                        />
                                    </div>

                                    <!-- File message -->
                                    <div
                                        v-else-if="message.type === 'file'"
                                        class="message-file"
                                    >
                                        <a
                                            :href="message.file_url"
                                            target="_blank"
                                            download
                                        >
                                            <span class="file-icon">📎</span>
                                            <span class="file-name">{{
                                                message.file_name
                                            }}</span>
                                        </a>
                                    </div>

                                    <div class="message-meta">
                                        <span class="message-time">{{
                                            formatTime(message.created_at)
                                        }}</span>
                                        <span
                                            v-if="
                                                message.sender_id ===
                                                page.props.auth.user.id
                                            "
                                            class="message-status"
                                        >
                                            <!-- Status indicators -->
                                            <span
                                                v-if="message.status === 'seen'"
                                                >✓✓</span
                                            >
                                            <span
                                                v-else-if="
                                                    message.status ===
                                                    'delivered'
                                                "
                                                >✓✓</span
                                            >
                                            <span v-else>✓</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Attachment preview area -->
                    <div v-if="attachmentPreview" class="attachment-preview">
                        <div class="preview-content">
                            <img
                                v-if="
                                    selectedFile &&
                                    selectedFile.type.startsWith('image/')
                                "
                                :src="attachmentPreview"
                                class="image-preview"
                            />
                            <div v-else class="file-preview">
                                <span class="file-icon">📎</span>
                                <span class="file-name">{{
                                    attachmentPreview
                                }}</span>
                            </div>
                        </div>
                        <button
                            @click="clearAttachment"
                            class="clear-attachment"
                        >
                            ×
                        </button>
                    </div>

                    <!-- Message input area -->
                    <div class="message-input-container">
                        <label for="file-upload" class="attachment-button">
                            <AttachmentIcon />
                        </label>
                        <input
                            type="file"
                            id="file-upload"
                            ref="fileInput"
                            class="file-input"
                            @change="handleFileSelect"
                        />

                        <input
                            type="text"
                            placeholder="Type a message..."
                            v-model="newMessage"
                            @keyup.enter="sendMessage"
                            :disabled="!!selectedFile"
                        />

                        <button @click="sendMessage" class="send-button">
                            <SendIcon />
                        </button>
                    </div>
                </template>
            </div>
        </div>
        <!-- Image viewer modal -->
        <div
            v-if="imageViewerUrl"
            class="image-viewer-modal"
            @click="closeImageViewer"
        >
            <div class="image-viewer-content" @click.stop>
                <button class="close-viewer" @click="closeImageViewer">
                    ×
                </button>
                <img :src="imageViewerUrl" alt="Full size image" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
:root {
    --primary-color: #fe4d01;
    --primary-dark: #e04400;
    --text-light: #fff;
    --text-dark: #000;
    --bg-light: #fff;
    --bg-secondary: #f5f7fb;
    --border-color: #e6e6e6;
}

/* Dark mode toggle button */
.dark-mode-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
}

.dark-mode-toggle:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

:root.dark {
    --primary-color: #fe4d01;
    --primary-dark: #ff6a2c;
    --text-light: #fff;
    --text-dark: #e0e0e0;
    --bg-light: #1e1e1e;
    --bg-secondary: #121212;
    --border-color: #2d2d2d;
}

.chat-container {
    display: grid;
    grid-template-columns: 350px 1fr;
    height: calc(100vh - 80px);
    background-color: var(--bg-secondary);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 16px;
    transition: background-color 0.3s ease, color 0.3s ease,
        border-color 0.3s ease;
}

/* Mobile view adjustments */
.chat-container.mobile-view {
    grid-template-columns: 1fr;
}

/* Back button for mobile */
.back-button {
    margin-right: 12px;
    background: none;
    border: none;
    font-size: 18px;
    color: var(--primary-color);
    cursor: pointer;
}

/* Sidebar styles */
.sidebar {
    display: flex;
    flex-direction: column;
    background-color: var(--bg-light);
    border-right: 1px solid var(--border-color);
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.search-bar {
    padding: 16px;
    position: relative;
    border-bottom: 1px solid var(--border-color);
}

.search-bar input {
    width: 100%;
    padding: 10px 16px;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    background-color: #f5f5f5;
    font-size: 14px;
    outline: none;
}

.search-bar input:focus {
    border-color: var(--primary-color);
    background-color: var(--bg-light);
}

.clear-btn {
    position: absolute;
    right: 26px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 18px;
    color: #888;
    cursor: pointer;
}

.conversation-list {
    flex: 1;
    overflow-y: auto;
}

.search-results-header {
    padding: 12px 16px;
    color: var(--primary-color);
    font-weight: 600;
    background-color: #f8f8f8;
    font-size: 14px;
}

.chat-item,
.user-item {
    display: flex;
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
    transition: background-color 0.2s;
}

.chat-item:hover,
.user-item:hover {
    background-color: #f5f5f5;
}

.chat-item.active {
    background-color: rgba(254, 77, 1, 0.1);
}

.avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: var(--text-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 600;
    margin-right: 12px;
    flex-shrink: 0;
}

.chat-details,
.user-details {
    flex: 1;
    min-width: 0;
}

.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}

.chat-name,
.user-name {
    font-weight: 600;
    font-size: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat-time {
    font-size: 12px;
    color: #888;
    white-space: nowrap;
}

.chat-preview {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.last-message {
    color: #666;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
}

.unread-badge {
    background-color: var(--primary-color);
    color: var(--text-light);
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    padding: 0 4px;
}

.user-email {
    font-size: 13px;
    color: #888;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #888;
    padding: 32px;
    text-align: center;
}

.empty-hint {
    font-size: 14px;
    margin-top: 8px;
    color: #aaa;
}

/* Message area styles */
.message-area {
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    overflow: hidden; /* Prevent content from overflowing */
}

.chat-header {
    padding: 16px;
    border-bottom: 1px solid var(--border-color);
    background-color: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.chat-recipient {
    font-weight: 600;
    font-size: 16px;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    background-color: var(--bg-secondary);
    will-change: transform; /* Optimize scrolling performance */
    overscroll-behavior: contain; /* Prevent scroll chaining */
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
    height: calc(100% - 120px); /* Fixed height calculation */
    min-height: 200px; /* Minimum height to ensure visibility */
    scrollbar-width: thin; /* Thinner scrollbar for Firefox */
    scrollbar-color: rgba(0, 0, 0, 0.2) transparent; /* Scrollbar color for Firefox */
}

/* Webkit scrollbar styling */
.messages-container::-webkit-scrollbar {
    width: 6px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

.message {
    max-width: 70%;
    margin-bottom: 8px;
    position: relative;
}

.message.sent {
    align-self: flex-end;
}

.message.received {
    align-self: flex-start;
}

.message-content {
    padding: 10px 16px;
    border-radius: 16px;
    position: relative;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.message.sent .message-content {
    background-color: rgba(254, 77, 1, 0.15);
    border-top-right-radius: 4px;
    color: var(--text-dark);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.message.received .message-content {
    background-color: var(--bg-light);
    border-top-left-radius: 4px;
    color: var(--text-dark);
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.message-text {
    word-wrap: break-word;
    font-size: 14px;
    line-height: 1.4;
}

.message-meta {
    display: flex;
    justify-content: flex-end;
    gap: 4px;
    margin-top: 4px;
    font-size: 11px;
    color: #888;
}

.message-image img {
    max-width: 250px;
    max-height: 250px;
    border-radius: 8px;
    cursor: pointer;
}

.message-file {
    display: flex;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.05);
    padding: 8px;
    border-radius: 8px;
}

.message-file a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: var(--primary-color);
}

.file-icon {
    font-size: 20px;
    margin-right: 8px;
}

.welcome-screen {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #888;
    padding: 32px;
    text-align: center;
    background-color: var(--bg-secondary);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.welcome-icon {
    font-size: 64px;
    margin-bottom: 24px;
}

.no-messages {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #888;
    font-size: 14px;
}

.loading-spinner,
.loading-messages {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #888;
}

/* Message input area */
.message-input-container {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background-color: var(--bg-light);
    border-top: 1px solid var(--border-color);
    gap: 8px;
    z-index: 20; /* Higher z-index to ensure it stays on top */
    position: sticky;
    bottom: 0;
    width: 100%;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    min-height: 64px; /* Ensure minimum height */
    transition: all 0.2s ease; /* Smooth transitions */
    flex-shrink: 0; /* Prevent shrinking */
    transition: background-color 0.3s ease, border-color 0.3s ease,
        box-shadow 0.3s ease;
}

.message-input-container input[type="text"] {
    flex: 1;
    padding: 10px 16px;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    background-color: #f5f5f5;
    font-size: 14px;
    outline: none;
}

.message-input-container input[type="text"]:focus {
    border-color: var(--primary-color);
    background-color: var(--bg-light);
}

.file-input {
    display: none;
}

.attachment-button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: var(--primary-color);
    cursor: pointer;
    transition: background-color 0.2s;
}

.attachment-button:hover {
    background-color: #f0f0f0;
}

.send-button {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 40px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: var(--text-light);
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    flex-shrink: 0; /* Prevent shrinking */
}

.send-button:hover {
    background-color: var(--primary-dark);
    transform: scale(1.05);
}

.send-button:active {
    transform: scale(0.95);
}

/* Attachment preview */
.attachment-preview {
    padding: 8px 16px;
    background-color: var(--bg-light);
    border-top: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 15; /* Below input but above messages */
}

.preview-content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.image-preview {
    max-height: 60px;
    max-width: 60px;
    border-radius: 4px;
}

.file-preview {
    display: flex;
    align-items: center;
    background-color: #f5f5f5;
    padding: 6px 12px;
    border-radius: 4px;
    gap: 8px;
}

.clear-attachment {
    background: none;
    border: none;
    font-size: 18px;
    color: #888;
    cursor: pointer;
}

/* Media queries for mobile responsiveness */
@media (max-width: 767px) {
    .chat-container {
        margin: 0;
        height: 100vh;
        border-radius: 0;
    }

    .message {
        max-width: 85%;
    }

    .message-image img {
        max-width: 200px;
        max-height: 200px;
    }
}

/* Image viewer modal */
.image-viewer-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(5px);
    animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.image-viewer-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}

.image-viewer-content img {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 4px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: scaleIn 0.3s ease;
}

@keyframes scaleIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.close-viewer {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: white;
    font-size: 30px;
    cursor: pointer;
    z-index: 1001;
    transition: transform 0.2s ease, color 0.2s ease;
}

.close-viewer:hover {
    transform: scale(1.1);
    color: var(--primary-color);
}

/* Dark mode styles */
:root.dark .search-bar input,
:root.dark .message-input-container input[type="text"] {
    background-color: #2d2d2d;
    color: var(--text-light);
    border-color: #3d3d3d;
}

:root.dark .chat-item:hover,
:root.dark .user-item:hover {
    background-color: #2a2a2a;
}

:root.dark .chat-item.active {
    background-color: rgba(254, 77, 1, 0.2);
}

:root.dark .message.received .message-content {
    background-color: #2d2d2d;
    color: var(--text-light);
}

:root.dark .message.sent .message-content {
    background-color: rgba(254, 77, 1, 0.25);
    color: var(--text-light);
}

:root.dark .chat-name,
:root.dark .user-name,
:root.dark .chat-recipient {
    color: var(--text-light);
}

:root.dark .last-message,
:root.dark .welcome-screen,
:root.dark .no-messages,
:root.dark .loading-spinner,
:root.dark .loading-messages,
:root.dark .message-text {
    color: #aaa;
}

:root.dark .file-preview {
    background-color: #2d2d2d;
}

:root.dark .welcome-screen {
    background-color: #1a1a1a;
}

:root.dark .dark-mode-toggle:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

:root.dark .attachment-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

:root.dark .message-meta {
    color: #777;
}

:root.dark .chat-header,
:root.dark .message-input-container {
    background-color: #1a1a1a;
    border-color: #333;
}

:root.dark .message-input-container {
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
}

:root.dark .sidebar {
    background-color: #1a1a1a;
    border-color: #333;
}

:root.dark .chat-container {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
</style>
