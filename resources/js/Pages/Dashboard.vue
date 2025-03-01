<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
import { ref, onMounted } from "vue";

const apis = ref([
    {
        name: "User Authentication API",
        description: "Secure user authentication and authorization.",
        link: "https://example.com/auth-api",
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
                class="relative py-20 pb-32 overflow-hidden bg-gradient-to-r from-[#FE4D01] to-orange-500 dark:from-gray-900 dark:to-gray-800"
            >
                <div class="max-w-6xl px-4 mx-auto text-center">
                    <h1
                        class="mb-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl dark:text-gray-100"
                    >
                        API Warehouse
                    </h1>
                    <p
                        class="max-w-2xl mx-auto mb-8 text-xl text-white/90 dark:text-gray-300"
                    >
                        Discover and integrate powerful APIs to supercharge your
                        applications
                    </p>
                    <div class="relative z-10 flex justify-center gap-4">
                        <a
                            href="#apis"
                            class="px-6 py-3 text-[#FE4D01] bg-white rounded-full font-bold transition hover:bg-gray-100 hover:shadow-lg dark:bg-gray-900 dark:hover:bg-gray-700 dark:text-white dark:border dark:border-gray-100"
                        >
                            Explore APIs
                        </a>
                        <a
                            href="#"
                            class="px-6 py-3 font-bold text-white transition border-2 border-white rounded-full hover:bg-white/10 dark:border-gray-300 dark:hover:bg-gray-700"
                        >
                            Documentation
                        </a>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div
                    class="absolute w-64 h-64 rounded-full top-10 -left-16 bg-white/10 blur-3xl dark:bg-white/5"
                ></div>
                <div
                    class="absolute rounded-full bottom-5 -right-20 w-80 h-80 bg-white/10 blur-3xl dark:bg-white/5"
                ></div>

                <!-- Wave Separator -->
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
                            fill="#fff"
                            fill-opacity="1"
                            d="M0,96L48,112C96,128,192,160,288,154.7C384,149,480,107,576,96C672,85,768,107,864,138.7C960,171,1056,213,1152,213.3C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
                            class="dark:fill-[#FE4D01] fill-white"
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
                    <a
                        v-for="(api, index) in apis"
                        :key="api.name"
                        :href="api.link"
                        target="_blank"
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
                    </a>
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
