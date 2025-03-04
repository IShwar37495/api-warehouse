<template>
    <div class="p-8 mb-12 bg-white border border-gray-200 shadow-md dark:bg-gray-900 rounded-2xl dark:border-gray-800 dark:shadow-gray-950/30 backdrop-blur-sm">
      <!-- Header Section with Animated Elements -->
      <div class="flex flex-col md:flex-row items-start md:items-center mb-8 relative">
        <!-- Animated Error Icon Container -->
        <div class="flex items-center justify-center w-16 h-16 mr-5 mb-4 md:mb-0 text-white overflow-hidden rounded-2xl bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-800 shadow-lg transform transition-all duration-300 hover:scale-105">
          <div class="relative">
            <!-- Pulsing background circle -->
            <div class="absolute inset-0 rounded-full bg-white/20 animate-ping opacity-75 w-8 h-8 mx-auto my-auto"></div>

            <svg class="w-8 h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
        </div>

        <!-- Title Section with Highlight Effects -->
        <div class="relative">
          <h2 class="mb-2 text-3xl font-extrabold text-gray-900 dark:text-white">
            Error <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-700 dark:from-red-400 dark:to-red-600">Handling</span>
          </h2>
          <p class="text-gray-600 dark:text-gray-300 max-w-lg">
            How to handle common API errors and troubleshoot issues efficiently
          </p>

          <!-- Decorative Element -->
          <div class="absolute -right-4 -top-4 w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 blur-xl hidden md:block"></div>
        </div>

        <!-- Desktop Decorative Element -->
        <div class="hidden lg:block absolute right-0 top-2">
          <div class="px-3 py-1 text-xs font-mono text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-full bg-gray-50 dark:bg-gray-800">
            try { await api.connect() } catch (error) { handleError(error) }
          </div>
        </div>
      </div>

      <!-- Main Content Section -->
      <div class="space-y-6">
        <!-- HTTP Status Codes Card -->
        <div class="p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800/50 rounded-xl dark:border-gray-700 transition-all duration-300 hover:shadow-md dark:hover:bg-gray-800/70">
          <div class="flex items-center mb-5">
            <div class="w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0a6 6 0 11-12 0 6 6 0 0112 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
              Common HTTP Status Codes
            </h3>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 text-gray-700 dark:text-gray-300">
                  <th class="p-4 rounded-l-lg font-medium">Status Code</th>
                  <th class="p-4 font-medium">Description</th>
                  <th class="p-4 rounded-r-lg font-medium">Resolution</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                  <td class="p-4">
                    <div class="flex items-center">
                      <div class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></div>
                      <code class="px-3 py-1 text-red-600 bg-red-100 rounded-lg font-mono dark:bg-red-900/30 dark:text-red-300">401</code>
                    </div>
                  </td>
                  <td class="p-4 font-medium text-gray-700 dark:text-gray-300">
                    Unauthorized - Invalid API token
                  </td>
                  <td class="p-4 text-gray-600 dark:text-gray-400">
                    Check your API token and ensure it's correctly included in the request header
                  </td>
                </tr>
                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                  <td class="p-4">
                    <div class="flex items-center">
                      <div class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></div>
                      <code class="px-3 py-1 text-red-600 bg-red-100 rounded-lg font-mono dark:bg-red-900/30 dark:text-red-300">404</code>
                    </div>
                  </td>
                  <td class="p-4 font-medium text-gray-700 dark:text-gray-300">
                    Not Found - Endpoint does not exist
                  </td>
                  <td class="p-4 text-gray-600 dark:text-gray-400">
                    Verify the API endpoint URL in your request
                  </td>
                </tr>
                <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                  <td class="p-4">
                    <div class="flex items-center">
                      <div class="w-2 h-2 rounded-full bg-red-500 mr-2 animate-pulse"></div>
                      <code class="px-3 py-1 text-red-600 bg-red-100 rounded-lg font-mono dark:bg-red-900/30 dark:text-red-300">500</code>
                    </div>
                  </td>
                  <td class="p-4 font-medium text-gray-700 dark:text-gray-300">
                    Internal Server Error
                  </td>
                  <td class="p-4 text-gray-600 dark:text-gray-400">
                    Contact support if the issue persists after retrying
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Debugging Tips Card -->
        <div class="p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800/50 rounded-xl dark:border-gray-700 transition-all duration-300 hover:shadow-md dark:hover:bg-gray-800/70">
          <div class="flex items-center mb-5">
            <div class="w-10 h-10 rounded-lg bg-[#FE4D01]/10 dark:bg-[#FE4D01]/20 flex items-center justify-center mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#FE4D01]" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.707 5.293a1 1 0 00-1.414 1.414l8 8a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 12.586l-7.293-7.293z" clip-rule="evenodd" />
            </svg>
        </div>

            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
              Debugging Tips
            </h3>
          </div>

          <ul class="space-y-3">
            <li class="flex items-start p-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg transition-colors">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#FE4D01]/10 dark:bg-[#FE4D01]/30 flex items-center justify-center mr-3">
                    <span class="text-[#FE4D01] font-semibold">1</span>
                </div>

              <div>
                <p class="font-medium text-gray-700 dark:text-gray-300">Check the browser console for error messages</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Open your browser's developer tools (F12) and look in the Console tab</p>
              </div>
            </li>
            <li class="flex items-start p-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg transition-colors">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#FE4D01]/10 dark:bg-[#FE4D01]/30 flex items-center justify-center mr-3">
                    <span class="text-[#FE4D01] font-semibold">2</span>
                </div>
              <div>
                <p class="font-medium text-gray-700 dark:text-gray-300">Use network tools to inspect API requests and responses</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Examine headers, status codes, and response bodies in the Network tab</p>
              </div>
            </li>
            <li class="flex items-start p-3 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-lg transition-colors">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#FE4D01]/10 dark:bg-[#FE4D01]/30 flex items-center justify-center mr-3">
                    <span class="text-[#FE4D01] font-semibold">3</span>
                </div>
              <div>
                <p class="font-medium text-gray-700 dark:text-gray-300">Ensure CORS is configured correctly on your server</p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Check for CORS-related errors and configure proper access headers</p>
              </div>
            </li>
          </ul>
        </div>

        <!-- New Section: Example Error Response -->
        <div class="p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800/50 rounded-xl dark:border-gray-700 transition-all duration-300 hover:shadow-md dark:hover:bg-gray-800/70">
          <div class="flex items-center mb-5">
            <div class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
              Example Error Response
            </h3>
          </div>

          <div class="rounded-lg overflow-hidden bg-gray-900 dark:bg-black">
            <div class="flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-900 border-b border-gray-700">
              <div class="flex space-x-1.5">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
              </div>
              <div class="ml-4 text-xs text-gray-400 font-mono">Response Body</div>
            </div>
            <div class="p-4 text-sm font-mono">
              <pre class="text-gray-300 dark:text-gray-400 leading-relaxed"><span class="text-pink-400">{</span>
    <span class="text-green-400">"error"</span><span class="text-gray-400">:</span> <span class="text-amber-400">{</span>
      <span class="text-green-400">"code"</span><span class="text-gray-400">:</span> <span class="text-blue-400">"unauthorized"</span><span class="text-gray-400">,</span>
      <span class="text-green-400">"message"</span><span class="text-gray-400">:</span> <span class="text-blue-400">"Invalid API key provided"</span><span class="text-gray-400">,</span>
      <span class="text-green-400">"status"</span><span class="text-gray-400">:</span> <span class="text-purple-400">401</span><span class="text-gray-400">,</span>
      <span class="text-green-400">"details"</span><span class="text-gray-400">:</span> <span class="text-amber-400">{</span>
        <span class="text-green-400">"suggestion"</span><span class="text-gray-400">:</span> <span class="text-blue-400">"Check your API credentials in the dashboard"</span>
      <span class="text-amber-400">}</span>
    <span class="text-amber-400">}</span>
  <span class="text-pink-400">}</span></pre>
            </div>
          </div>
        </div>

      </div>
    </div>
  </template>

