<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

<template>
    <div
        id="authentication"
        class="p-8 mb-12 bg-white shadow-sm dark:bg-gray-800 rounded-2xl"
    >
        <!-- Header Section -->
        <div class="flex items-center mb-8">
            <div
                class="flex items-center justify-center w-12 h-12 mr-4 text-white bg-[#FE4D01] rounded-xl"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                </svg>
            </div>
            <div>
                <h2
                    class="mb-1 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    Authentication
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                    All API requests require authentication via Bearer token and
                    Client ID
                </p>
            </div>
        </div>

        <!-- API Examples Section -->
        <div class="space-y-6">
            <!-- Token Info Section -->
            <div
                class="p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
            >
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                    Find Your Bearer Token
                </h3>
                <a
                    href="/dashboard/api-keys"
                    class="inline-flex items-center px-4 py-2 text-white transition-colors rounded-lg bg-[#FE4D01] hover:bg-orange-600"
                >
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                        />
                    </svg>
                    How to get your Bearer Token
                </a>
            </div>

            <!-- Client ID Section - Enhanced and Fixed -->
            <div
                class="p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
            >
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                    Here is your Client ID
                </h3>

                <!-- Client ID Input Group with enhanced styling -->
                <div class="relative mb-2">
                    <div class="flex overflow-hidden rounded-lg shadow-sm">
                        <input
                            :type="showClientId ? 'text' : 'password'"
                            class="w-full p-3 pr-24 text-gray-900 bg-gray-100 border-0 rounded-l-lg focus:ring-2 focus:ring-orange-500 dark:bg-gray-800 dark:text-white"
                            :value="showClientId ? clientId : maskedClientId"
                            readonly
                            aria-label="Your Client ID"
                        />

                        <!-- Button Group with better styling -->
                        <div
                            class="flex items-center border-l border-gray-200 rounded-r-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
                        >
                            <!-- Show/Hide Button with eye icon -->
                            <button
                                @click="showClientId = !showClientId"
                                class="h-full px-3 text-gray-500 transition-colors hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600"
                                :title="
                                    showClientId
                                        ? 'Hide client ID'
                                        : 'Show client ID'
                                "
                                type="button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    v-if="!showClientId"
                                >
                                    <path
                                        d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"
                                    ></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    v-else
                                >
                                    <path
                                        d="M9.88 9.88a3 3 0 1 0 4.24 4.24"
                                    ></path>
                                    <path
                                        d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"
                                    ></path>
                                    <path
                                        d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"
                                    ></path>
                                    <line x1="2" x2="22" y1="2" y2="22"></line>
                                </svg>
                            </button>

                            <!-- Divider -->
                            <div
                                class="w-px bg-gray-300 h-2/3 dark:bg-gray-600"
                            ></div>

                            <!-- Copy Button -->
                            <button
                                @click="copyToClipboard"
                                class="h-full px-3 text-gray-500 transition-colors hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-600"
                                title="Copy to clipboard"
                                type="button"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        width="14"
                                        height="14"
                                        x="8"
                                        y="8"
                                        rx="2"
                                        ry="2"
                                    ></rect>
                                    <path
                                        d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Copy Success Message with improved animation -->
                <transition name="fade">
                    <div
                        v-if="copySuccessVisible"
                        class="flex items-center p-2 mt-2 text-sm text-green-600 rounded-lg dark:text-green-400 bg-green-50 dark:bg-green-900/20"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 mr-1"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                        Copied to clipboard successfully!
                    </div>
                </transition>
            </div>

            <!-- Map through all available endpoints -->
            <ApiExample
                v-for="(endpoint, index) in apiEndpoints"
                :key="index"
                :title="endpoint.title"
                :code="endpoint.code"
                @code-copied="showCopySuccess"
            />
        </div>

        <!-- Copy success notification -->
        <transition name="fade">
            <div
                v-if="copySuccess"
                class="fixed px-4 py-2 text-sm text-white bg-green-500 rounded-md shadow-md right-4 bottom-4"
            >
                Copied to clipboard!
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import ApiExample from "@/Components/AuthApiDemo/ApiExample.vue";
import { usePage } from "@inertiajs/vue3";

// Shared state
const copySuccess = ref(false);
const showClientId = ref(false);
const copySuccessVisible = ref(false);
const page = usePage();

// API endpoints configuration
const apiEndpoints = ref([
    {
        title: "Register a user",
        code: `fetch("https://api-warehouse-production-6639.up.railway.app/api/v1/register-user", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",// Replace with actual Bearer token
        "Client-ID": "7801cfc9-b888-48d6-9ca4-84712608931f" // Replace with actual Client ID
    },
    body: JSON.stringify({
        email: "john.doe@example.com",
        password: "securePassword123",
        name: "John Doe",  // Optional field
        phone: "+1234567890", // Optional
        address: "123 Main Street", // Optional
        company: "Doe Enterprises", // Optional
        age: 30 // Optional
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error("Error:", error));`,
    },
    {
        title: "Login a user",
        code: `fetch("https://api-warehouse-production-6639.up.railway.app/api/v1/login-user", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...", // Client's token
        "Client-ID": "7801cfc9-b888-48d6-9ca4-84712608931f" // Replace with actual Client ID
    },
    body: JSON.stringify({
        email: "john.doe@example.com",
        password: "securePassword123"
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error("Error:", error));`,
    },
    // Add more endpoints here as needed
]);

// Show copy success notification
const showCopySuccess = () => {
    copySuccess.value = true;
    setTimeout(() => {
        copySuccess.value = false;
    }, 2000);
};

// Computed property for client ID
const clientId = computed(() => {
    return page.props.auth?.user?.client_id || page.props.clientId || "N/A";
});

// Computed property for masked client ID
const maskedClientId = computed(() => {
    const id = clientId.value;
    if (id === "N/A" || id.length <= 4) return id;

    const visiblePart = id.slice(-4); // Last 4 characters
    const hiddenPart = "•".repeat(id.length - 4); // Mask the rest

    return hiddenPart + visiblePart;
});

// Function to copy to clipboard
function copyToClipboard() {
    const textToCopy = clientId.value;

    if (textToCopy === "N/A") return;

    navigator.clipboard
        .writeText(textToCopy)
        .then(() => {
            copySuccessVisible.value = true;
            setTimeout(() => {
                copySuccessVisible.value = false;
            }, 2000);
        })
        .catch((err) => {
            console.error("Failed to copy: ", err);
        });
}
</script>
