<template>
    <div
        class="p-8 mb-12 bg-white border border-gray-200 shadow-sm dark:bg-gray-900 rounded-2xl dark:border-gray-700"
    >
        <div class="flex items-center mb-8">
            <div
                class="flex items-center justify-center w-12 h-12 mr-4 text-white bg-red-500 rounded-xl"
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
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    />
                </svg>
            </div>
            <div>
                <h2
                    class="mb-1 text-2xl font-bold text-gray-900 dark:text-white"
                >
                    Error Handling
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                    How to handle common API errors and troubleshoot issues
                </p>
            </div>
        </div>
        <div class="space-y-6">
            <div
                class="p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
            >
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                    Common HTTP Status Codes
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800">
                                <th class="p-3 border-b dark:border-gray-700">
                                    Status Code
                                </th>
                                <th class="p-3 border-b dark:border-gray-700">
                                    Description
                                </th>
                                <th class="p-3 border-b dark:border-gray-700">
                                    Resolution
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-3">
                                    <code
                                        class="px-2 py-1 text-red-600 bg-red-100 rounded dark:bg-red-900 dark:text-red-200"
                                        >401</code
                                    >
                                </td>
                                <td class="p-3">
                                    Unauthorized - Invalid API token
                                </td>
                                <td class="p-3">
                                    Check your API token and ensure it's
                                    correctly included in the request header
                                </td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-3">
                                    <code
                                        class="px-2 py-1 text-red-600 bg-red-100 rounded dark:bg-red-900 dark:text-red-200"
                                        >404</code
                                    >
                                </td>
                                <td class="p-3">
                                    Not Found - Endpoint does not exist
                                </td>
                                <td class="p-3">Verify the API endpoint URL</td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <td class="p-3">
                                    <code
                                        class="px-2 py-1 text-red-600 bg-red-100 rounded dark:bg-red-900 dark:text-red-200"
                                        >500</code
                                    >
                                </td>
                                <td class="p-3">Internal Server Error</td>
                                <td class="p-3">
                                    Contact support if the issue persists
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div
                class="p-6 bg-white border border-gray-200 dark:bg-gray-900 rounded-xl dark:border-gray-700"
            >
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                    Debugging Tips
                </h3>
                <ul
                    class="text-gray-600 list-disc list-inside dark:text-gray-300"
                >
                    <li>Check the browser console for error messages</li>
                    <li>
                        Use network tools to inspect API requests and responses
                    </li>
                    <li>Ensure CORS is configured correctly on your server</li>
                </ul>
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
