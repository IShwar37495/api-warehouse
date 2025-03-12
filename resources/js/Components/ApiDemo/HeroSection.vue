<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  docsUrl: {
    type: String,
    default: "/#",
  },
  getStartedUrl: {
    type: String,
    default: "#implementation",
  },
});
</script>


<template>
    <div class="relative py-20 overflow-hidden bg-gradient-to-br from-[#FE4D01] via-orange-500 to-amber-500 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">
      <!-- Animated background elements -->
      <div class="absolute inset-0 z-0">
        <div class="absolute w-80 h-80 rounded-full top-10 -left-20 bg-white/10 blur-3xl animate-pulse"></div>
        <div class="absolute w-96 h-96 rounded-full bottom-10 -right-20 bg-white/10 blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute w-64 h-64 rounded-full top-40 right-20 bg-white/5 blur-3xl animate-pulse" style="animation-delay: 2s"></div>

        <!-- Subtle grid pattern overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/5 to-black/10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNjAgNjBIMFYwaDYwdjYweiIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIi8+PHBhdGggZD0iTTYwIDYwSDBWMGg2MHY2MHpNMzAgMzBoMzBNMzAgMzBWME0zMCAzMEgwTTMwIDMwdjMwIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIgc3Ryb2tlLXdpZHRoPSIuNSIvPjwvc3ZnPg==')]"></div>
      </div>

      <!-- Main content container -->
      <div class="relative z-10 max-w-6xl px-4 mx-auto text-center">
        <!-- Code-like decorative element -->
        <div class="inline-block px-4 py-1 mb-6 text-sm font-mono text-white bg-white/10 rounded-full backdrop-blur-sm">
          <span class="text-amber-300">import</span> <span class="text-white/90">{ ApiClient }</span> <span class="text-amber-300">from</span> <span class="text-green-300">'@our-platform/api'</span>
        </div>

        <!-- Main heading with improved typography -->
        <h1 class="mb-6 text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl">
          <span class="block mb-2">API Integration</span>
          <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-r from-white to-amber-200">Guide</span>
        </h1>

        <!-- Improved subheading with icon -->
        <p class="max-w-2xl mx-auto mb-10 text-xl font-medium text-white/90 flex items-center justify-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-300" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
          </svg>
          Connect your application with our powerful API in minutes
        </p>

        <!-- Feature badges -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
          <span class="px-3 py-1 text-sm font-medium text-white bg-white/10 rounded-full backdrop-blur-sm">REST + GraphQL</span>
          <span class="px-3 py-1 text-sm font-medium text-white bg-white/10 rounded-full backdrop-blur-sm">10,000 free requests</span>
          <span class="px-3 py-1 text-sm font-medium text-white bg-white/10 rounded-full backdrop-blur-sm">99.99% uptime</span>
          <span class="px-3 py-1 text-sm font-medium text-white bg-white/10 rounded-full backdrop-blur-sm">24/7 support</span>
        </div>

        <!-- Enhanced call-to-action buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href= "#implementation" class="px-8 py-4 text-[#FE4D01] bg-white rounded-full font-bold transition-all hover:bg-gray-100 hover:shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Get Started
        </a>
           <Link  :href="docsUrl" class="px-8 py-4 font-bold text-white transition-all border-2 border-white rounded-full hover:bg-white/10 transform hover:-translate-y-1 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
            </svg>
            Full Documentation
        </Link>
        </div>
      </div>

      <!-- Bottom wave with improved animation -->
      <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="w-full h-24 md:h-32">
          <path fill="#ffffff" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,154.7C384,149,480,107,576,96C672,85,768,107,864,138.7C960,171,1056,213,1152,213.3C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" class="dark:fill-gray-900 fill-gray-50"></path>
        </svg>
      </div>

      <!-- Floating code snippet decoration -->
      <div class="absolute right-10 bottom-24 hidden lg:block">
        <div class="p-4 text-left text-sm font-mono text-white bg-black/30 rounded-lg backdrop-blur-md border border-white/10 shadow-xl transform rotate-3 max-w-xs">
          <div class="flex items-center gap-1 mb-2">
            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
          </div>
          <pre class="text-xs whitespace-pre"><span class="text-blue-300">const</span> <span class="text-green-300">api</span> = <span class="text-blue-300">new</span> <span class="text-amber-300">ApiClient</span>(<span class="text-green-300">'YOUR_API_KEY'</span>);

  <span class="text-blue-300">await</span> api.connect();</pre>
        </div>
      </div>
    </div>
  </template>

