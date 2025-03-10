<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

// Define reactive variables
const activeTab = ref("overview");
const codeExample = ref("curl");
const tabs = [
  { id: "overview", label: "Overview" },
  { id: "getting-started", label: "Getting Started" },
  { id: "authentication", label: "Authentication" },
  { id: "endpoints", label: "API Endpoints" },
  { id: "examples", label: "Examples" }
];
</script>



<template>
    <AppLayout title="Auth Api Docs">
    <div class="documentation-container bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
      <!-- Header -->
      <header class="bg-gradient-to-r from-[#FE4D01] to-orange-500 dark:from-gray-900 dark:to-gray-800 text-white shadow-lg">
  <div class="max-w-6xl mx-auto px-6 py-12 text-center">
    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
      API Authentication Documentation
    </h1>
    <p class="mt-3 text-lg sm:text-xl text-white/90">
      Learn how to authenticate and manage users with our API
    </p>
  </div>
</header>

      <!-- Main content -->
      <div class="max-w-6xl mx-auto px-4 py-8 w-full">
        <!-- Navigation tabs -->
        <div class="flex flex-wrap mb-6 border-b border-gray-200 dark:border-gray-700">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'px-4 py-2 font-medium',
              activeTab === tab.id
                ? 'text-white bg-orange-600 rounded-t-md'
                : 'text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500'
            ]"
          >
            {{ tab.label }}
          </button>
        </div>

        <!-- Content sections -->
        <div class="tab-content">
          <!-- Overview Section -->
          <div v-if="activeTab === 'overview'" class="content-section">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">API Authentication Overview</h2>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
              <p class="mb-4">Our authentication system allows you to:</p>
              <ul class="space-y-2 list-disc pl-5">
                <li>Register and manage users through our API</li>
                <li>Use JWT tokens for secure authentication</li>
                <li>Integrate user management with your application</li>
                <li>Choose between managing users on our platform or through your application</li>
              </ul>
            </div>
          </div>

          <!-- Getting Started Section -->
          <div v-if="activeTab === 'getting-started'" class="content-section">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Getting Started</h2>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
              <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Step 1: Obtain Your Client ID and Bearer Token</h3>
              <div class="space-y-6">
                <div class="flex items-start">
                  <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-orange-600 text-white font-bold mr-4">1</div>
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Access Your Profile</h4>
                    <p class="text-gray-600 dark:text-gray-300">Click on the profile button in the top right corner of the dashboard (shows your profile picture or your initials if no picture is available).</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-orange-600 text-white font-bold mr-4">2</div>
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Generate API Token</h4>
                    <p class="text-gray-600 dark:text-gray-300">In the popup menu, click on "API Tokens" to open the token generation page.</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-orange-600 text-white font-bold mr-4">3</div>
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Create a New Token</h4>
                    <p class="text-gray-600 dark:text-gray-300">Enter a name for your token and select the permissions you need (Read, Write, Update, Delete).</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-orange-600 text-white font-bold mr-4">4</div>
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Save Your Token</h4>
                    <p class="text-gray-600 dark:text-gray-300 font-medium text-red-600 dark:text-red-400">Click "Create" and copy the token immediately. This token will only be shown once!</p>
                  </div>
                </div>

                <div class="flex items-start">
                  <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-orange-600 text-white font-bold mr-4">5</div>
                  <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-1">Find Your Client ID</h4>
                    <p class="text-gray-600 dark:text-gray-300">Your Client ID is displayed on the Auth API page. Copy this value for API requests.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Authentication Section -->
          <div v-if="activeTab === 'authentication'" class="content-section">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Authentication Flow</h2>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
              <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">How Authentication Works</h3>
              <div class="flex flex-wrap justify-between items-center my-8">
                <div class="w-full md:w-auto flex flex-col items-center text-center mb-4 md:mb-0">
                  <div class="text-4xl mb-3">🔑</div>
                  <div class="font-bold text-gray-900 dark:text-white mb-1">Registration</div>
                  <div class="text-sm text-gray-600 dark:text-gray-300">Register users with email and password</div>
                </div>

                <div class="hidden md:block text-gray-400 dark:text-gray-500 text-xl">→</div>

                <div class="w-full md:w-auto flex flex-col items-center text-center mb-4 md:mb-0">
                  <div class="text-4xl mb-3">🔒</div>
                  <div class="font-bold text-gray-900 dark:text-white mb-1">Login</div>
                  <div class="text-sm text-gray-600 dark:text-gray-300">Authenticate with credentials</div>
                </div>

                <div class="hidden md:block text-gray-400 dark:text-gray-500 text-xl">→</div>

                <div class="w-full md:w-auto flex flex-col items-center text-center mb-4 md:mb-0">
                  <div class="text-4xl mb-3">🎟️</div>
                  <div class="font-bold text-gray-900 dark:text-white mb-1">Tokens</div>
                  <div class="text-sm text-gray-600 dark:text-gray-300">Receive access & refresh tokens</div>
                </div>

                <div class="hidden md:block text-gray-400 dark:text-gray-500 text-xl">→</div>

                <div class="w-full md:w-auto flex flex-col items-center text-center mb-4 md:mb-0">
                  <div class="text-4xl mb-3">🔄</div>
                  <div class="font-bold text-gray-900 dark:text-white mb-1">Refresh</div>
                  <div class="text-sm text-gray-600 dark:text-gray-300">Renew tokens when needed</div>
                </div>
              </div>

              <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">Important Notes</h3>
              <ul class="list-disc pl-5 space-y-2 text-gray-600 dark:text-gray-300">
                <li>Include your <code class="px-1 py-0.5 bg-gray-100 dark:bg-gray-700 rounded text-gray-800 dark:text-gray-200 font-mono">Client-ID</code> in the header of all requests</li>
                <li>Store the refresh token securely (cookies or secure storage)</li>
                <li>Access tokens have a limited lifespan and must be refreshed</li>
                <li>You can validate tokens using the token validation endpoint</li>
              </ul>
            </div>
          </div>

          <!-- Endpoints Section -->
          <div v-if="activeTab === 'endpoints'" class="content-section">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">API Endpoints</h2>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 overflow-hidden">
              <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                <span class="px-2 py-1 rounded text-xs font-bold bg-green-500 text-white mr-2">POST</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">/api/auth/register</span>
              </div>
              <div class="p-4">
                <p class="mb-4 text-gray-600 dark:text-gray-300">Register a new user for your client application.</p>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Headers</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">Client-ID: your_client_id</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Request Body</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "email": "user@example.com",
    "password": "securePassword",
    "name": "John Doe",
    "phone": "1234567890",
    "address": "123 Main St",
    "company": "Example Corp",
    "age": 30
  }</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Response</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "success": true,
    "message": "User registered successfully",
    "data": {
      "user": {
        "id": 1,
        "email": "user@example.com",
        "name": "John Doe",
        // other user fields...
        "access_token": "eyJ0eXAiOi...",
        "refresh_token": "eyJ0eXAiOi..."
      }
    }
  }</pre>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 overflow-hidden">
              <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                <span class="px-2 py-1 rounded text-xs font-bold bg-green-500 text-white mr-2">POST</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">/api/auth/login</span>
              </div>
              <div class="p-4">
                <p class="mb-4 text-gray-600 dark:text-gray-300">Authenticate an existing user.</p>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Headers</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">Client-ID: your_client_id</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Request Body</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "email": "user@example.com",
    "password": "securePassword"
  }</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Response</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "success": true,
    "message": "User Logged in successfully",
    "data": {
      "user": {
        "id": 1,
        "email": "user@example.com",
        // other user fields...
        "access_token": "eyJ0eXAiOi...",
        "refresh_token": "eyJ0eXAiOi..."
      }
    }
  }</pre>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 overflow-hidden">
              <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                <span class="px-2 py-1 rounded text-xs font-bold bg-green-500 text-white mr-2">POST</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">/api/auth/refresh</span>
              </div>
              <div class="p-4">
                <p class="mb-4 text-gray-600 dark:text-gray-300">Refresh expired access tokens.</p>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Headers</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">Refresh-Token: your_refresh_token</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Response</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "success": true,
    "message": "Token refreshed successfully",
    "data": {
      "access_token": "eyJ0eXAiOi...",
      "refresh_token": "eyJ0eXAiOi..."
    }
  }</pre>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 overflow-hidden">
              <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 flex items-center">
                <span class="px-2 py-1 rounded text-xs font-bold bg-green-500 text-white mr-2">POST</span>
                <span class="font-mono text-gray-800 dark:text-gray-200">/api/auth/validate</span>
              </div>
              <div class="p-4">
                <p class="mb-4 text-gray-600 dark:text-gray-300">Validate an access token.</p>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Headers</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm mb-4 overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">Access-Token: your_access_token</pre>

                <h4 class="font-semibold mb-2 text-gray-800 dark:text-white">Response</h4>
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">{
    "success": true,
    "message": "Token is valid",
    "data": {
      "valid": true,
      "message": "Token is valid"
    }
  }</pre>
              </div>
            </div>
          </div>

          <!-- Examples Section -->
          <div v-if="activeTab === 'examples'" class="content-section">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Usage Examples</h2>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
              <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Example: Registering a User</h3>

              <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                <div class="flex">
                  <button
                    @click="codeExample = 'curl'"
                    :class="[
                      'px-4 py-2 font-medium',
                      codeExample === 'curl'
                        ? 'text-orange-600 dark:text-orange-500 border-b-2 border-orange-600 dark:border-orange-500'
                        : 'text-gray-600 dark:text-gray-300'
                    ]"
                  >
                    cURL
                  </button>
                  <button
                    @click="codeExample = 'js'"
                    :class="[
                      'px-4 py-2 font-medium',
                      codeExample === 'js'
                        ? 'text-orange-600 dark:text-orange-500 border-b-2 border-orange-600 dark:border-orange-500'
                        : 'text-gray-600 dark:text-gray-300'
                    ]"
                  >
                    JavaScript
                  </button>
                  <button
                    @click="codeExample = 'php'"
                    :class="[
                      'px-4 py-2 font-medium',
                      codeExample === 'php'
                        ? 'text-orange-600 dark:text-orange-500 border-b-2 border-orange-600 dark:border-orange-500'
                        : 'text-gray-600 dark:text-gray-300'
                    ]"
                  >
                    PHP
                  </button>
                </div>
              </div>

              <div v-if="codeExample === 'curl'">
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">curl -X POST https://api.example.com/api/auth/register \
    -H "Client-ID: your_client_id" \
    -H "Content-Type: application/json" \
    -d '{
      "email": "user@example.com",
      "password": "securePassword",
      "name": "John Doe"
    }'</pre>
              </div>

              <div v-if="codeExample === 'js'">
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">const response = await fetch('https://api.example.com/api/auth/register', {
    method: 'POST',
    headers: {
      'Client-ID': 'your_client_id',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      email: 'user@example.com',
      password: 'securePassword',
      name: 'John Doe'
    })
  });

  const data = await response.json();
  // Store tokens securely
  localStorage.setItem('access_token', data.data.user.access_token);</pre>
              </div>

              <div v-if="codeExample === 'php'">
                <pre class="bg-gray-50 dark:bg-gray-700 p-3 rounded font-mono text-sm overflow-x-auto text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">$ch = curl_init('https://api.example.com/api/auth/register');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Client-ID: your_client_id',
      'Content-Type: application/json'
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      'email' => 'user@example.com',
      'password' => 'securePassword',
      'name' => 'John Doe'
  ]));

  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  // Store tokens securely</pre>
              </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
              <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">User Management Options</h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                  <div class="bg-gray-50 dark:bg-gray-700 px-4 py-2 font-medium text-gray-600 dark:text-gray-300">
                    Option 1
                  </div>
                  <div class="p-4">
                    <h4 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Manage users on our platform</h4>
                    <p class="mb-4 text-gray-600 dark:text-gray-300">Use our dashboard to create, update, and delete users without additional API calls.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <h5 class="font-medium mb-2 text-green-600 dark:text-green-500">Pros</h5>
                        <ul class="list-disc pl-5 text-gray-600 dark:text-gray-300 space-y-1">
                          <li>No additional development required</li>
                          <li>Built-in user management interface</li>
                          <li>Automatic updates and maintenance</li>
                        </ul>
                      </div>
                      <div>
                        <h5 class="font-medium mb-2 text-red-600 dark:text-red-500">Cons</h5>
                        <ul class="list-disc pl-5 text-gray-600 dark:text-gray-300 space-y-1">
                          <li>Less customization</li>
                          <li>Requires accessing our platform</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                  <div class="bg-gray-50 dark:bg-gray-700 px-4 py-2 font-medium text-gray-600 dark:text-gray-300">
                    Option 2
                  </div>
                  <div class="p-4">
                    <h4 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Manage users via API</h4>
                    <p class="mb-4 text-gray-600 dark:text-gray-300">Use our API endpoints to fully integrate user management into your application.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div>
                        <h5 class="font-medium mb-2 text-green-600 dark:text-green-500">Pros</h5>
                        <ul class="list-disc pl-5 text-gray-600 dark:text-gray-300 space-y-1">
                          <li>Complete customization</li>
                          <li>Seamless user experience</li>
                          <li>Full control over the user interface</li>
                        </ul>
                      </div>
                      <div>
                        <h5 class="font-medium mb-2 text-red-600 dark:text-red-500">Cons</h5>
                        <ul class="list-disc pl-5 text-gray-600 dark:text-gray-300 space-y-1">
                          <li>Requires more development</li>
                          <li>Must handle token management</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Footer />
</AppLayout>
  </template>


