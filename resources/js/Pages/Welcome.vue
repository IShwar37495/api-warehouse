<script setup>
import { usePage } from "@inertiajs/vue3";

usePage().props.title = "API Warehouse - Free APIs for Developers";
</script>

<template>
    <main :class="{ dark: isDark }">
        <!-- Updated Navbar Component -->
        <nav
            class="sticky top-0 z-50 flex items-center justify-between h-20 p-5 bg-white shadow-md dark:bg-gray-800"
        >
            <img
                src="/images/image.png"
                alt="API Warehouse Logo"
                class="object-contain w-32 h-24 -mt-[3.5rem] -mb-4"
            />

            <div class="flex items-center gap-4">
                <button
                    @click="toggleDarkMode"
                    class="p-2 border rounded-full dark:border-gray-600"
                >
                    <svg
                        v-if="isDark"
                        class="w-6 h-6 text-yellow-400"
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
                        class="w-6 h-6 text-gray-500 dark:text-gray-400"
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
                <Link
                    v-if="auth.user"
                    :href="route('dashboard')"
                    class="px-4 py-2 border rounded-md dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="px-4 py-2 border rounded-md dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                        Login
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="px-4 py-2 bg-[#FE4D01] text-white rounded-md hover:opacity-80"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </nav>
        <section class="px-5 py-20 text-center bg-gray-50 dark:bg-gray-900">
            <h2 class="mb-5 text-5xl font-extrabold dark:text-white">
                Access Free APIs for Developers
            </h2>
            <p class="mb-8 text-lg text-gray-600 dark:text-gray-300">
                Empower your applications with our free and powerful API
                services.
            </p>
            <button
                class="px-6 py-3 bg-[#FE4D01] text-white rounded-lg text-lg hover:opacity-80"
            >
                Get Started
            </button>
        </section>

        <!-- Features Grid -->
        <section class="px-5 py-16 bg-white dark:bg-gray-800">
            <div class="grid max-w-6xl gap-8 mx-auto md:grid-cols-3">
                <div
                    v-for="feature in features"
                    :key="feature.title"
                    class="p-6 rounded-lg shadow-sm dark:bg-gray-700"
                >
                    <div class="text-[#FE4D01] text-4xl mb-4">
                        {{ feature.icon }}
                    </div>
                    <h3 class="mb-2 text-xl font-bold dark:text-white">
                        {{ feature.title }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ feature.description }}
                    </p>
                </div>
            </div>
        </section>

        <!-- API Demo Section -->
        <section class="px-5 py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-4xl mx-auto">
                <h2 class="mb-8 text-3xl font-bold text-center dark:text-white">
                    Quick Start Guide
                </h2>
                <div class="p-6 bg-gray-800 rounded-lg">
                    <pre class="overflow-x-auto text-gray-100">
  <code class="language-javascript">fetch('https://api-hub.com/v1/data')
    .then(response => response.json())
    .then(data => console.log(data));</code>
            </pre>
                </div>
            </div>
        </section>

        <!-- Testimonials Slider -->
        <section class="px-5 py-16 bg-white dark:bg-gray-800">
            <h2 class="mb-12 text-3xl font-bold text-center dark:text-white">
                What Developers Say
            </h2>
            <div class="relative max-w-3xl mx-auto">
                <div
                    v-for="(testimonial, index) in testimonials"
                    :key="index"
                    v-show="activeTestimonial === index"
                    class="px-8 text-center transition-opacity duration-300"
                >
                    <p class="mb-4 italic text-gray-600 dark:text-gray-300">
                        "{{ testimonial.text }}"
                    </p>
                    <h4 class="font-bold dark:text-white">
                        {{ testimonial.author }}
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ testimonial.role }}
                    </p>
                </div>
                <button
                    @click="prevTestimonial"
                    class="absolute left-0 transform -translate-y-1/2 top-1/2 dark:text-white"
                >
                    ❮
                </button>
                <button
                    @click="nextTestimonial"
                    class="absolute right-0 transform -translate-y-1/2 top-1/2 dark:text-white"
                >
                    ❯
                </button>
            </div>
        </section>

        <!-- Roadmap Section -->
        <section class="px-5 py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-4xl mx-auto">
                <h2
                    class="mb-12 text-3xl font-bold text-center dark:text-white"
                >
                    Development Roadmap
                </h2>
                <div class="relative space-y-8">
                    <div
                        v-for="(item, index) in roadmap"
                        :key="index"
                        class="pl-8 border-l-4 border-[#FE4D01] relative"
                    >
                        <div
                            class="absolute w-4 h-4 bg-[#FE4D01] rounded-full -left-2 top-0"
                        ></div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">
                            {{ item.title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ item.description }}
                        </p>
                        <span
                            class="block mt-2 text-sm text-gray-500 dark:text-gray-400"
                            >{{ item.date }}</span
                        >
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="px-5 py-8 text-white bg-gray-800">
            <div class="max-w-6xl mx-auto text-center">
                <p class="mb-4">© 2024 Apiwarehouse. All rights reserved.</p>
                <div class="flex justify-center gap-6 mb-4">
                    <a href="#" class="hover:text-[#FE4D01]">Documentation</a>
                    <a href="#" class="hover:text-[#FE4D01]">Status</a>
                    <a href="#" class="hover:text-[#FE4D01]">Blog</a>
                </div>
            </div>
        </footer>
    </main>
</template>

<script>
import { Link } from "@inertiajs/vue3";

export default {
    components: {
        Link,
    },
    props: {
        auth: {
            type: Object,
            required: true,
            default: () => ({
                user: null,
            }),
        },
        canRegister: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            isDark: false,
            activeTestimonial: 0,
            features: [
                {
                    icon: "⚡",
                    title: "Lightning Fast",
                    description:
                        "High performance APIs with low latency response times",
                },
                {
                    icon: "🔒",
                    title: "Secure",
                    description:
                        "Enterprise-grade security with HTTPS encryption",
                },
                {
                    icon: "📈",
                    title: "Analytics",
                    description: "Detailed usage statistics and monitoring",
                },
            ],
            testimonials: [
                {
                    text: "API Hub revolutionized our development process. The comprehensive documentation and reliability are unmatched.",
                    author: "Sarah Johnson",
                    role: "Lead Developer at TechCorp",
                },
                {
                    text: "The best free API service I've ever used. It's become an essential part of our stack.",
                    author: "Mike Chen",
                    role: "CTO at StartupX",
                },
            ],
            roadmap: [
                {
                    title: "GraphQL Support",
                    description:
                        "Implement GraphQL endpoints for all existing REST APIs",
                    date: "Q3 2024",
                    status: "planned",
                },
                {
                    title: "Webhooks Integration",
                    description:
                        "Add real-time webhooks support for event-driven architecture",
                    date: "Q4 2024",
                    status: "in-progress",
                },
            ],
        };
    },
    methods: {
        toggleDarkMode() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },
        nextTestimonial() {
            this.activeTestimonial =
                (this.activeTestimonial + 1) % this.testimonials.length;
        },
        prevTestimonial() {
            this.activeTestimonial =
                (this.activeTestimonial - 1 + this.testimonials.length) %
                this.testimonials.length;
        },
    },
    mounted() {
        if (
            localStorage.theme === "dark" ||
            (!("theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            this.isDark = true;
            document.documentElement.classList.add("dark");
        } else {
            this.isDark = false;
            document.documentElement.classList.remove("dark");
        }
    },
};
</script>

<style>
main {
    transition: background-color 0.3s, color 0.3s;
}

pre {
    border-radius: 8px;
    padding: 1rem;
    overflow-x: auto;
    background-color: #1e1e1e;
}
html,
body {
    height: 100%;
    overflow-y: auto;
}
</style>
