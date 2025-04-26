import { defineStore } from "pinia";
import { io } from "socket.io-client";
import axios from "axios";

export const useChatStore = defineStore("chat", {
  state: () => ({
    socket: null,
    messages: [],
    selectedUser: null,
  }),

  actions: {
    async connectSocket() {
      try {
        // Fetch the access token
        const response = await axios.get("http://localhost:8000/user/chat/auth/token", { withCredentials: true });
        const token = response.data.data;

        // Initialize WebSocket connection
        this.socket = io("http://localhost:3000", { auth: { token } });

        this.socket.on("connect", () => console.log("✅ WebSocket Connected"));
        this.socket.on("disconnect", () => console.warn("⚠️ WebSocket Disconnected"));

        // Listen for new messages
        this.socket.on("message", (msg) => {
        //   if (this.selectedUser && msg.sender_id === this.selectedUser.id) {
            this.messages.push(msg);
        //   }
        });
      } catch (error) {
        console.error("❌ Failed to connect WebSocket:", error);
      }
    },

    sendMessage(message) {
      if (!this.socket || !message.trim()) return;

      const newMessage = {
        sender_id: 1, // Replace with actual logged-in user ID
        receiver_id: this.selectedUser.id,
        message,
      };

      this.socket.emit("sendMessage", newMessage);
      this.messages.push(newMessage);
    },

    setSelectedUser(user) {
      this.selectedUser = user;
      this.fetchMessages(user.id);
    },

    async fetchMessages(receiverId) {
      try {
        // const response = await axios.get(`http://localhost:8000/api/messages/${receiverId}`);
        const response="no chat";
        // this.messages = response.data;
        this.messages = [];
      } catch (error) {
        console.error("❌ Failed to fetch messages:", error);
      }
    },
  },
});
