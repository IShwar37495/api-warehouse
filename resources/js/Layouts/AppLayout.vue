<script setup>
import { ref, onMounted } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";

defineProps({
    title: String,
});

const page = usePage();
const isMobileMenuOpen = ref(false);

const logout = () => {
    router.post(route("logout"));
};

// Dark Mode Toggle
const isDarkMode = ref(localStorage.getItem("theme") === "dark");

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle("dark", isDarkMode.value);
    localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
};

onMounted(() => {
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark");
    }
});
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav
                class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-md dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-20">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <Link :href="route('dashboard')">
                                <img
                                    src="/images/image.webp"
                                    alt="API Warehouse Logo"
                                    class="object-contain w-32 h-24 -mt-[3.5rem] -mb-4"
                                />
                            </Link>
                        </div>

                        <!-- Mobile menu button -->
                        <div class="flex items-center sm:hidden">
                            <button
                                @click="isMobileMenuOpen = !isMobileMenuOpen"
                                class="p-2 text-gray-500 rounded-md hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        v-if="!isMobileMenuOpen"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        v-else
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden space-x-1 sm:flex">
                            <NavLink
                                v-if="$page.props.auth.user?.isAdmin"
                                :href="route('admin.api.create')"
                                class="px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                            >
                                Create API
                            </NavLink>

                            <NavLink
                                :href="route('home')"
                                class="px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                            >
                                Home
                            </NavLink>

                            <NavLink
                                :href="route('user.showChatPage')"
                                class="px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                            >
                                Messages
                            </NavLink>

                            <NavLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                                class="px-3 py-2 text-sm font-medium transition-colors duration-200 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                            >
                                Dashboard
                            </NavLink>
                        </div>

                        <!-- Mobile Navigation -->
                        <div
                            v-if="isMobileMenuOpen"
                            class="absolute inset-x-0 p-2 transition origin-top-right transform top-20 sm:hidden"
                        >
                            <div
                                class="bg-white rounded-lg shadow-lg dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
                            >
                                <div class="px-2 pt-2 pb-3 space-y-1">
                                    <NavLink
                                        v-if="$page.props.auth.user?.isAdmin"
                                        :href="route('admin.api.create')"
                                        class="block px-3 py-2 text-base font-medium rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                        active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                                    >
                                        Create API
                                    </NavLink>

                                    <NavLink
                                        :href="route('home')"
                                        class="block px-3 py-2 text-base font-medium rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                        active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                                    >
                                        Home
                                    </NavLink>

                                    <NavLink
                                        :href="route('user.showChatPage')"
                                        class="block px-3 py-2 text-base font-medium rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                        active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                                    >
                                        Messages
                                    </NavLink>

                                    <NavLink
                                        :href="route('dashboard')"
                                        class="block px-3 py-2 text-base font-medium rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                        active-class="text-[#FE4D01] dark:text-[#FE4D01]"
                                    >
                                        Dashboard
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button
                                @click="toggleDarkMode"
                                class="p-2 transition-colors duration-200 border rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-600"
                                aria-label="Toggle dark mode"
                            >
                                <svg
                                    v-if="isDarkMode"
                                    class="w-6 h-6 text-[#FE4D01]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 3v1m0 16v1m-8-8H3m16 0h1m-2.636 5.364l-.707-.707m-9.9 0l-.707.707M4.636 6.364l.707-.707m12.728 0l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    class="w-6 h-6 text-gray-500 dark:text-gray-400 hover:text-[#FE4D01] dark:hover:text-[#FE4D01]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 1020.354 15.354z"
                                    />
                                </svg>
                            </button>

                            <!-- User Dropdown -->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-[#FE4D01] focus:ring-offset-2 dark:focus:ring-[#FE4D01] dark:focus:ring-offset-gray-800"
                                    >
                                        <img
                                            v-if="
                                                $page.props.auth.user
                                                    .profile_photo_url
                                            "
                                            class="object-cover w-10 h-10 rounded-full"
                                            :src="
                                                $page.props.auth.user
                                                    .profile_photo_url
                                            "
                                            :alt="$page.props.auth.user.name"
                                        />

                                        <div
                                            v-else
                                            class="flex items-center justify-center w-10 h-10 text-white bg-[#FE4D01] rounded-full font-bold"
                                        >
                                            {{
                                                $page.props.auth.user.name
                                                    .split(" ")
                                                    .map((n) => n[0])
                                                    .join("")
                                                    .toUpperCase()
                                            }}
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Manage Account
                                    </div>

                                    <DropdownLink
                                        :href="route('profile.show')"
                                        class="transition-colors duration-150 hover:bg-gray-100 hover:text-[#FE4D01] dark:hover:bg-gray-700 dark:hover:text-[#FE4D01]"
                                    >
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink
                                        v-if="
                                            $page.props.jetstream.hasApiFeatures
                                        "
                                        :href="route('api-tokens.index')"
                                        class="transition-colors duration-150 hover:bg-gray-100 hover:text-[#FE4D01] dark:hover:bg-gray-700 dark:hover:text-[#FE4D01]"
                                    >
                                        API Tokens
                                    </DropdownLink>

                                    <div
                                        class="border-t border-gray-200 dark:border-gray-600"
                                    />

                                    <form @submit.prevent="logout">
                                        <DropdownLink
                                            as="button"
                                            class="w-full text-left transition-colors duration-150 hover:bg-gray-100 hover:text-[#FE4D01] dark:hover:bg-gray-700 dark:hover:text-[#FE4D01]"
                                        >
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

<style scoped>
/* Mobile Navigation Styles */
@media (max-width: 640px) {
    .sticky {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 50;
    }

    .absolute {
        position: fixed;
        top: 80px;
        left: 0;
        right: 0;
        z-index: 40;
    }

    main {
        margin-top: 80px;
    }
}

/* Dark Mode Improvements */
.dark .bg-white {
    background-color: #1a1a1a;
}

.dark .text-gray-500 {
    color: #9ca3af;
}

.dark .hover\:bg-gray-100:hover {
    background-color: #2d2d2d;
}

.dark .border-gray-100 {
    border-color: #333;
}

/* NavLink Active State */
.text-\[\#FE4D01\] {
    color: #fe4d01;
}

/* Mobile Menu Animation */
.absolute {
    transition: all 0.3s ease-in-out;
}

/* Ensure proper z-index layering */
.z-50 {
    z-index: 50;
}

.z-40 {
    z-index: 40;
}
</style>
