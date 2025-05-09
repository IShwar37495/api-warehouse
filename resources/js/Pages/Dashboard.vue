<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const apis = ref([
    {
        name: "All Countries API",
        description: "Get all countries and their details.",
        link: route("apiPage.countries"),
        icon: "globe",
    },
    {
        name: "User Authentication API",
        description: "Secure user authentication and authorization.",
        link: route("apiPage.authUser"),
        icon: "shield-lock",
    },
    {
        name: "Real-Time Data API",
        description: "Fetch and push real-time updates effortlessly.",
        link: "https://example.com/realtime-api",
        icon: "activity",
    },
    {
        name: "Payment Gateway API",
        description: "Process online transactions seamlessly.",
        link: "https://example.com/payment-api",
        icon: "credit-card",
    },
    {
        name: "Weather Forecast API",
        description: "Get the latest weather updates and forecasts.",
        link: "https://example.com/weather-api",
        icon: "cloud-sun",
    },
    {
        name: "States of India",
        description: "Get all states of India.",
        link: "https://example.com/states-api",
        icon: "map",
    },
]);

const isVisible = ref(Array(apis.value.length).fill(false));

const animateCards = () => {
    apis.value.forEach((_, index) => {
        setTimeout(() => {
            isVisible.value[index] = true;
        }, 100 * index);
    });
};

onMounted(() => {
    animateCards();
});
</script>

<template>
    <AppLayout title="API Dashboard">
        <div
            class="min-h-screen pb-12 bg-gradient-to-br from-orange-100 to-white dark:from-gray-900 dark:to-gray-800"
        >
            <!-- Hero Section -->
            <div
                class="relative py-20 pb-32 overflow-hidden bg-gradient-to-br from-[#FE4D01] via-orange-500 to-orange-400 dark:from-gray-900 dark:via-gray-800 dark:to-[#FE4D01]/20"
            >
                <!-- Improved decorative elements with animation -->
                <div
                    class="absolute w-72 h-72 rounded-full top-10 -left-16 bg-white/10 blur-3xl dark:bg-[#FE4D01]/10 animate-pulse"
                    style="animation-duration: 8s"
                ></div>
                <div
                    class="absolute rounded-full bottom-5 -right-20 w-96 h-96 bg-white/10 blur-3xl dark:bg-[#FE4D01]/10 animate-pulse"
                    style="animation-duration: 12s"
                ></div>

                <div class="relative z-10 max-w-6xl px-4 mx-auto text-center">
                    <!-- Logo/Icon (optional) -->

                    <h1
                        class="mb-6 text-5xl font-extrabold tracking-tight text-white sm:text-6xl lg:text-7xl drop-shadow-md dark:text-white"
                    >
                        <span class="inline-block">API</span>
                        <span
                            class="inline-block bg-white/10 px-4 py-1 rounded-lg mx-2 backdrop-blur-sm dark:bg-[#FE4D01]/20"
                            >Warehouse</span
                        >
                    </h1>

                    <p
                        class="max-w-2xl mx-auto mb-10 text-xl leading-relaxed text-white dark:text-gray-200"
                    >
                        Discover and integrate powerful APIs to supercharge your
                        applications with just a few clicks.
                    </p>

                    <div
                        class="relative z-10 flex flex-wrap justify-center gap-5"
                    >
                        <a
                            href="#apis"
                            class="px-8 py-4 text-[#FE4D01] bg-white rounded-full font-bold transition-all hover:bg-gray-100 hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-[#FE4D01] dark:border dark:border-gray-600 group"
                        >
                            <span class="flex items-center gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Explore APIs
                            </span>
                        </a>
                        <a
                            href="#"
                            class="px-8 py-4 font-bold text-white transition-all border-2 border-white/80 rounded-full hover:bg-white/15 dark:border-[#FE4D01]/80 dark:text-[#FE4D01] dark:hover:bg-[#FE4D01]/10 hover:-translate-y-1 group"
                        >
                            <span class="flex items-center gap-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Documentation
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Improved Wave Separator with better dark mode support -->
                <div
                    class="absolute bottom-0 left-0 w-full h-24 overflow-hidden"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 1440 320"
                        class="w-full h-full"
                        preserveAspectRatio="none"
                    >
                        <path
                            fill-opacity="1"
                            d="M0,96L48,112C96,128,192,160,288,154.7C384,149,480,107,576,96C672,85,768,107,864,138.7C960,171,1056,213,1152,213.3C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                            class="transition-colors duration-300 fill-white dark:fill-gray-900"
                        ></path>
                    </svg>
                </div>
            </div>

            <!-- API Section -->
            <div id="apis" class="max-w-6xl px-4 mx-auto mt-12">
                <h2 class="mb-12 text-3xl font-bold text-center text-[#FE4D01]">
                    POPULAR APIs
                </h2>

                <!-- Search Bar -->
                <div class="relative max-w-md mx-auto mb-12">
                    <input
                        type="text"
                        placeholder="Search APIs..."
                        class="w-full py-3 pl-10 pr-4 text-gray-700 bg-white border-2 border-gray-200 rounded-full focus:outline-none focus:border-[#FE4D01] dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute w-5 h-5 text-gray-400 left-3 top-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                </div>

                <!-- Grid container -->
                <div
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="(api, index) in apis"
                        :key="api.name"
                        :href="api.link"
                        target="_self"
                        :class="['api-card', isVisible[index] ? 'visible' : '']"
                    >
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-4 text-white rounded-full bg-gradient-to-br from-[#FE4D01] to-orange-600"
                        >
                            <!-- Dynamic Icons based on API type -->
                            <svg
                                v-if="api.icon === 'shield-lock'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                            <svg
                                v-else-if="api.icon === 'activity'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                            <svg
                                v-else-if="api.icon === 'credit-card'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                />
                            </svg>
                            <svg
                                v-else-if="api.icon === 'cloud-sun'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"
                                />
                            </svg>
                            <svg
                                v-else-if="api.icon === 'map'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
                                />
                            </svg>

                            <svg
                                v-else-if="api.icon === 'globe'"
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3C7.03 3 3 7.03 3 12s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 0c2.21 0 4-1.79 4-4m-4 4c-2.21 0-4-1.79-4-4m4 4c-1.1 0-2 .9-2 2m2-2c1.1 0 2 .9 2 2m-2 2c1.1 0 2 .9 2 2m-2-2c-1.1 0-2 .9-2 2m0 0c0 1.1.9 2 2 2m0 0c0 1.1-.9 2-2 2"
                                />
                            </svg>
                        </div>
                        <h2
                            class="mb-2 text-xl font-bold text-gray-800 dark:text-white"
                        >
                            {{ api.name }}
                        </h2>
                        <p class="mb-6 text-gray-600 dark:text-gray-300">
                            {{ api.description }}
                        </p>
                        <div
                            class="inline-block px-4 py-2 text-white rounded-full bg-gradient-to-r from-[#FE4D01] to-orange-500 hover:from-orange-500 hover:to-[#FE4D01] transition-all"
                        >
                            Explore API
                        </div>
                    </Link>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-2 gap-6 mt-20 sm:grid-cols-4">
                    <div
                        class="p-6 text-center bg-white rounded-lg shadow-lg dark:bg-gray-800"
                    >
                        <h3 class="text-4xl font-bold text-[#FE4D01]">100+</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Available APIs
                        </p>
                    </div>
                    <div
                        class="p-6 text-center bg-white rounded-lg shadow-lg dark:bg-gray-800"
                    >
                        <h3 class="text-4xl font-bold text-[#FE4D01]">99.9%</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Uptime
                        </p>
                    </div>
                    <div
                        class="p-6 text-center bg-white rounded-lg shadow-lg dark:bg-gray-800"
                    >
                        <h3 class="text-4xl font-bold text-[#FE4D01]">50M+</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Daily Requests
                        </p>
                    </div>
                    <div
                        class="p-6 text-center bg-white rounded-lg shadow-lg dark:bg-gray-800"
                    >
                        <h3 class="text-4xl font-bold text-[#FE4D01]">5000+</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Happy Developers
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <Footer />
    </AppLayout>
</template>

<style scoped>
.api-card {
    display: block;
    padding: 2rem;
    background: white;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(254, 77, 1, 0.05);
    transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    transform: translateY(50px);
    opacity: 0;
    border-bottom: 4px solid transparent;
}

.api-card.visible {
    transform: translateY(0);
    opacity: 1;
}

.api-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(254, 77, 1, 0.15);
    border-bottom: 4px solid #fe4d01;
}

.dark .api-card {
    background: #1f2937;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.dark .api-card:hover {
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

@keyframes float {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0px);
    }
}
</style>
