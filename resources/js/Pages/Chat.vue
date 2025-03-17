<template>
    <div>
      <h2>Chat</h2>
      <input v-model="message" placeholder="Type a message..." />
      <button @click="sendMessage">Send</button>
      <ul>
        <li v-for="msg in messages" :key="msg.id">
          {{ msg.sender }}: {{ msg.message }}
        </li>
      </ul>
    </div>
  </template>

  <script>
import { io } from "socket.io-client";

export default {
  data() {
    return {
      socket: null,
      message: "",
      messages: [],
    };
  },
  mounted() {
    this.socket = io("http://localhost:3000", {
      withCredentials: false,
    });

    this.socket.on("connect", () => {
      console.log("✅ WebSocket connected");
    });

    this.socket.on("disconnect", () => {
      console.warn("⚠️ WebSocket disconnected");
    });

    this.socket.on("connect_error", (err) => {
      console.error("❌ WebSocket connection error:", err);
    });

    this.socket.on("newMessage", (msg) => {
      this.messages.push(msg);
    });
  },
  methods: {
    sendMessage() {
      this.socket.emit("sendMessage", { receiver: "someone@example.com", message: this.message });
      this.message = "";
    },
  },
};

  </script>
