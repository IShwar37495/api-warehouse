<template>
    <div
        id="authentication"
        class="p-8 mb-12 bg-white shadow-sm dark:bg-gray-800 rounded-2xl"
    >
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
                    All API requests require authentication via Bearer token
                </p>
            </div>
        </div>
        <div class="space-y-6">
            <div
                class="relative p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
            >
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                    Simple Integration
                </h3>
                <div class="relative">
                    <pre
                        class="p-6 overflow-x-auto font-mono text-sm text-gray-900 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200"
                    >
<code>
fetch("https://api-warehouse-production-6639.up.railway.app/api/v1/countries", {
    headers: {
        Authorization: "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
    }
})
.then(response => response.json())
.then(data => console.log(data)) // Handle the data as needed
.catch(error => console.error("Error:", error));
</code>
          </pre>
                    <button
                        @click="copyAuthHeader"
                        class="absolute p-2 text-gray-500 transition-colors bg-gray-100 rounded-lg top-3 right-3 hover:text-[#FE4D01] dark:bg-gray-800 dark:text-gray-400 dark:hover:text-white"
                        title="Copy to clipboard"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-4m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                            />
                        </svg>
                    </button>
                    <div
                        v-if="copySuccess"
                        class="absolute px-2 py-1 text-sm text-white bg-green-500 rounded-md top-3 right-12"
                    >
                        Copied!
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const copySuccess = ref(false);

const copyAuthHeader = () => {
    navigator.clipboard.writeText(`{
    "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
  }`);
    copySuccess.value = true;
    setTimeout(() => {
        copySuccess.value = false;
    }, 2000);
};
</script>
