<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Footer from "@/Layouts/Footer.vue";
</script>

<template>
    <AppLayout title="API Dashboard">
        <h2
            class="text-3xl font-bold leading-tight text-center text-orange-500 dark:text-orange-400"
        >
            POPULAR API'S
        </h2>

        <div
            class="min-h-screen py-12 bg-gradient-to-br from-orange-100 to-white dark:from-gray-900 dark:to-gray-800"
        >
            <div
                class="flex flex-wrap justify-center gap-8 mx-auto max-w-7xl sm:px-6 lg:px-8"
            >
                <div class="api-card" v-for="api in apis" :key="api.name">
                    <a
                        href="https://www.google.com"
                        class="text-xl font-semibold text-gray-800 dark:text-black"
                    >
                        {{ api.name }}
                    </a>
                    <p class="mt-2 text-gray-600 dark:text-black">
                        {{ api.description }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>

    <Footer />
</template>

<script>
export default {
    data() {
        return {
            apis: [
                {
                    name: "User Authentication API",
                    description:
                        "Secure user authentication and authorization.",
                },
                {
                    name: "Real-Time Data API",
                    description:
                        "Fetch and push real-time updates effortlessly.",
                },
                {
                    name: "Payment Gateway API",
                    description: "Process online transactions seamlessly.",
                },
                {
                    name: "Weather Forecast API",
                    description:
                        "Get the latest weather updates and forecasts.",
                },
                {
                    name: "States of India",
                    description: "Get the all states of india.",
                },
            ],
        };
    },
};
</script>

<style>
.api-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 20px;
    width: 280px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.api-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}
</style>
