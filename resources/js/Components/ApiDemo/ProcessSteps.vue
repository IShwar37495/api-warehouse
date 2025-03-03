<template>
    <div class="mb-16">
        <h2
            class="mb-8 text-3xl font-bold text-center text-gray-900 dark:text-white"
        >
            Integration Process
        </h2>
        <div class="grid gap-4 md:grid-cols-3">
            <!-- Step 1 -->
            <div
                class="p-6 transition-all bg-white shadow-sm rounded-xl hover:shadow-md dark:bg-gray-800"
            >
                <div class="flex items-center mb-4">
                    <div
                        class="flex items-center justify-center w-10 h-10 mr-4 text-white bg-[#FE4D01] rounded-full"
                    >
                        1
                    </div>
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Authentication
                    </h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">
                    Obtain your API key from the dashboard and authenticate
                    using Bearer token
                </p>
            </div>
            <!-- Step 2 -->
            <div
                class="p-6 transition-all bg-white shadow-sm rounded-xl hover:shadow-md dark:bg-gray-800"
            >
                <div class="flex items-center mb-4">
                    <div
                        class="flex items-center justify-center w-10 h-10 mr-4 text-white bg-[#FE4D01] rounded-full"
                    >
                        2
                    </div>
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Implementation
                    </h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">
                    Follow the code examples below for your preferred framework
                </p>
            </div>
            <!-- Step 3 -->
            <div
                class="p-6 transition-all bg-white shadow-sm rounded-xl hover:shadow-md dark:bg-gray-800"
            >
                <div class="flex items-center mb-4">
                    <div
                        class="flex items-center justify-center w-10 h-10 mr-4 text-white bg-[#FE4D01] rounded-full"
                    >
                        3
                    </div>
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        Integration
                    </h3>
                </div>
                <p class="text-gray-600 dark:text-gray-300">
                    Test your integration and deploy to your production
                    environment
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
// No script needed for this component
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
