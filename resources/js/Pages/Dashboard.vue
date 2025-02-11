<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="API Dashboard">
        <template #header>
            <h2 class="font-bold text-3xl text-orange-500 dark:text-orange-400 leading-tight text-center">
                Welcome to the API Dashboard
            </h2>
        </template>

        <div class="py-12 bg-gradient-to-br from-orange-100 to-white dark:from-gray-900 dark:to-gray-800 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-center gap-8">
                <div class="api-card" v-for="api in apis" :key="api.name">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ api.name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ api.description }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            apis: [
                { name: 'User Authentication API', description: 'Secure user authentication and authorization.' },
                { name: 'Real-Time Data API', description: 'Fetch and push real-time updates effortlessly.' },
                { name: 'Payment Gateway API', description: 'Process online transactions seamlessly.' },
                { name: 'Weather Forecast API', description: 'Get the latest weather updates and forecasts.' }
            ]
        };
    }
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
