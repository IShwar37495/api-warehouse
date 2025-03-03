<template>
    <div
        class="relative py-16 overflow-hidden bg-gradient-to-r from-[#FE4D01] to-orange-500 dark:from-gray-800 dark:to-gray-700"
    >
        <div class="max-w-6xl px-4 mx-auto text-center">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl dark:text-white"
            >
                API Integration Guide
            </h1>
            <p
                class="max-w-2xl mx-auto mb-8 text-xl text-white/90 dark:text-gray-200"
            >
                Connect your application with our powerful API in minutes
            </p>
            <div class="flex justify-center gap-4">
                <a
                    href="#implementation"
                    class="px-6 py-3 text-[#FE4D01] bg-white rounded-full font-bold transition hover:bg-gray-100 hover:shadow-lg dark:bg-gray-900 dark:hover:bg-gray-700 dark:text-white dark:border dark:border-gray-300"
                >
                    Get Started
                </a>
                <a
                    href="/docs"
                    class="px-6 py-3 font-bold text-white transition-colors border-2 border-white rounded-full hover:bg-white/10 dark:border-gray-300 dark:hover:bg-gray-700"
                >
                    Full Documentation
                </a>
            </div>
        </div>
        <div
            class="absolute w-64 h-64 rounded-full top-10 -left-16 bg-white/10 blur-3xl dark:bg-white/5"
        ></div>
        <div
            class="absolute rounded-full bottom-5 -right-20 w-80 h-80 bg-white/10 blur-3xl dark:bg-white/5"
        ></div>
        <div class="absolute bottom-0 left-0 w-full h-24 overflow-hidden">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1440 320"
                class="w-full h-full"
                preserveAspectRatio="none"
            >
                <path
                    fill="#f9fafb"
                    fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,154.7C384,149,480,107,576,96C672,85,768,107,864,138.7C960,171,1056,213,1152,213.3C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                    class="dark:fill-gray-900 fill-gray-50"
                ></path>
            </svg>
        </div>
    </div>
</template>

<script setup>
// No script needed for this component
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
