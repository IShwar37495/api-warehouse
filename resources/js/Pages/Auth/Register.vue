<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <div
        class="relative flex flex-col items-center min-h-screen py-6 overflow-hidden sm:justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800"
    >
        <!-- Animated background elements -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Floating particles -->
            <div
                class="absolute w-4 h-4 bg-orange-300 rounded-full top-1/4 left-1/4 animate-pulse"
                style="animation-duration: 3s; opacity: 0.6"
            ></div>
            <div
                class="absolute w-6 h-6 bg-orange-400 rounded-full top-3/4 left-1/3 animate-pulse"
                style="animation-duration: 4s; opacity: 0.4"
            ></div>
            <div
                class="absolute w-5 h-5 bg-orange-500 rounded-full top-1/2 right-1/4 animate-pulse"
                style="animation-duration: 5s; opacity: 0.5"
            ></div>
            <div
                class="absolute w-3 h-3 bg-orange-200 rounded-full bottom-1/4 right-1/3 animate-pulse"
                style="animation-duration: 3.5s; opacity: 0.7"
            ></div>

            <!-- Abstract shapes -->
            <svg
                class="absolute top-0 left-0 w-full h-full opacity-10 dark:opacity-5"
                viewBox="0 0 800 800"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M137.5,211.5 C211.5,137.5 280.5,130.5 350.5,130.5 C420.5,130.5 489.5,137.5 563.5,211.5 C637.5,285.5 644.5,354.5 644.5,424.5 C644.5,494.5 637.5,563.5 563.5,637.5 C489.5,711.5 420.5,718.5 350.5,718.5 C280.5,718.5 211.5,711.5 137.5,637.5 C63.5,563.5 56.5,494.5 56.5,424.5 C56.5,354.5 63.5,285.5 137.5,211.5 Z"
                    fill="none"
                    stroke="#fe4d01"
                    stroke-width="1.5"
                />

                <path
                    d="M400,150 C550,150 650,250 650,400 C650,550 550,650 400,650 C250,650 150,550 150,400 C150,250 250,150 400,150 Z"
                    fill="none"
                    stroke="#fe4d01"
                    stroke-width="1"
                    opacity="0.7"
                />

                <defs>
                    <linearGradient
                        id="grad1"
                        x1="0%"
                        y1="0%"
                        x2="100%"
                        y2="100%"
                    >
                        <stop
                            offset="0%"
                            style="stop-color: #fe4d01; stop-opacity: 0.3"
                        />
                        <stop
                            offset="100%"
                            style="stop-color: #fe4d01; stop-opacity: 0"
                        />
                    </linearGradient>
                </defs>
                <circle
                    cx="400"
                    cy="400"
                    r="180"
                    fill="url(#grad1)"
                    opacity="0.2"
                />
            </svg>
        </div>

        <div
            class="relative z-10 flex flex-col w-full max-w-5xl overflow-hidden transition-all duration-300 transform shadow-2xl md:flex-row rounded-2xl"
        >
            <!-- Left side - Image and branding -->
            <div
                class="w-full md:w-2/5 bg-gradient-to-br from-[#fe4d01] to-[#ff6b34] p-8 flex flex-col justify-between text-white relative overflow-hidden"
            >
                <!-- Dynamic grid pattern -->
                <div class="absolute inset-0 opacity-20">
                    <svg
                        class="w-full h-full"
                        viewBox="0 0 400 800"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <pattern
                            id="grid"
                            width="40"
                            height="40"
                            patternUnits="userSpaceOnUse"
                        >
                            <path
                                d="M 40 0 L 0 0 0 40"
                                fill="none"
                                stroke="#fff"
                                stroke-width="1"
                            />
                        </pattern>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <!-- Animated blob shapes -->
                <div
                    class="absolute w-64 h-64 bg-white rounded-full -right-32 -bottom-32 opacity-10 blur-2xl animate-pulse"
                    style="animation-duration: 10s"
                ></div>
                <div
                    class="absolute w-64 h-64 bg-white rounded-full -left-32 -top-32 opacity-10 blur-2xl animate-pulse"
                    style="animation-duration: 15s"
                ></div>

                <div class="relative z-10 mb-10">
                    <!-- Logo with glow effect -->
                    <div class="relative">
                        <div
                            class="absolute inset-0 transform scale-110 bg-white rounded-lg blur-md opacity-20"
                        ></div>
                        <img
                            src="/images/image.png"
                            alt="API Warehouse Logo"
                            class="relative object-contain w-40 h-32 mb-4 animate-float"
                            style="animation: float 6s ease-in-out infinite"
                        />
                    </div>
                    <h1 class="mb-2 text-4xl font-extrabold tracking-tight">
                        API Warehouse
                    </h1>
                    <p class="text-xl font-light opacity-90">
                        Your gateway to the world of APIs
                    </p>
                </div>

                <div class="relative z-10 space-y-5">
                    <div class="flex items-start group">
                        <div
                            class="flex items-center justify-center w-8 h-8 mr-3 transition-transform transform bg-white rounded-full bg-opacity-20 group-hover:scale-110 group-hover:bg-opacity-30"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <p
                            class="text-lg transition-all duration-300 group-hover:translate-x-1"
                        >
                            Access thousands of APIs from a single dashboard
                        </p>
                    </div>
                    <div class="flex items-start group">
                        <div
                            class="flex items-center justify-center w-8 h-8 mr-3 transition-transform transform bg-white rounded-full bg-opacity-20 group-hover:scale-110 group-hover:bg-opacity-30"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <p
                            class="text-lg transition-all duration-300 group-hover:translate-x-1"
                        >
                            Test and integrate APIs with just a few clicks
                        </p>
                    </div>
                    <div class="flex items-start group">
                        <div
                            class="flex items-center justify-center w-8 h-8 mr-3 transition-transform transform bg-white rounded-full bg-opacity-20 group-hover:scale-110 group-hover:bg-opacity-30"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <p
                            class="text-lg transition-all duration-300 group-hover:translate-x-1"
                        >
                            Monitor performance metrics in real-time
                        </p>
                    </div>
                </div>

                <div class="relative z-10 mt-8">
                    <!-- Abstract API visualization with animation -->
                    <div
                        class="relative h-16 overflow-hidden bg-white rounded-lg api-visualization bg-opacity-10"
                    >
                        <div
                            class="absolute inset-y-0 left-0 w-1/3 h-full transform -skew-x-12 bg-white opacity-40 animate-pulse"
                            style="animation-duration: 2s"
                        ></div>
                        <div
                            class="absolute inset-y-0 w-1/4 h-full transform -skew-x-12 bg-white left-1/3 opacity-20 animate-pulse"
                            style="animation-duration: 3s"
                        ></div>
                        <div
                            class="absolute inset-y-0 right-0 w-1/5 h-full transform -skew-x-12 bg-white opacity-30 animate-pulse"
                            style="animation-duration: 2.5s"
                        ></div>

                        <!-- Data points -->
                        <div
                            class="absolute w-2 h-2 bg-white rounded-full top-1/4 left-1/4 animate-ping"
                            style="animation-duration: 4s"
                        ></div>
                        <div
                            class="absolute w-2 h-2 bg-white rounded-full bottom-1/4 right-1/4 animate-ping"
                            style="animation-duration: 5s"
                        ></div>
                        <div
                            class="absolute w-2 h-2 bg-white rounded-full top-1/2 right-1/3 animate-ping"
                            style="animation-duration: 3s"
                        ></div>
                    </div>

                    <!-- Trust badges -->
                    <div
                        class="flex items-center justify-center mt-4 space-x-4 opacity-75"
                    >
                        <div
                            class="px-2 py-1 text-xs font-medium bg-white rounded bg-opacity-20"
                        >
                            Trusted
                        </div>
                        <div
                            class="px-2 py-1 text-xs font-medium bg-white rounded bg-opacity-20"
                        >
                            Secure
                        </div>
                        <div
                            class="px-2 py-1 text-xs font-medium bg-white rounded bg-opacity-20"
                        >
                            Fast
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side - Registration form with glass morphism effect -->
            <div class="w-full p-8 bg-white md:w-3/5 dark:bg-gray-800">
                <div class="mb-6 text-center">
                    <h2
                        class="mb-2 text-2xl font-bold text-gray-800 dark:text-white"
                    >
                        Create Your Account
                    </h2>
                    <p class="font-light text-gray-500 dark:text-gray-400">
                        Join thousands of developers using API Warehouse
                    </p>
                </div>

                <div class="mb-6">
                    <a
                        href="/auth/google"
                        class="flex items-center justify-center w-full px-6 py-3 transition duration-300 transform bg-white border border-gray-300 rounded-lg shadow-sm dark:border-gray-600 dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:-translate-y-1 hover:shadow-lg group"
                    >
                        <svg
                            class="w-6 h-6 mr-3 transition-transform duration-300 group-hover:scale-110"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4"
                            />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853"
                            />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                fill="#FBBC05"
                            />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335"
                            />
                        </svg>
                        <span
                            class="font-medium text-gray-800 dark:text-gray-200"
                            >Continue with Google</span
                        >
                    </a>
                </div>

                <div class="flex items-center my-6">
                    <div
                        class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent dark:via-gray-600"
                    ></div>
                    <div
                        class="px-4 text-sm font-medium text-gray-500 dark:text-gray-400"
                    >
                        or register with email
                    </div>
                    <div
                        class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent dark:via-gray-600"
                    ></div>
                </div>

                <form @submit.prevent="submit">
                    <div class="space-y-5">
                        <div class="group">
                            <InputLabel
                                for="name"
                                value="Full Name"
                                class="font-medium text-gray-700 dark:text-gray-300"
                            />
                            <div
                                class="relative mt-1 overflow-hidden rounded-lg transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-[#fe4d01] group-focus-within:ring-opacity-50"
                            >
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-[#fe4d01]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                </div>
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="block w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 focus:ring-[#fe4d01] focus:border-[#fe4d01] transition-all duration-300 bg-opacity-50"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="John Doe"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="group">
                            <InputLabel
                                for="email"
                                value="Email Address"
                                class="font-medium text-gray-700 dark:text-gray-300"
                            />
                            <div
                                class="relative mt-1 overflow-hidden rounded-lg transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-[#fe4d01] group-focus-within:ring-opacity-50"
                            >
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-[#fe4d01]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="block w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 focus:ring-[#fe4d01] focus:border-[#fe4d01] transition-all duration-300"
                                    required
                                    autocomplete="username"
                                    placeholder="your.email@example.com"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>

                        <div class="group">
                            <InputLabel
                                for="password"
                                value="Password"
                                class="font-medium text-gray-700 dark:text-gray-300"
                            />
                            <div
                                class="relative mt-1 overflow-hidden rounded-lg transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-[#fe4d01] group-focus-within:ring-opacity-50"
                            >
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-[#fe4d01]"
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
                                </div>
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="block w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 focus:ring-[#fe4d01] focus:border-[#fe4d01] transition-all duration-300"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <div class="group">
                            <InputLabel
                                for="password_confirmation"
                                value="Confirm Password"
                                class="font-medium text-gray-700 dark:text-gray-300"
                            />
                            <div
                                class="relative mt-1 overflow-hidden rounded-lg transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-[#fe4d01] group-focus-within:ring-opacity-50"
                            >
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-[#fe4d01]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                        />
                                    </svg>
                                </div>
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="block w-full pl-10 rounded-lg border-gray-300 dark:border-gray-600 focus:ring-[#fe4d01] focus:border-[#fe4d01] transition-all duration-300"
                                    required
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                            </div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <div
                            v-if="
                                $page.props.jetstream
                                    .hasTermsAndPrivacyPolicyFeature
                            "
                        >
                            <InputLabel for="terms">
                                <div class="flex items-center">
                                    <Checkbox
                                        id="terms"
                                        v-model:checked="form.terms"
                                        name="terms"
                                        required
                                        class="text-[#fe4d01] focus:ring-[#fe4d01] transition-all duration-300 transform hover:scale-110"
                                    />

                                    <div
                                        class="text-sm text-gray-600 ms-2 dark:text-gray-400"
                                    >
                                        I agree to the
                                        <a
                                            target="_blank"
                                            :href="route('terms.show')"
                                            class="text-[#fe4d01] font-medium hover:text-orange-600 focus:outline-none underline"
                                            >Terms of Service</a
                                        >
                                        and
                                        <a
                                            target="_blank"
                                            :href="route('policy.show')"
                                            class="text-[#fe4d01] font-medium hover:text-orange-600 focus:outline-none underline"
                                            >Privacy Policy</a
                                        >
                                    </div>
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.terms"
                                />
                            </InputLabel>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-white bg-gradient-to-r from-[#fe4d01] to-[#ff6b34] hover:from-[#ff6b34] hover:to-[#fe4d01] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#fe4d01] font-medium transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg active:scale-95"
                            :class="{
                                'opacity-75 cursor-not-allowed':
                                    form.processing,
                            }"
                            :disabled="form.processing"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                                />
                            </svg>
                            <span class="relative">
                                Create Account
                                <span
                                    class="absolute left-0 w-full h-px transition-transform transform scale-x-0 bg-white opacity-50 -bottom-px group-hover:scale-x-100"
                                ></span>
                            </span>
                        </button>
                    </div>
                </form>

                <div class="flex items-center justify-center mt-6">
                    <span class="text-sm text-gray-600 dark:text-gray-400"
                        >Already have an account?</span
                    >
                    <Link
                        :href="route('login')"
                        class="ml-2 text-sm text-[#fe4d01] font-medium hover:text-orange-600 focus:outline-none transition-all duration-300 hover:underline"
                    >
                        Sign in here
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
