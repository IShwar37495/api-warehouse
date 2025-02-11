<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    title: String,
});

const logout = () => {
    router.post(route('logout'));
};

// Dark Mode Toggle
const isDarkMode = ref(localStorage.getItem('theme') === 'dark');

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

onMounted(() => {
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <!-- Logo -->
                        <Link :href="route('dashboard')">
                            <img src="/images/image.png" alt="API Warehouse Logo" class="h-9 w-auto" />
                        </Link>

                        <!-- Navigation -->
                        <div class="flex items-center space-x-4">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>

                            <!-- Dark Mode Toggle -->
                            <button @click="toggleDarkMode" class="p-2 rounded-full border dark:border-gray-600">
                                <svg v-if="isDarkMode" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m-8-8H3m16 0h1m-2.636 5.364l-.707-.707m-9.9 0l-.707.707M4.636 6.364l.707-.707m12.728 0l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
                                </svg>
                                <svg v-else class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 1020.354 15.354z" />
                                </svg>
                            </button>

                            <!-- User Dropdown -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                        <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                    </button>
                                </template>

                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200 dark:border-gray-600" />

                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
